@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                    <i class="fas fa-wrench" style="color: #1a2332; margin-right: 10px;"></i>{{ $title }}
                </h2>
                <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Kelola semua data servis bengkel</p>
            </div>
            <a href="{{ route('servis.create') }}" class="btn-success-custom" style="text-decoration: none;">
                <i class="fas fa-plus-circle me-2"></i>Tambah Servis
            </a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('management-servis') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 500px;">
                <input type="text" name="search" class="form-control-modern" 
                       placeholder="Cari ID Servis..." value="{{ request('search') }}">
                <button type="submit" class="btn-primary-custom" style="border-radius: 0 10px 10px 0;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if (!empty($message))
    <div class="alert" style="background: {{ $alertType === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #f59e0b, #d97706)' }}; color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); animation: slideDown 0.3s ease;" data-aos="fade-down">
        <i class="fas {{ $alertType === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-2"></i>
        <span>{{ $message }}</span>
        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session()->has('message'))
    <div class="alert" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); animation: slideDown 0.3s ease;" data-aos="fade-down">
        <i class="fas fa-check-circle me-2"></i>
        <span>{{ session('message') }}</span>
        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="alert"></button>
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
            <form action="{{ route('servis.destroy', $item->id_servis) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body" style="padding: 20px 30px;">
                    <p style="color: #6c757d; margin: 0;">
                        Apakah Anda yakin ingin menghapus data servis <strong style="color: #1a2332;">{{ $item->id_servis }}</strong>?
                    </p>
                    <p style="color: #ef4444; margin: 10px 0 0 0; font-size: 0.9rem;">
                        <i class="fas fa-info-circle me-1"></i>Data yang dihapus tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer" style="border: none; padding: 0 30px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px;">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn-danger-custom" style="padding: 10px 20px;">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
