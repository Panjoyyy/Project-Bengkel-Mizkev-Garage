@extends('admin')

@section('content')

{{-- Alert pesan pencarian --}}
@if (!empty($message))
    <div class="alert alert-{{ $alertType }} shadow-sm d-flex align-items-center gap-2 mt-3 fade show"
         style="border-left: 5px solid {{ $alertType === 'success' ? '#1abc9c' : '#f1c40f' }};
                background-color: {{ $alertType === 'success' ? '#ecfdf5' : '#fffbea' }};
                color: {{ $alertType === 'success' ? '#065f46' : '#92400e' }};
                border-radius: 8px; animation: fadeIn 0.4s ease;">
        <i class="bi {{ $alertType === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }}"></i>
        <span>{{ $message }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title"><strong>{{ $title }}</strong></h5>
            <p class="card-text">Manajemen Data Servis Bengkel.</p>
        </div>

        {{-- Form Pencarian --}}
        <form action="{{ route('management-servis') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control shadow-sm"
                   placeholder="Cari ID Servis..." 
                   style="width: 250px; border-radius: 10px;"
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>

        {{-- Tombol Tambah Servis --}}
        <a href="{{ route('servis.create') }}" class="btn btn-success" style="border-radius: 10px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Servis
        </a>
    </div>
</div>

{{-- Notifikasi berhasil dari session --}}
@if (session()->has('message'))
    <div class="mt-4 alert alert-{{ session('alertType') ?? 'success' }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Tabel Servis --}}
<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>ID Servis</th>
                                <th>Tanggal & Waktu</th>
                                <th>Motor</th>
                                <th>Mekanik</th>
                                <th>Staff</th>
                                <th>Keluhan</th>
                                <th>Status Servis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($servis as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_servis }}</td>
                                    <td>{{ $item->tanggal_servis }}</td>
                                    <td>{{ $item->motor->merk_motor ?? '-' }} - {{ $item->motor->no_plat_motor ?? '-' }}</td>
                                    <td>{{ $item->mechanic->mechanic_name ?? '-' }}</td>
                                    <td>{{ $item->staff->nama_staff ?? '-' }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td class="text-center">
                                        @if($item->status_servis === 'Sedang Dikerjakan')
                                            <span class="badge bg-warning text-dark">Dikerjakan</span>
                                        @else
                                            <span class="badge bg-secondary">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center gap-1">

                                            {{-- Tombol Tandai Selesai --}}
                                            @if($item->status_servis === 'Sedang Dikerjakan')
                                                <form action="{{ route('servis.updateStatus', $item->id_servis) }}" 
                                                      method="POST" 
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                        Selesai
                                                    </button>
                                                </form>
                                            @endif
                                           
            
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('servis.edit', $item->id_servis) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('servis.destroy', $item->id_servis) }}" 
                                                  method="POST" 
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Yakin ingin menghapus data servis ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">
                                        Tidak ada data servis ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> {{-- end table-responsive --}}
            </div>
        </div>
    </div>
</div>

@endsection
