@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">

    <!-- Header -->
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                    <i class="fas fa-receipt me-2"></i>{{ $title ?? 'Manajemen Transaksi' }}
                </h2>
                <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Kelola semua data transaksi bengkel</p>
            </div>

            <a href="{{ route('transaksi.create') }}" class="btn-success-custom" style="text-decoration: none;">
                <i class="fas fa-plus-circle me-2"></i>Tambah Transaksi
            </a>
        </div>

        <!-- Search -->
        <form action="{{ route('transaksi.index') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 500px;">
                <input type="text" name="search" class="form-control-modern"
                       placeholder="Cari ID Transaksi atau Nota..." value="{{ request('search') }}">
                <button class="btn-primary-custom" style="border-radius: 0 10px 10px 0;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Alert -->
    @if(session('success'))
    <div class="alert" style="background: linear-gradient(135deg,#10b981,#059669); color:white; border-radius:15px; padding:15px 20px;" data-aos="fade-down">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert" style="background: linear-gradient(135deg,#f59e0b,#d97706); color:white; border-radius:15px; padding:15px 20px;" data-aos="fade-down">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    </div>
    @endif

    <!-- Table -->
    <div class="table-responsive" data-aos="fade-up">
        <table class="table-modern">
            <thead style="background: linear-gradient(135deg, #1a2332, #2d3748);">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>No Nota</th>
                    <th>Tanggal</th>
                    <th>ID Servis</th>
                    <th>Layanan</th>
                    <th>Sparepart</th>
                    <th>Subtotal</th>
                    <th>Pembayaran</th>
                    <th style="width: 150px; text-align:center;">Aksi</th>
                </tr>
            </thead>
           <tbody>
@forelse($transaksi as $item)
<tr data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 40 }}">
    <td>{{ $loop->iteration }}</td>

    <td style="font-family: monospace; font-weight: 600;">{{ $item->id_transaksi }}</td>

    <td>{{ $item->no_nota }}</td>

    <td>{{ $item->tanggal_transaksi }}</td>

    <td>
        {{ $item->servis->id_servis ?? '-' }}
        <br>
        @if($item->servis->status_servis === 'Selesai')
            <span class="badge bg-success">Servis Selesai</span>
        @else
            <span class="badge bg-warning text-dark">Belum Selesai</span>
        @endif
    </td>

    <!-- Layanan -->
    <td>
        @foreach($item->layanan as $lay)
            <span class="badge bg-primary" style="margin-bottom:3px;">{{ $lay->nama_layanan }}</span><br>
        @endforeach
    </td>

    <!-- Sparepart -->
    <td>
        @php $jumlah = json_decode($item->jumlah_sparepart, true); @endphp

        @foreach($item->sparepart as $sp)
            <span class="badge bg-secondary" style="margin-bottom:3px;">
                {{ $sp->nama_sparepart }} (x{{ $jumlah[$sp->id_sparepart] ?? 0 }})
            </span><br>
        @endforeach
    </td>

    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>

    <!-- PEMBAYARAN UPDATED -->
    <td>
        <strong>{{ $item->metode_pembayaran }}</strong>

        @if($item->detail_pembayaran)
            <br><small>{{ $item->detail_pembayaran }}</small>
        @endif

        <br>
        @if($item->status_pembayaran == 'Lunas')
            <span class="badge bg-success mt-1">Lunas</span>
        @else
            <span class="badge bg-danger mt-1">Belum</span>
        @endif
    </td>

    <!-- Aksi: CETAK & DELETE -->
    <td style="text-align:center;">
        <div class="d-flex gap-2 justify-content-center">

            <!-- CETAK NOTA -->
            <a href="{{ route('transaksi.cetak', $item->id_transaksi) }}"
               class="btn-primary-custom"
               style="padding: 8px 16px; font-size: 0.9rem;"
               title="Cetak Nota">
                <i class="fas fa-print"></i>
            </a>

            <!-- DELETE -->
            <button class="btn-danger-custom"
                    data-bs-toggle="modal"
                    data-bs-target="#delete{{ $item->id_transaksi }}"
                    style="padding: 8px 16px; font-size: 0.9rem;"
                    title="Hapus">
                <i class="fas fa-trash"></i>
            </button>

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="10" style="text-align:center; padding:50px 0;">
        <i class="fas fa-receipt" style="font-size: 4rem; color: #000000; margin-bottom:20px;"></i>
        <p style="color: #6c757d;">Belum ada transaksi</p>
    </td>
</tr>
@endforelse
</tbody>

        </table>
    </div>

</div>

<!-- Delete Modal -->
@foreach($transaksi as $item)
<div class="modal fade" id="delete{{ $item->id_transaksi }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px;">
            <div class="modal-header" style="border:none;">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>Hapus Transaksi
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaksi.destroy', $item->id_transaksi) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    Yakin ingin menghapus transaksi <strong>{{ $item->id_transaksi }}</strong>?  
                    <p class="text-danger mt-2">Proses ini tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer" style="border:none;">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn-danger-custom">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
