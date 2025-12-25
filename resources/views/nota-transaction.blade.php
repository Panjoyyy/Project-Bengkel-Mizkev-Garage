@extends('layouts.admin-modern')

@section('content')
        <style>
            /* CSS Khusus Tampilan Layar */
            .receipt-container {
                background: white;
                max-width: 800px;
                margin: 20px auto;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .btn-print-group {
                max-width: 800px;
                margin: 0 auto 20px auto;
                display: flex;
                gap: 10px;
            }

            .table-receipt {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .table-receipt th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #dee2e6;
                padding: 12px;
                text-align: left;
            }

            .table-receipt td {
                padding: 12px;
                border-bottom: 1px solid #eee;
            }

            .text-right { text-align: right; }
            .font-weight-bold { font-weight: bold; }

            /* CSS Khusus Cetak */
            @media print {
                body * { visibility: hidden; }
                .receipt-container, .receipt-container * { visibility: visible; }
                .receipt-container {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    box-shadow: none;
                }
                .btn-print-group, .sidebar, .navbar, .footer-admin { display: none !important; }

                @page {
                    size: auto;
                    margin: 10mm;
                }
            }
        </style>

        <div class="container-fluid">
            <div class="btn-print-group no-print">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Cetak Nota (A4)
                </button>
            </div>

            <div class="receipt-container">
                <div class="row mb-4">
                    <div class="col-6">
                        <h3 class="mb-0" style="color: #1a2332; font-weight: 800;">MIZKEV GARAGE</h3>
                        <p class="mb-0">Spesialis Roda Dua & Perawatan Mesin</p>
                        <small class="text-muted">Jl. Nologaten, Caturtunggal, Yogyakarta</small><br>
                        <small class="text-muted">Telp: 0812-3456-7890</small>
                    </div>
                    <div class="col-6 text-right">
                        <h2 class="text-uppercase" style="color: #dee2e6; letter-spacing: 2px;">NOTA</h2>
                        <div class="mt-2">
                            <span class="font-weight-bold">ID Transaksi:</span> #{{ $transaksi->id_transaksi }}<br>
                            <span class="font-weight-bold">Tanggal:</span> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>

                <hr style="border-top: 2px solid #1a2332;">
    <div class="row mb-4">
        <div class="col-6">
            <h6 class="text-muted text-uppercase small font-weight-bold">Informasi Kendaraan</h6>
            <p class="mb-0"><strong>ID Servis:</strong> {{ $transaksi->servis?->id_servis ?? '-' }}</p>
            <p class="mb-0"><strong>Unit Motor:</strong>
                {{ $transaksi->servis?->motor?->merk_motor ?? '-' }}
                [{{ $transaksi->servis?->motor?->no_plat_motor ?? '-' }}]
            </p>
            <p class="mb-0"><strong>Keluhan:</strong> {{ $transaksi->servis?->keluhan ?? '-' }}</p>
        </div>
                    <div class="col-6 text-right">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Status Pembayaran</h6>
                        <h4 class="{{ $transaksi->status_pembayaran == 'Lunas' ? 'text-success' : 'text-danger' }}">
                            {{ strtoupper($transaksi->status_pembayaran) }}
                        </h4>
                    </div>
                </div>

                <table class="table-receipt">
                    <thead>
                        <tr>
                            <th>Deskripsi Layanan / Sparepart</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga Satuan</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                <tbody>
                    {{-- Bagian Layanan --}}
                    {{-- Gunakan getLayananData() yang kita buat di Model agar lebih aman --}}
                    @foreach($transaksi->getLayananData() as $lay)
                        <tr>
                            <td>
                                <i class="fas fa-tools small text-muted me-2"></i>
                                {{ $lay->nama_layanan }}
                            </td>
                            <td class="text-center">1</td>
                            <td class="text-right">Rp {{ number_format($lay->harga_layanan, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($lay->harga_layanan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                    {{-- Bagian Sparepart --}}
                    {{-- getSparepartData() otomatis mengambil nama dan jumlah beli --}}
                    @foreach($transaksi->getSparepartData() as $sp)
                        <tr>
                            <td>
                                <i class="fas fa-cog small text-muted me-2"></i>
                                {{ $sp->nama_sparepart }}
                            </td>
                            <td class="text-center">{{ $sp->jumlah_beli }}</td> {{-- jumlah_beli diambil dari loop di Model --}}
                            <td class="text-right">Rp {{ number_format($sp->harga_sparepart, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($sp->harga_sparepart * $sp->jumlah_beli, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right font-weight-bold" style="padding-top: 30px;">TOTAL PEMBAYARAN</td>
                            <td class="text-right font-weight-bold" style="padding-top: 30px; font-size: 1.2rem;">
                                Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right text-muted small">Metode: {{ $transaksi->metode_pembayaran }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="row mt-5">
                    <div class="col-7">
                        <p class="small text-muted"><strong>Syarat & Ketentuan:</strong><br>
                        1. Barang yang sudah dibeli tidak dapat dikembalikan.<br>
                        2. Garansi servis berlaku selama 7 hari setelah tanggal transaksi.<br>
                        3. Harap simpan nota ini sebagai bukti garansi.</p>
                    </div>
                    <div class="col-5 text-center">
                        <p class="mb-5 small">Hormat Kami,</p>
                        <br>
                        <p class="font-weight-bold mb-0">( MizKev Garage )</p>
                        <small class="text-muted">Kasir: {{ Auth::user()->name ?? 'Admin' }}</small>
                    </div>
                </div>

                <div class="text-center mt-5 no-print">
                    <p class="text-muted small">--- Terima Kasih Atas Kepercayaan Anda ---</p>
                </div>
            </div>
        </div>
@endsection