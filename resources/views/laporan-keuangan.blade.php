@extends('layouts.admin-modern')

@section('content')
<div style="background: #f8f9fa; min-height: calc(100vh - 60px); padding: 30px;">

    {{-- ================================================================
         HEADER
    ================================================================ --}}
    <div class="d-flex justify-content-between align-items-start mb-4" data-aos="fade-down">
        <div>
            <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                <i class="fas fa-chart-line me-2" style="color: #00a152;"></i>Laporan Keuangan
            </h2>
            <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">
                Periode: <strong style="color: #1a2332;">{{ $labelPeriode }}</strong>
            </p>
        </div>
        {{-- Tombol cetak halaman --}}
        <button onclick="window.print()" class="btn-primary-custom" style="display:flex; align-items:center; gap:8px; white-space:nowrap;">
            <i class="fas fa-print"></i> <span>Cetak Laporan</span>
        </button>
    </div>

    {{-- ================================================================
         FILTER PERIODE
    ================================================================ --}}
    <div class="card mb-4" style="border:none; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.07);" data-aos="fade-up">
        <div class="card-body" style="padding: 20px 25px;">
            <form method="GET" action="{{ route('laporan-keuangan') }}" id="filterForm">

                {{-- Tombol filter cepat --}}
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <span style="font-weight:600; color:#1a2332; font-size:0.9rem; margin-right:4px;">
                        <i class="fas fa-filter me-1" style="color:#00a152;"></i>Periode:
                    </span>
                    @foreach([
                        'hari_ini'   => 'Hari Ini',
                        'minggu_ini' => 'Minggu Ini',
                        'bulan_ini'  => 'Bulan Ini',
                        'tahun_ini'  => 'Tahun Ini',
                        'custom'     => 'Custom',
                    ] as $val => $label)
                        <button type="submit" name="filter" value="{{ $val }}"
                            @if($filter === $val) style="background:linear-gradient(135deg,#00a152,#00875a); color:white; border:none; padding:8px 18px; border-radius:20px; font-weight:600; font-size:0.85rem; cursor:pointer; box-shadow:0 3px 10px rgba(0,161,82,0.35);"
                            @else style="background:white; color:#4b5563; border:2px solid #e5e7eb; padding:8px 18px; border-radius:20px; font-weight:500; font-size:0.85rem; cursor:pointer; transition:all .2s;" onmouseover="this.style.borderColor='#00a152'" onmouseout="this.style.borderColor='#e5e7eb'"
                            @endif>
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Input custom tanggal --}}
                <div id="customDateSection" style="display: {{ $filter === 'custom' ? 'flex' : 'none' }}; flex-wrap:wrap; align-items:center; gap:12px; padding:16px 20px; background:#f3f4f6; border-radius:12px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <label style="font-weight:600; color:#374151; font-size:0.88rem; white-space:nowrap;">Dari:</label>
                        <input type="date" name="date_from" id="dateFrom"
                            value="{{ $filter === 'custom' ? $dateFrom->format('Y-m-d') : '' }}"
                            max="{{ date('Y-m-d') }}"
                            style="border:2px solid #d1d5db; border-radius:8px; padding:7px 12px; font-size:0.88rem; color:#1a2332;">
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <label style="font-weight:600; color:#374151; font-size:0.88rem; white-space:nowrap;">Sampai:</label>
                        <input type="date" name="date_to" id="dateTo"
                            value="{{ $filter === 'custom' ? $dateTo->format('Y-m-d') : '' }}"
                            max="{{ date('Y-m-d') }}"
                            style="border:2px solid #d1d5db; border-radius:8px; padding:7px 12px; font-size:0.88rem; color:#1a2332;">
                    </div>
                    <button type="submit" name="filter" value="custom"
                        style="background:linear-gradient(135deg,#00a152,#00875a); color:white; border:none; padding:8px 20px; border-radius:8px; font-weight:600; font-size:0.88rem; cursor:pointer;">
                        <i class="fas fa-search me-1"></i> Terapkan
                    </button>
                </div>

                {{-- Pertahankan nilai custom date saat filter cepat aktif --}}
                @if($filter !== 'custom')
                    <input type="hidden" name="date_from" value="">
                    <input type="hidden" name="date_to" value="">
                @endif

            </form>
        </div>
    </div>

    {{-- ================================================================
         SUMMARY CARDS
    ================================================================ --}}
    <div class="row g-3 mb-4">

        {{-- Total Pendapatan --}}
        <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="50">
            <div style="background:linear-gradient(135deg,#00a152,#00875a); border-radius:16px; padding:24px; color:white; box-shadow:0 6px 20px rgba(0,161,82,0.35); position:relative; overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-30px;right:20px;width:70px;height:70px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                <p style="margin:0 0 8px; font-size:0.82rem; font-weight:600; opacity:0.9; text-transform:uppercase; letter-spacing:0.5px;">Total Pendapatan</p>
                <h3 style="margin:0 0 4px; font-size:1.6rem; font-weight:700;">
                    Rp {{ number_format($summary->total_pendapatan, 0, ',', '.') }}
                </h3>
                <small style="opacity:0.8; font-size:0.78rem;"><i class="fas fa-calendar-alt me-1"></i>{{ $labelPeriode }}</small>
            </div>
        </div>

        {{-- Jumlah Transaksi --}}
        <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div style="background:linear-gradient(135deg,#3b82f6,#2563eb); border-radius:16px; padding:24px; color:white; box-shadow:0 6px 20px rgba(59,130,246,0.35); position:relative; overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-30px;right:20px;width:70px;height:70px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                <p style="margin:0 0 8px; font-size:0.82rem; font-weight:600; opacity:0.9; text-transform:uppercase; letter-spacing:0.5px;">Jumlah Transaksi</p>
                <h3 style="margin:0 0 4px; font-size:1.6rem; font-weight:700;">
                    {{ number_format($summary->jumlah_transaksi, 0, ',', '.') }}
                </h3>
                <small style="opacity:0.8; font-size:0.78rem;"><i class="fas fa-receipt me-1"></i>Transaksi tercatat</small>
            </div>
        </div>

        {{-- Pendapatan Layanan --}}
        <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
            <div style="background:linear-gradient(135deg,#f59e0b,#d97706); border-radius:16px; padding:24px; color:white; box-shadow:0 6px 20px rgba(245,158,11,0.35); position:relative; overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-30px;right:20px;width:70px;height:70px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                <p style="margin:0 0 8px; font-size:0.82rem; font-weight:600; opacity:0.9; text-transform:uppercase; letter-spacing:0.5px;">Pendapatan Layanan</p>
                <h3 style="margin:0 0 4px; font-size:1.6rem; font-weight:700;">
                    Rp {{ number_format($summary->total_layanan, 0, ',', '.') }}
                </h3>
                <small style="opacity:0.8; font-size:0.78rem;"><i class="fas fa-tools me-1"></i>Dari jasa servis</small>
            </div>
        </div>

        {{-- Pendapatan Sparepart --}}
        <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div style="background:linear-gradient(135deg,#8b5cf6,#7c3aed); border-radius:16px; padding:24px; color:white; box-shadow:0 6px 20px rgba(139,92,246,0.35); position:relative; overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-30px;right:20px;width:70px;height:70px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                <p style="margin:0 0 8px; font-size:0.82rem; font-weight:600; opacity:0.9; text-transform:uppercase; letter-spacing:0.5px;">Pendapatan Sparepart</p>
                <h3 style="margin:0 0 4px; font-size:1.6rem; font-weight:700;">
                    Rp {{ number_format($summary->total_sparepart, 0, ',', '.') }}
                </h3>
                <small style="opacity:0.8; font-size:0.78rem;"><i class="fas fa-cogs me-1"></i>Dari penjualan part</small>
            </div>
        </div>

        {{-- Rata-rata Transaksi --}}
        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.07); border-left:5px solid #10b981;">
                <p style="margin:0 0 8px; font-size:0.82rem; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Rata-rata Nilai Transaksi</p>
                <h3 style="margin:0; font-size:1.5rem; font-weight:700; color:#1a2332;">
                    Rp {{ number_format($summary->rata_rata, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        {{-- Breakdown Metode Pembayaran --}}
        @foreach($metodeSummary as $mp)
        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div style="background:white; border-radius:16px; padding:20px 24px; box-shadow:0 2px 12px rgba(0,0,0,0.07); display:flex; align-items:center; gap:16px;">
                <div style="width:48px;height:48px;border-radius:12px;
                    background:{{ $mp->metode_pembayaran === 'Cash' ? 'linear-gradient(135deg,#10b981,#059669)' : ($mp->metode_pembayaran === 'QRIS' ? 'linear-gradient(135deg,#f59e0b,#d97706)' : 'linear-gradient(135deg,#3b82f6,#2563eb)') }};
                    display:flex;align-items:center;justify-content:center;">
                    <i class="fas {{ $mp->metode_pembayaran === 'Cash' ? 'fa-money-bill' : ($mp->metode_pembayaran === 'QRIS' ? 'fa-qrcode' : 'fa-university') }}" style="color:white; font-size:1.1rem;"></i>
                </div>
                <div>
                    <p style="margin:0 0 2px; font-size:0.78rem; color:#6b7280; font-weight:600; text-transform:uppercase;">{{ $mp->metode_pembayaran }}</p>
                    <p style="margin:0; font-size:1rem; font-weight:700; color:#1a2332;">Rp {{ number_format($mp->total, 0, ',', '.') }}</p>
                    <small style="color:#9ca3af; font-size:0.75rem;">{{ $mp->jumlah }} transaksi</small>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- ================================================================
         GRAFIK PENDAPATAN
    ================================================================ --}}
    <div class="card mb-4" style="border:none; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.07);" data-aos="fade-up">
        <div class="card-body" style="padding:25px 30px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="margin:0; font-weight:700; color:#1a2332;">
                    <i class="fas fa-chart-bar me-2" style="color:#00a152;"></i>Grafik Pendapatan Harian
                </h5>
                <div style="display:flex; gap:16px; align-items:center;">
                    <span style="display:flex;align-items:center;gap:6px;font-size:0.82rem;color:#6b7280;">
                        <span style="width:14px;height:14px;border-radius:4px;background:#00a152;display:inline-block;"></span> Pendapatan
                    </span>
                    <span style="display:flex;align-items:center;gap:6px;font-size:0.82rem;color:#6b7280;">
                        <span style="width:14px;height:14px;border-radius:4px;background:#3b82f6;display:inline-block;"></span> Jml. Transaksi
                    </span>
                </div>
            </div>

            @if($grafikLabels->count() > 0)
                <div style="position:relative; height:320px;">
                    <canvas id="grafikPendapatan"></canvas>
                </div>
            @else
                <div style="text-align:center; padding:60px 20px; color:#9ca3af;">
                    <i class="fas fa-chart-bar" style="font-size:3.5rem; margin-bottom:16px; display:block; opacity:0.3;"></i>
                    <p style="margin:0; font-size:1rem; font-weight:500;">Tidak ada data untuk periode ini</p>
                    <small>Coba pilih periode lain atau tambahkan transaksi.</small>
                </div>
            @endif
        </div>
    </div>

    {{-- ================================================================
         TABEL TRANSAKSI
    ================================================================ --}}
    <div class="card" style="border:none; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.07);" data-aos="fade-up">
        <div class="card-body" style="padding:25px 30px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="margin:0; font-weight:700; color:#1a2332;">
                    <i class="fas fa-list-alt me-2" style="color:#00a152;"></i>Detail Transaksi
                    <span style="font-size:0.85rem; font-weight:500; color:#6b7280; margin-left:8px;">({{ $transaksi->count() }} data)</span>
                </h5>
            </div>

            @if($transaksi->count() > 0)
                <div class="table-responsive">
                    <table class="table-modern w-100" style="font-size:0.875rem;">
                        <thead style="background:linear-gradient(135deg,#1a2332,#2d3748);">
                            <tr>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">#</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">ID Transaksi</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">Tanggal</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">ID Servis</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">Customer</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">Motor</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">Mekanik</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap; text-align:right;">Layanan</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap; text-align:right;">Sparepart</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap; text-align:right;">Subtotal</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">Metode</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap;">Status</th>
                                <th style="padding:13px 14px; color:white; font-weight:600; white-space:nowrap; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $i => $t)
                            @php
                                $servis   = $t->servis;
                                $motor    = $servis?->motor;
                                $customer = $motor?->customer;
                                $mekanik  = $servis?->mechanic;
                            @endphp
                            <tr style="background:white; transition:all .2s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='white'">
                                <td style="padding:12px 14px; color:#6b7280;">{{ $i + 1 }}</td>
                                <td style="padding:12px 14px; font-family:monospace; font-weight:600; color:#1a2332; white-space:nowrap;">
                                    {{ $t->id_transaksi }}
                                </td>
                                <td style="padding:12px 14px; color:#374151; white-space:nowrap;">
                                    {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y') }}
                                </td>
                                <td style="padding:12px 14px; font-family:monospace; color:#4b5563; white-space:nowrap;">
                                    {{ $t->id_servis ?? '-' }}
                                </td>
                                <td style="padding:12px 14px; white-space:nowrap;">
                                    @if($customer)
                                        <span style="font-weight:600; color:#1a2332;">{{ $customer->nama_customer }}</span>
                                    @else
                                        <span style="color:#9ca3af; font-style:italic;">—</span>
                                    @endif
                                </td>
                                <td style="padding:12px 14px; white-space:nowrap;">
                                    @if($motor)
                                        <span style="color:#374151;">{{ $motor->merk_motor }}</span>
                                        <br>
                                        <small style="color:#9ca3af; font-size:0.75rem;">{{ $motor->no_plat_motor }}</small>
                                    @else
                                        <span style="color:#9ca3af; font-style:italic;">—</span>
                                    @endif
                                </td>
                                <td style="padding:12px 14px; white-space:nowrap; color:#374151;">
                                    {{ $mekanik?->mechanic_name ?? '—' }}
                                </td>
                                <td style="padding:12px 14px; text-align:right; color:#374151; white-space:nowrap;">
                                    Rp {{ number_format($t->harga_layanan, 0, ',', '.') }}
                                </td>
                                <td style="padding:12px 14px; text-align:right; color:#374151; white-space:nowrap;">
                                    Rp {{ number_format($t->harga_sparepart ?? 0, 0, ',', '.') }}
                                </td>
                                <td style="padding:12px 14px; text-align:right; font-weight:700; color:#00875a; white-space:nowrap;">
                                    Rp {{ number_format($t->subtotal, 0, ',', '.') }}
                                </td>
                                <td style="padding:12px 14px;">
                                    <span style="padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; white-space:nowrap;
                                        background:{{ $t->metode_pembayaran === 'Cash' ? '#d1fae5' : ($t->metode_pembayaran === 'QRIS' ? '#fef3c7' : '#dbeafe') }};
                                        color:{{ $t->metode_pembayaran === 'Cash' ? '#065f46' : ($t->metode_pembayaran === 'QRIS' ? '#92400e' : '#1e40af') }};">
                                        {{ $t->metode_pembayaran }}
                                    </span>
                                </td>
                                <td style="padding:12px 14px;">
                                    <span style="padding:4px 10px; border-radius:20px; font-size:0.75rem; font-weight:600; white-space:nowrap;
                                        background:{{ $t->status_pembayaran === 'Lunas' ? '#d1fae5' : '#fee2e2' }};
                                        color:{{ $t->status_pembayaran === 'Lunas' ? '#065f46' : '#991b1b' }};">
                                        {{ $t->status_pembayaran }}
                                    </span>
                                </td>
                                <td style="padding:12px 14px; text-align:center;">
                                    <a href="{{ route('transaksi.cetak', $t->id_transaksi) }}"
                                       title="Lihat / Cetak Nota"
                                       style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:8px;background:linear-gradient(135deg,#00a152,#00875a);color:white;text-decoration:none;font-size:0.8rem;font-weight:600;box-shadow:0 2px 8px rgba(0,161,82,.3);transition:all .2s;"
                                       onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                        <i class="fas fa-print"></i> Nota
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        {{-- Baris total --}}
                        <tfoot>
                            <tr style="background:#f0fdf4; font-weight:700;">
                                <td colspan="7" style="padding:13px 14px; color:#1a2332; font-size:0.88rem;">
                                    <i class="fas fa-sigma me-1" style="color:#00a152;"></i> TOTAL ({{ $transaksi->count() }} transaksi)
                                </td>
                                <td style="padding:13px 14px; text-align:right; color:#1a2332; white-space:nowrap;">
                                    Rp {{ number_format($summary->total_layanan, 0, ',', '.') }}
                                </td>
                                <td style="padding:13px 14px; text-align:right; color:#1a2332; white-space:nowrap;">
                                    Rp {{ number_format($summary->total_sparepart, 0, ',', '.') }}
                                </td>
                                <td style="padding:13px 14px; text-align:right; color:#00875a; white-space:nowrap; font-size:1rem;">
                                    Rp {{ number_format($summary->total_pendapatan, 0, ',', '.') }}
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            @else
                {{-- Empty state --}}
                <div style="text-align:center; padding:70px 20px; color:#9ca3af;">
                    <i class="fas fa-receipt" style="font-size:4rem; margin-bottom:20px; display:block; opacity:0.25;"></i>
                    <h5 style="color:#6b7280; font-weight:600; margin-bottom:8px;">Tidak ada transaksi</h5>
                    <p style="margin:0; font-size:0.9rem;">Belum ada transaksi pada periode <strong>{{ $labelPeriode }}</strong>.</p>
                    <p style="margin:4px 0 0; font-size:0.85rem;">Coba pilih periode lain atau tambahkan transaksi baru.</p>
                    <a href="{{ route('transaksi.create') }}" class="btn-success-custom" style="display:inline-flex;align-items:center;gap:8px;margin-top:20px;text-decoration:none;">
                        <i class="fas fa-plus"></i> Buat Transaksi
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>{{-- end padding wrapper --}}

{{-- ================================================================
     PRINT STYLES
================================================================ --}}
@push('styles')
<style>
@media print {
    /* Phase 1: class layout diperbarui ke .topbar (sebelumnya .top-bar) */
    .sidebar, .topbar, .top-bar, #filterForm, .btn-primary-custom { display: none !important; }
    .main-content { margin-left: 0 !important; width: 100% !important; }
    .page-content { padding: 0 !important; }
    body { background: white !important; }
    .card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    a[href] { color: inherit !important; text-decoration: none !important; }
    /* Sembunyikan kolom Aksi saat cetak */
    th:last-child, td:last-child { display: none !important; }
}
</style>
@endpush

{{-- ================================================================
     CHART.JS + LOGIKA GRAFIK & FILTER
================================================================ --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---- Custom date toggle ----
    const filterButtons = document.querySelectorAll('button[name="filter"]');
    const customSection = document.getElementById('customDateSection');

    filterButtons.forEach(btn => {
        if (btn.value !== 'custom') {
            btn.addEventListener('click', function () {
                customSection.style.display = 'none';
            });
        } else {
            btn.addEventListener('click', function (e) {
                // Jangan submit dulu kalau tombol Custom diklik tapi bukan dari form custom
                if (customSection.style.display === 'none') {
                    e.preventDefault();
                    customSection.style.display = 'flex';
                }
            });
        }
    });

    // ---- Grafik ----
    @if($grafikLabels->count() > 0)
    const ctx = document.getElementById('grafikPendapatan');
    if (ctx) {
        const labels        = @json($grafikLabels);
        const dataPendapatan = @json($grafikPendapatan);
        const dataJumlah    = @json($grafikJumlah);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: dataPendapatan,
                        backgroundColor: 'rgba(0, 161, 82, 0.75)',
                        borderColor: '#00a152',
                        borderWidth: 2,
                        borderRadius: 6,
                        yAxisID: 'yPendapatan',
                    },
                    {
                        label: 'Jumlah Transaksi',
                        data: dataJumlah,
                        type: 'line',
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.12)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#3b82f6',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.35,
                        fill: true,
                        yAxisID: 'yJumlah',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a2332',
                        titleColor: '#f9fafb',
                        bodyColor: '#d1d5db',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) {
                                if (ctx.datasetIndex === 0) {
                                    return ' Pendapatan: Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                                return ' Transaksi: ' + ctx.parsed.y + ' transaksi';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280', font: { size: 11 } }
                    },
                    yPendapatan: {
                        type: 'linear',
                        position: 'left',
                        grid: { color: 'rgba(0,0,0,0.06)' },
                        ticks: {
                            color: '#6b7280',
                            font: { size: 11 },
                            callback: v => 'Rp ' + (v >= 1000000
                                ? (v/1000000).toFixed(1) + 'jt'
                                : v.toLocaleString('id-ID'))
                        }
                    },
                    yJumlah: {
                        type: 'linear',
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: {
                            color: '#3b82f6',
                            font: { size: 11 },
                            stepSize: 1,
                            callback: v => v + ' trx'
                        }
                    }
                }
            }
        });
    }
    @endif

}); // end DOMContentLoaded
</script>
@endpush

@endsection
