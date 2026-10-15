@extends('layouts.admin-modern')

@section('content')
<div style="background:#f8f9fa; min-height:calc(100vh - 60px); padding:40px 30px;">

    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size:1.8rem; font-weight:700; color:#1a2332; margin-bottom:5px;">
            <i class="fas fa-credit-card me-2" style="color:#00a152;"></i>Pembayaran Online
        </h2>
        <p style="color:#6c757d; margin:0; font-size:0.95rem;">
            ID Transaksi: <strong style="color:#1a2332; font-family:monospace;">{{ $transaksi?->id_transaksi ?? '-' }}</strong>
        </p>
    </div>

    {{-- ============================================================
         FLASH MESSAGES
    ============================================================ --}}
    @if(session('success'))
        <div class="alert mb-4" style="background:linear-gradient(135deg,#10b981,#059669); color:white; border-radius:14px; padding:15px 20px;" data-aos="fade-down">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert mb-4" style="background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border-radius:14px; padding:15px 20px;" data-aos="fade-down">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert mb-4" style="background:linear-gradient(135deg,#ef4444,#dc2626); color:white; border-radius:14px; padding:15px 20px;" data-aos="fade-down">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if(!$transaksi)
        {{-- ─── Transaksi tidak ditemukan ─────────────────────── --}}
        <div style="text-align:center; padding:80px 20px;" data-aos="fade-up">
            <i class="fas fa-receipt" style="font-size:4rem; color:#d1d5db; margin-bottom:20px; display:block;"></i>
            <h5 style="color:#6b7280;">Transaksi tidak ditemukan</h5>
            <a href="{{ route('transaksi.index') }}" class="btn-primary-custom" style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; margin-top:20px;">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Transaksi
            </a>
        </div>
    @else

    {{-- ============================================================
         LAYOUT UTAMA: 2 KOLOM
    ============================================================ --}}
    <div class="row g-4">

        {{-- ─── KOLOM KIRI: Info Transaksi ─────────────────────── --}}
        <div class="col-lg-5" data-aos="fade-right">
            <div style="background:white; border-radius:16px; padding:28px; box-shadow:0 2px 12px rgba(0,0,0,0.07); height:100%;">

                <h5 style="font-weight:700; color:#1a2332; margin-bottom:20px; padding-bottom:12px; border-bottom:2px solid #f3f4f6;">
                    <i class="fas fa-info-circle me-2" style="color:#00a152;"></i>Detail Transaksi
                </h5>

                {{-- Ringkasan nominal --}}
                <div style="background:linear-gradient(135deg,#00a152,#00875a); border-radius:12px; padding:20px; color:white; margin-bottom:20px;">
                    <p style="margin:0 0 4px; font-size:0.82rem; opacity:0.85; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Total Pembayaran</p>
                    <h3 style="margin:0; font-size:2rem; font-weight:700;">
                        Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}
                    </h3>
                </div>

                {{-- Detail baris --}}
                <table style="width:100%; font-size:0.88rem; border-collapse:collapse;">
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280; width:45%;">ID Transaksi</td>
                        <td style="padding:10px 0; font-weight:600; color:#1a2332; font-family:monospace;">{{ $transaksi->id_transaksi }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280;">No. Nota</td>
                        <td style="padding:10px 0; font-weight:600; color:#1a2332;">{{ $transaksi->no_nota }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280;">ID Servis</td>
                        <td style="padding:10px 0; font-weight:600; color:#1a2332;">{{ $transaksi->id_servis ?? '-' }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280;">Layanan</td>
                        <td style="padding:10px 0; color:#374151;">Rp {{ number_format($transaksi->harga_layanan, 0, ',', '.') }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280;">Sparepart</td>
                        <td style="padding:10px 0; color:#374151;">Rp {{ number_format($transaksi->harga_sparepart ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280;">Metode</td>
                        <td style="padding:10px 0;">
                            <span style="background:#dbeafe; color:#1e40af; padding:3px 10px; border-radius:20px; font-size:0.8rem; font-weight:600;">
                                {{ $transaksi->metode_pembayaran }}
                            </span>
                        </td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 0; color:#6b7280;">Status</td>
                        <td style="padding:10px 0;" id="statusPembayaranCell">
                            @php $statusNow = $transaksi->status_pembayaran; @endphp
                            <span id="badgeStatus" style="padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:600;
                                background:{{ $statusNow === 'Lunas' ? '#d1fae5' : '#fef3c7' }};
                                color:{{ $statusNow === 'Lunas' ? '#065f46' : '#92400e' }};">
                                {{ $statusNow }}
                            </span>
                        </td>
                    </tr>
                    @if($transaksi->payment_expired_at)
                    <tr>
                        <td style="padding:10px 0; color:#6b7280;">Kedaluwarsa</td>
                        <td style="padding:10px 0; color:#ef4444; font-size:0.85rem;" id="expiredAtCell">
                            {{ \Carbon\Carbon::parse($transaksi->payment_expired_at)->format('d M Y H:i') }} WIB
                        </td>
                    </tr>
                    @endif
                </table>

            </div>
        </div>

        {{-- ─── KOLOM KANAN: Aksi Pembayaran ───────────────────── --}}
        <div class="col-lg-7" data-aos="fade-left">
            <div style="background:white; border-radius:16px; padding:28px; box-shadow:0 2px 12px rgba(0,0,0,0.07);">

                {{-- Sudah Lunas --}}
                @if($transaksi->status_pembayaran === 'Lunas')
                    <div style="text-align:center; padding:40px 20px;">
                        <div style="width:80px; height:80px; background:#d1fae5; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                            <i class="fas fa-check-circle" style="font-size:2.5rem; color:#10b981;"></i>
                        </div>
                        <h4 style="font-weight:700; color:#065f46; margin-bottom:8px;">Pembayaran Berhasil!</h4>
                        <p style="color:#6b7280; margin-bottom:8px;">
                            Transaksi <strong>{{ $transaksi->id_transaksi }}</strong> telah lunas.
                        </p>
                        @if($transaksi->detail_pembayaran)
                            <p style="color:#6b7280; font-size:0.88rem; margin-bottom:24px;">
                                Dibayar via: <strong>{{ $transaksi->detail_pembayaran }}</strong>
                            </p>
                        @else
                            <p style="margin-bottom:24px;"></p>
                        @endif
                        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                            <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}"
                               style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; background:linear-gradient(135deg,#00a152,#00875a); color:white; border-radius:12px; text-decoration:none; font-weight:600; box-shadow:0 4px 12px rgba(0,161,82,0.35);">
                                <i class="fas fa-print"></i> Cetak Nota
                            </a>
                            <a href="{{ route('transaksi.index') }}"
                               style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; background:white; color:#374151; border:2px solid #e5e7eb; border-radius:12px; text-decoration:none; font-weight:600;">
                                <i class="fas fa-list"></i> Daftar Transaksi
                            </a>
                        </div>
                    </div>

                {{-- Belum Lunas: Snap Token tersedia --}}
                @elseif($transaksi->snap_token)
                    <h5 style="font-weight:700; color:#1a2332; margin-bottom:6px;">
                        <i class="fas fa-mobile-alt me-2" style="color:#00a152;"></i>Selesaikan Pembayaran
                    </h5>
                    <p style="color:#6b7280; font-size:0.9rem; margin-bottom:24px;">
                        Klik tombol di bawah untuk membuka halaman pembayaran Midtrans.
                        Berikan link kepada customer jika pembayaran dilakukan secara mandiri.
                    </p>

                    {{-- Tombol bayar sekarang --}}
                    <button id="btnBayar"
                        onclick="openSnapPayment()"
                        style="display:flex; align-items:center; gap:10px; width:100%; justify-content:center; padding:16px; background:linear-gradient(135deg,#00a152,#00875a); color:white; border:none; border-radius:14px; font-size:1rem; font-weight:700; cursor:pointer; box-shadow:0 6px 20px rgba(0,161,82,0.35); transition:all .2s; margin-bottom:16px;">
                        <i class="fas fa-credit-card" style="font-size:1.2rem;"></i>
                        Bayar Sekarang
                    </button>

                    {{-- Salin link pembayaran --}}
                    @if($transaksi->midtrans_order_id)
                    <div style="background:#f9fafb; border:2px dashed #d1d5db; border-radius:12px; padding:16px; margin-bottom:20px;">
                        <p style="margin:0 0 10px; font-size:0.85rem; font-weight:600; color:#374151;">
                            <i class="fas fa-link me-1" style="color:#6b7280;"></i> Link Pembayaran Midtrans
                        </p>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <input type="text" id="paymentLinkInput" readonly
                                value="{{ route('transaksi.payment', ['id' => $transaksi->id_transaksi]) }}"
                                style="flex:1; border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:0.82rem; background:white; color:#374151; font-family:monospace;">
                            <button onclick="copyPaymentLink()"
                                style="padding:8px 16px; background:#1a2332; color:white; border:none; border-radius:8px; font-size:0.82rem; font-weight:600; cursor:pointer; white-space:nowrap; transition:all .2s;"
                                onmouseover="this.style.background='#2d3748'" onmouseout="this.style.background='#1a2332'">
                                <i class="fas fa-copy me-1"></i> Salin
                            </button>
                        </div>
                        <p style="margin:8px 0 0; font-size:0.78rem; color:#9ca3af;">
                            <i class="fas fa-info-circle me-1"></i>
                            Bagikan link ini ke customer via WhatsApp / pesan.
                        </p>
                    </div>
                    @endif

                    {{-- Status midtrans terkini --}}
                    @if($transaksi->midtrans_transaction_status)
                    <div style="padding:10px 14px; background:#fef3c7; border-radius:8px; margin-bottom:16px; font-size:0.85rem;">
                        <i class="fas fa-clock me-1" style="color:#d97706;"></i>
                        Status Midtrans terakhir: <strong>{{ $transaksi->midtrans_transaction_status }}</strong>
                        @if($transaksi->midtrans_payment_type)
                            via {{ $transaksi->midtrans_payment_type }}
                        @endif
                    </div>
                    @endif

                    {{-- Kembali ke daftar --}}
                    <a href="{{ route('transaksi.index') }}"
                       style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:white; color:#374151; border:2px solid #e5e7eb; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:all .2s;"
                       onmouseover="this.style.borderColor='#00a152'" onmouseout="this.style.borderColor='#e5e7eb'">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>

                {{-- Belum Lunas, tidak ada Snap Token (gagal generate) --}}
                @else
                    <div style="text-align:center; padding:30px 20px;">
                        <div style="width:70px; height:70px; background:#fee2e2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="fas fa-exclamation-triangle" style="font-size:2rem; color:#ef4444;"></i>
                        </div>
                        <h5 style="font-weight:700; color:#991b1b; margin-bottom:8px;">Link Pembayaran Tidak Tersedia</h5>
                        <p style="color:#6b7280; font-size:0.9rem; margin-bottom:20px;">
                            Snap Token belum berhasil di-generate. Kemungkinan koneksi ke Midtrans terputus saat transaksi dibuat.
                            Transaksi sudah tersimpan di database dengan status <strong>Belum Lunas</strong>.
                        </p>
                        <p style="color:#6b7280; font-size:0.85rem; margin-bottom:24px;">
                            Hubungi developer atau coba ubah ke metode pembayaran manual dari halaman manajemen transaksi.
                        </p>
                        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                            <a href="{{ route('transaksi.index') }}"
                               style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; background:#1a2332; color:white; border-radius:12px; text-decoration:none; font-weight:600;">
                                <i class="fas fa-list"></i> Daftar Transaksi
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>{{-- end row --}}

    @endif {{-- end if $transaksi --}}
</div>
@endsection

{{-- ============================================================
     SNAP.JS + LOGIKA PEMBAYARAN
============================================================ --}}
@push('scripts')
@if($transaksi && $transaksi->snap_token && $transaksi->status_pembayaran !== 'Lunas')
{{-- Load Snap.js dari CDN yang sesuai environment (Sandbox / Production) --}}
<script
    src="{{ app(\App\Services\MidtransService::class)->getSnapJsUrl() }}"
    data-client-key="{{ app(\App\Services\MidtransService::class)->getClientKey() }}">
</script>
<script>
    const snapToken = "{{ $transaksi->snap_token }}";

    /**
     * Buka popup Snap Midtrans.
     * onSuccess   : pembayaran dikonfirmasi oleh Snap — reload untuk cek status terbaru
     * onPending   : pembayaran pending (transfer VA, dll) — beri info ke user
     * onError     : error dari Snap
     * onClose     : customer tutup popup tanpa bayar
     */
    function openSnapPayment() {
        const btn = document.getElementById('btnBayar');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
        }

        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                // Pembayaran berhasil di sisi Snap — webhook akan memperbarui DB
                // Reload setelah jeda singkat agar ada waktu webhook tiba
                showStatusMessage('Pembayaran berhasil! Memperbarui status...', 'success');
                setTimeout(() => window.location.reload(), 2000);
            },
            onPending: function(result) {
                showStatusMessage(
                    'Pembayaran menunggu konfirmasi. Status akan diperbarui otomatis setelah pembayaran dikonfirmasi.',
                    'pending'
                );
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-credit-card" style="font-size:1.2rem;"></i> Bayar Sekarang';
                }
            },
            onError: function(result) {
                showStatusMessage('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.', 'error');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-credit-card" style="font-size:1.2rem;"></i> Bayar Sekarang';
                }
            },
            onClose: function() {
                // Customer tutup popup tanpa menyelesaikan pembayaran
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-credit-card" style="font-size:1.2rem;"></i> Bayar Sekarang';
                }
            }
        });
    }

    /**
     * Salin link halaman pembayaran ke clipboard.
     */
    function copyPaymentLink() {
        const input = document.getElementById('paymentLinkInput');
        if (!input) return;
        input.select();
        input.setSelectionRange(0, 99999); // Mobile
        try {
            document.execCommand('copy');
            showStatusMessage('Link pembayaran berhasil disalin!', 'success');
        } catch (e) {
            navigator.clipboard?.writeText(input.value).then(() => {
                showStatusMessage('Link pembayaran berhasil disalin!', 'success');
            });
        }
    }

    /**
     * Tampilkan pesan status sementara di atas halaman.
     */
    function showStatusMessage(message, type) {
        const colors = {
            success : 'linear-gradient(135deg,#10b981,#059669)',
            pending : 'linear-gradient(135deg,#f59e0b,#d97706)',
            error   : 'linear-gradient(135deg,#ef4444,#dc2626)',
        };
        const icons = {
            success: 'fa-check-circle',
            pending: 'fa-clock',
            error  : 'fa-times-circle',
        };
        const div = document.createElement('div');
        div.style.cssText = `
            position:fixed; top:20px; left:50%; transform:translateX(-50%);
            background:${colors[type] || colors.pending};
            color:white; padding:14px 24px; border-radius:12px;
            box-shadow:0 8px 24px rgba(0,0,0,0.2); z-index:9999;
            font-weight:600; font-size:0.95rem; max-width:90vw; text-align:center;
        `;
        div.innerHTML = `<i class="fas ${icons[type] || 'fa-info-circle'} me-2"></i>${message}`;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 4000);
    }
</script>
@endif
@endpush
