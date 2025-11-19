@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <div class="mb-4">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332;">
            <i class="fas fa-receipt me-2"></i>Nota Transaksi
        </h2>
        <p style="color: #6c757d; margin:0;">Detail transaksi ID: {{ $transaksi->id_transaksi }}</p>
    </div>

    <div class="card" style="border-radius:20px; padding:30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">

        <!-- Header Bengkel -->
        <div class="mb-3">
            <h4 style="margin:0;">MizKev Garage</h4>
            <small>Jl. Nologaten Yogyakarta</small><br>
            <small>Telp: 0812-3456-7890</small>
        </div>

        <hr>

        <!-- Informasi Transaksi -->
        <h5>Informasi Transaksi</h5>
        <table class="table-modern mb-4">
            <tr>
                <td><strong>ID Transaksi</strong></td>
                <td>{{ $transaksi->id_transaksi }}</td>
            </tr>
            <tr>
                <td><strong>No Nota</strong></td>
                <td>{{ $transaksi->no_nota }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>{{ $transaksi->tanggal_transaksi }}</td>
            </tr>
            <tr>
                <td><strong>Servis</strong></td>
                <td>
                    {{ $transaksi->servis->id_servis ?? '-' }} - {{ $transaksi->servis->keluhan ?? '-' }}
                    <br>
                    @if($transaksi->servis->status_servis === 'Selesai')
                        <span class="badge bg-success">Servis Selesai</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum Selesai</span>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Layanan -->
        <h5>Layanan</h5>
        <table class="table-modern mb-4">
            <thead>
                <tr>
                    <th>Nama Layanan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->layanan() as $lay)
                    <tr>
                        <td>{{ $lay->nama_layanan }}</td>
                        <td>Rp {{ number_format($lay->harga_layanan, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Sparepart -->
        <h5>Sparepart</h5>
        <table class="table-modern mb-4">
            <thead>
                <tr>
                    <th>Nama Sparepart</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $jumlah = json_decode($transaksi->jumlah_sparepart, true); @endphp
                @foreach($transaksi->sparepart() as $sp)
                    <tr>
                        <td>{{ $sp->nama_sparepart }}</td>
                        <td>{{ $jumlah[$sp->id_sparepart] ?? 0 }}</td>
                        <td>Rp {{ number_format($sp->harga_sparepart, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sp->harga_sparepart * ($jumlah[$sp->id_sparepart] ?? 0), 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Ringkasan Pembayaran -->
        <h5 class="mt-3">Ringkasan Pembayaran</h5>
        <table class="table-modern mb-4">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Metode Pembayaran</strong></td>
                <td>{{ $transaksi->metode_pembayaran }}</td>
            </tr>
            <tr>
                <td><strong>Status Pembayaran</strong></td>
                <td>
                    @if($transaksi->status_pembayaran == 'Lunas')
                        <span class="badge bg-success">Lunas</span>
                    @else
                        <span class="badge bg-danger">Belum Lunas</span>
                    @endif
                </td>
            </tr>
        </table>

        <div class="mt-4 text-center">
            <p>Terima kasih telah menggunakan layanan MizKev Garage!</p>
            <button onclick="window.print()" class="btn-success-custom mt-2">
                <i class="fas fa-print me-2"></i>Cetak Nota
            </button>
        </div>

    </div>
</div>
@endsection
