<?php

namespace App\Services;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * MidtransService
 *
 * Menangani seluruh komunikasi dengan Midtrans Snap API:
 *  - Membuat Snap Token untuk halaman pembayaran
 *  - Verifikasi Signature Key dari notifikasi webhook
 *  - Pemetaan status Midtrans ke status internal aplikasi
 *
 * Konfigurasi:
 *  - services.midtrans.server_key  : Server Key dari dashboard Midtrans
 *  - services.midtrans.client_key  : Client Key dari dashboard Midtrans
 *  - services.midtrans.is_production : true untuk Production, false untuk Sandbox
 *  - services.midtrans.snap_url    : URL Snap API (diset otomatis berdasarkan environment)
 */
class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool   $isProduction;
    protected string $snapUrl;

    public function __construct()
    {
        $this->serverKey    = config('services.midtrans.server_key', '');
        $this->clientKey    = config('services.midtrans.client_key', '');
        $this->isProduction = (bool) config('services.midtrans.is_production', false);

        // URL Snap API berbeda antara Sandbox dan Production
        $this->snapUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    // =========================================================================
    // 1. BUAT SNAP TOKEN
    // =========================================================================

    /**
     * Membuat Snap Token dari Midtrans berdasarkan data transaksi.
     *
     * Snap Token digunakan oleh Snap.js di sisi frontend untuk membuka
     * popup / redirect ke halaman pembayaran Midtrans.
     *
     * @param  Transaksi $transaksi  — Model transaksi yang sudah tersimpan di DB
     * @return array{snap_token: string, redirect_url: string}
     * @throws \RuntimeException jika Midtrans mengembalikan error
     */
    public function createSnapToken(Transaksi $transaksi): array
    {
        // Resolve data customer melalui chain relasi yang sudah ada
        // transaksi → servis → motor → customer
        $servis   = $transaksi->servis;
        $motor    = $servis?->motor;
        $customer = $motor?->customer;

        // Payload yang dikirim ke Midtrans Snap API
        $payload = [
            'transaction_details' => [
                'order_id'     => $transaksi->midtrans_order_id,
                'gross_amount' => (int) $transaksi->subtotal, // Midtrans hanya menerima integer (rupiah bulat)
            ],
            'customer_details' => [
                'first_name' => $customer?->nama_customer ?? 'Customer',
                'phone'      => $customer?->no_telp_customer ?? '',
                'email'      => $customer?->email_customer ?? '',
            ],
            // Item details opsional — memudahkan rekonsiliasi di dashboard Midtrans
            'item_details' => [
                [
                    'id'       => 'LAYANAN-' . $transaksi->id_transaksi,
                    'price'    => (int) $transaksi->harga_layanan,
                    'quantity' => 1,
                    'name'     => 'Jasa Servis - ' . ($servis?->id_servis ?? '-'),
                ],
                [
                    'id'       => 'SPAREPART-' . $transaksi->id_transaksi,
                    'price'    => (int) ($transaksi->harga_sparepart ?? 0),
                    'quantity' => 1,
                    'name'     => 'Sparepart',
                ],
            ],
            // Callback URL setelah pembayaran selesai / dibatalkan / error
            'callbacks' => [
                'finish'   => route('transaksi.payment.finish',   ['id' => $transaksi->id_transaksi]),
                'unfinish' => route('transaksi.payment.unfinish', ['id' => $transaksi->id_transaksi]),
                'error'    => route('transaksi.payment.error',    ['id' => $transaksi->id_transaksi]),
            ],
        ];

        // Hanya sertakan item_details jika total item == gross_amount
        // Jika harga_sparepart = 0, item sparepart menyebabkan mismatch 0 Snap akan reject
        // Gunakan item_details sederhana jika sparepart = 0
        if ((int)($transaksi->harga_sparepart ?? 0) === 0) {
            $payload['item_details'] = [
                [
                    'id'       => 'TOTAL-' . $transaksi->id_transaksi,
                    'price'    => (int) $transaksi->subtotal,
                    'quantity' => 1,
                    'name'     => 'Pembayaran Servis Motor - ' . ($servis?->id_servis ?? '-'),
                ],
            ];
        }

        // Kirim request ke Midtrans Snap API menggunakan Basic Auth (server_key sebagai username)
        $response = Http::withBasicAuth($this->serverKey, '')
            ->timeout(30)
            ->post($this->snapUrl, $payload);

        if (!$response->successful()) {
            $errorBody = $response->json();
            $errorMsg  = $errorBody['error_messages'][0] ?? $response->body();
            Log::error('[Midtrans] Gagal membuat Snap Token', [
                'order_id'   => $transaksi->midtrans_order_id,
                'status'     => $response->status(),
                'error'      => $errorMsg,
            ]);
            throw new \RuntimeException('Midtrans error: ' . $errorMsg);
        }

        $data = $response->json();
        return [
            'snap_token'   => $data['token'],
            'redirect_url' => $data['redirect_url'],
        ];
    }

    // =========================================================================
    // 2. VERIFIKASI SIGNATURE KEY
    // =========================================================================

    /**
     * Memverifikasi signature_key dari notifikasi webhook Midtrans.
     *
     * Formula Midtrans:
     *   SHA512( order_id + status_code + gross_amount + server_key )
     *
     * @param  array $notification  — Payload JSON dari Midtrans webhook
     * @return bool  true jika signature valid
     */
    public function verifySignature(array $notification): bool
    {
        $orderId     = $notification['order_id']     ?? '';
        $statusCode  = $notification['status_code']  ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';

        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $this->serverKey
        );

        $receivedSignature = $notification['signature_key'] ?? '';

        // Gunakan hash_equals untuk mencegah timing attack
        return hash_equals($expectedSignature, $receivedSignature);
    }

    // =========================================================================
    // 3. MAPPING STATUS MIDTRANS → STATUS INTERNAL
    // =========================================================================

    /**
     * Menentukan apakah transaksi dianggap berhasil berdasarkan status Midtrans.
     *
     * Status yang dianggap berhasil (pembayaran dikonfirmasi):
     *  - 'settlement' : Pembayaran sukses dan sudah di-settle
     *  - 'capture'    : Pembayaran kartu kredit berhasil di-capture
     *
     * @param  string $transactionStatus
     * @param  string $fraudStatus
     * @return bool
     */
    public function isPaymentSuccess(string $transactionStatus, string $fraudStatus = 'accept'): bool
    {
        if ($transactionStatus === 'settlement') {
            return true;
        }

        // capture hanya relevan untuk kartu kredit
        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            return true;
        }

        return false;
    }

    /**
     * Menentukan apakah pembayaran perlu di-reverse (stok dikembalikan).
     *
     * Status yang memerlukan restore:
     *  - 'expire'  : Link pembayaran kedaluwarsa
     *  - 'cancel'  : Transaksi dibatalkan (oleh merchant atau sistem)
     *  - 'deny'    : Pembayaran ditolak oleh bank / Midtrans fraud detection
     *
     * @param  string $transactionStatus
     * @return bool
     */
    public function isPaymentFailed(string $transactionStatus): bool
    {
        return in_array($transactionStatus, ['expire', 'cancel', 'deny'], true);
    }

    // =========================================================================
    // 4. GETTER
    // =========================================================================

    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    /**
     * URL Snap.js CDN — berbeda antara Sandbox dan Production.
     */
    public function getSnapJsUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }
}
