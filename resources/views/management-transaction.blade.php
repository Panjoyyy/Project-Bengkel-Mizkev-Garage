@extends('admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Manajemen Transaksi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-3">
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">+ Tambah Transaksi</a>
    </div>


    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>No Nota</th>
                <th>ID Servis</th>
                <th>Layanan</th>
                <th>Sparepart</th>
                <th>Tanggal</th>
                <th>Subtotal</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $index => $trx)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trx->id_transaksi }}</td>
                    <td>{{ $trx->no_nota }}</td>
                    <td>{{ $trx->id_servis }}</td>
                    <td> @if($trx->layanan && $trx->layanan->count())
                    {{ $trx->layanan->pluck('nama_layanan')->join(', ') }}
                    @else
                    -
                    @endif</td>
                    <td>@foreach ($trx->sparepart as $sp)
                    {{ $sp->nama_sparepart }} ({{ $trx->jumlah_sparepart[$sp->id_sparepart] ?? 0 }})<br>
                    @endforeach</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $trx->metode_pembayaran }}</td>
                    <td>
                        <span class="badge {{ $trx->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                            {{ $trx->status_pembayaran }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">Belum ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
