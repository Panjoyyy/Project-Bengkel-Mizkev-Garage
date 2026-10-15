<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Transaksi;
use App\Models\Sparepart;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * PaymentController
 *
 * Menangani dua hal utama:
 *  1. Webhook notifikasi dari server Midtrans (POST /payment/webhook)
 *     - Route ini PUBLIK (bebas dari auth middleware)
 *     - Dikecualikan dari CSRF verification
 *
 *  2. Halaman redirect callback setelah customer selesai dari halaman Midtrans
 *     - finish   : Pembayaran berhasil / customer klik "Kembali ke merchant"
 *     - unfinish : Customer belum menyelesaikan pembayaran
 *     - error    : Terjadi error di sisi Midtrans
 */
class PaymentController extends Controller
{
    public function __construct(
        protected MidtransService $midtrans
    ) {}

    // =========================================================================
    // WEBHOOK — dipanggil oleh server Midtrans, bukan browser
    // =========================================================================

    /**
     * Menerima dan memproses notifikasi HTTP dari Midtrans.
     *
     * Alur:
     *  1. Decode payload JSON
     *  2. Verifikasi signature_key (SHA512)
     *  3. Cari transaksi berdasarkan midtrans_order_id
     *  4. Cek idempotency — skip jika sudah Lunas
     *  5. Jika settlement/capture → update status ke Lunas
     *  6. Jika expire/cancel/deny → restore stok sparepart
     *  7. Update midtrans_transaction_status di semua kasus
     *
     * @return JsonResponse  Midtrans mengharapkan HTTP 200 sebagai ACK
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        // 1. Ambil payload JSON dari body request
        $notification = $request->json()->all();

        // Log seluruh notifikasi untuk keperluan debugging / audit
        Log::info('[Midtrans Webhook] Notifikasi diterima', [
            'order_id'           => $notification['order_id']            ?? null,
            'transaction_status' => $notification['transaction_status']   ?? null,
            'payment_type'       => $notification['payment_type']         ?? null,
            'gross_amount'       => $notification['gross_amount']         ?? null,
        ]);

        // 2. Verifikasi Signature Key
        if (!$this->midtrans->verifySignature($notification)) {
            Log::warning('[Midtrans Webhook] Signature tidak valid', [
                'order_id'          => $notification['order_id'] ?? null,
                'signature_key'     => $notification['signature_key'] ?? null,
            ]);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }

        $orderId           = $notification['order_id']            ?? '';
        $transactionStatus = $notification['transaction_status']   ?? '';
        $fraudStatus       = $notification['fraud_status']         ?? 'accept';
        $paymentType       = $notification['payment_type']         ?? '';
        $grossAmount       = (float) ($notification['gross_amount'] ?? 0);

        // 3. Cari transaksi berdasarkan midtrans_order_id
        $transaksi = Transaksi::where('midtrans_order_id', $orderId)->first();

        if (!$transaksi) {
            Log::warning('[Midtrans Webhook] Transaksi tidak ditemukan', ['order_id' => $orderId]);
            // Tetap return 200 agar Midtrans tidak retry berulang kali
            return response()->json(['status' => 'ok', 'message' => 'Order not found, acknowledged'], 200);
        }

        // 4. Cek idempotency — jika sudah Lunas, tidak perlu diproses ulang
        if ($transaksi->status_pembayaran === 'Lunas') {
            Log::info('[Midtrans Webhook] Transaksi sudah Lunas, dilewati', ['order_id' => $orderId]);
            return response()->json(['status' => 'ok', 'message' => 'Already settled'], 200);
        }

        // 5. Verifikasi gross_amount — pastikan nominal cocok dengan data di database
        //    Toleransi pembulatan 1 rupiah untuk menghindari false negative floating point
        if (abs($grossAmount - (float) $transaksi->subtotal) > 1) {
            Log::error('[Midtrans Webhook] Nominal tidak cocok', [
                'order_id'       => $orderId,
                'gross_amount'   => $grossAmount,
                'subtotal_db'    => $transaksi->subtotal,
            ]);
            return response()->json(['status' => 'error', 'message' => 'Amount mismatch'], 400);
        }

        // 6. Proses berdasarkan status pembayaran
        DB::beginTransaction();
        try {
            if ($this->midtrans->isPaymentSuccess($transactionStatus, $fraudStatus)) {
                // ─── PEMBAYARAN BERHASIL ───────────────────────────────────
                $transaksi->update([
                    'status_pembayaran'           => 'Lunas',
                    'midtrans_transaction_status' => $transactionStatus,
                    'midtrans_payment_type'       => $paymentType,
                    'detail_pembayaran'           => $this->resolveDetailPembayaran($paymentType, $notification),
                ]);

                Log::info('[Midtrans Webhook] Pembayaran berhasil — status diupdate ke Lunas', [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'order_id'     => $orderId,
                    'payment_type' => $paymentType,
                ]);

            } elseif ($this->midtrans->isPaymentFailed($transactionStatus)) {
                // ─── PEMBAYARAN GAGAL / EXPIRED / DIBATALKAN ──────────────
                $this->restoreStokSparepart($transaksi);

                $transaksi->update([
                    'midtrans_transaction_status' => $transactionStatus,
                    'midtrans_payment_type'       => $paymentType,
                    // status_pembayaran tetap 'Belum Lunas'
                ]);

                Log::info('[Midtrans Webhook] Pembayaran gagal/expired — stok sparepart dikembalikan', [
                    'id_transaksi'       => $transaksi->id_transaksi,
                    'order_id'           => $orderId,
                    'transaction_status' => $transactionStatus,
                ]);

            } else {
                // ─── STATUS LAIN: pending, authorize, dll ─────────────────
                // Catat status terbaru tapi tidak ubah status pembayaran
                $transaksi->update([
                    'midtrans_transaction_status' => $transactionStatus,
                    'midtrans_payment_type'       => $paymentType,
                ]);

                Log::info('[Midtrans Webhook] Status intermediate diterima', [
                    'id_transaksi'       => $transaksi->id_transaksi,
                    'transaction_status' => $transactionStatus,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[Midtrans Webhook] Exception saat memproses notifikasi', [
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);
            // Kembalikan 500 agar Midtrans tahu ada masalah dan akan retry
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }

        return response()->json(['status' => 'ok'], 200);
    }

    // =========================================================================
    // CALLBACK PAGES — redirect setelah customer selesai di Midtrans
    // =========================================================================

    /**
     * Callback: Pembayaran berhasil atau customer klik "Kembali ke merchant".
     * Midtrans memanggil ini via GET redirect, bukan server-to-server.
     * Status sebenarnya dikonfirmasi melalui webhook, bukan dari sini.
     */
    public function paymentFinish(Request $request, string $id)
    {
        $transaksi = Transaksi::find($id);
        return view('payment-pending', [
            'transaksi'   => $transaksi,
            'callbackType'=> 'finish',
            'title'       => 'Status Pembayaran',
        ]);
    }

    /**
     * Callback: Customer belum menyelesaikan pembayaran (tutup halaman Snap).
     */
    public function paymentUnfinish(Request $request, string $id)
    {
        $transaksi = Transaksi::find($id);
        return view('payment-pending', [
            'transaksi'    => $transaksi,
            'callbackType' => 'unfinish',
            'title'        => 'Pembayaran Belum Selesai',
        ]);
    }

    /**
     * Callback: Terjadi error di Midtrans.
     */
    public function paymentError(Request $request, string $id)
    {
        $transaksi = Transaksi::find($id);
        return view('payment-pending', [
            'transaksi'    => $transaksi,
            'callbackType' => 'error',
            'title'        => 'Pembayaran Gagal',
        ]);
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Mengembalikan stok sparepart yang sudah dikurangi saat transaksi dibuat.
     * Logika ini sama persis dengan TransaksiController::destroy().
     */
    private function restoreStokSparepart(Transaksi $transaksi): void
    {
        if (empty($transaksi->id_sparepart) || empty($transaksi->jumlah_sparepart)) {
            return;
        }

        $sparepartIds = json_decode($transaksi->id_sparepart, true)  ?? [];
        $jumlahs      = json_decode($transaksi->jumlah_sparepart, true) ?? [];

        foreach ($sparepartIds as $spId) {
            $sp = Sparepart::find($spId);
            if ($sp) {
                $sp->stok_sparepart += (int) ($jumlahs[$spId] ?? 0);
                $sp->save();
                Log::info('[Midtrans Webhook] Stok dikembalikan', [
                    'sparepart'  => $sp->nama_sparepart,
                    'jumlah'     => $jumlahs[$spId] ?? 0,
                    'stok_baru'  => $sp->stok_sparepart,
                ]);
            }
        }
    }

    /**
     * Membentuk string deskripsi metode pembayaran untuk kolom detail_pembayaran.
     * Contoh: "gopay", "bca_va", "indomaret", "credit_card"
     */
    private function resolveDetailPembayaran(string $paymentType, array $notification): string
    {
        return match ($paymentType) {
            'bank_transfer'   => 'Transfer Bank: ' . strtoupper($notification['va_numbers'][0]['bank'] ?? ''),
            'echannel'        => 'Mandiri Bill',
            'cstore'          => 'Convenience Store: ' . ucfirst($notification['store'] ?? ''),
            'qris'            => 'QRIS: ' . ($notification['acquirer'] ?? 'QRIS'),
            'gopay'           => 'GoPay',
            'shopeepay'       => 'ShopeePay',
            'credit_card'     => 'Kartu Kredit',
            default           => ucfirst(str_replace('_', ' ', $paymentType)),
        };
    }
}
