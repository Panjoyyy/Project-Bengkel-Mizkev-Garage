@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                    <i class="fas fa-cog" style="color: #1a2332; margin-right: 10px;"></i>{{ $title }}
                </h2>
                <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Kelola semua data sparepart bengkel</p>
            </div>
            <a href="{{ route('spareparts.create-form') }}" class="btn-success-custom" style="text-decoration: none;">
                <i class="fas fa-plus-circle me-2"></i>Tambah Sparepart
            </a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('spareparts.index') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 500px;">
                <input type="text" name="search" class="form-control-modern" 
                       placeholder="Cari sparepart..." value="{{ request('search') }}">
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

    @if(session()->has('success'))
    <div class="alert" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); animation: slideDown 0.3s ease;" data-aos="fade-down">
        <i class="fas fa-check-circle me-2"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table Section -->
    <div class="table-responsive" data-aos="fade-up">
        <table class="table-modern w-100" style="width:100%;">
            <thead style="background: linear-gradient(135deg, #1a2332, #2d3748);">
                <tr>
                    <th style="width: 60px;">NO</th>
                    <th style="width: 120px;">ID</th>
                    <th>Nama Sparepart</th>
                    <th style="width: 120px;">Stok</th>
                    <th style="width: 150px;">Harga</th>
                    <th style="width: 150px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($spareparts as $sparepart)
                <tr data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    <td style="font-weight: 600; color: #6c757d;">{{ $loop->iteration }}</td>
                    <td style="font-family: monospace; color: #1a2332; font-weight: 600;">#{{ $sparepart->id_sparepart }}</td>
                    <td style="font-weight: 600; color: #1a2332; font-size: 1rem;">{{ $sparepart->nama_sparepart }}</td>
                    <td>
                        <span style="background: {{ $sparepart->stok_sparepart > 10 ? '#dcfce7' : '#fee2e2' }}; color: {{ $sparepart->stok_sparepart > 10 ? '#166534' : '#991b1b' }}; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: inline-block;">
                            {{ $sparepart->stok_sparepart }} pcs
                        </span>
                    </td>
                    <td>
                        <span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: inline-block;">
                            Rp {{ number_format($sparepart->harga_sparepart, 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('spareparts.edit-form', $sparepart->id_sparepart) }}" 
                               class="btn-warning-custom" 
                               style="padding: 8px 16px; text-decoration: none; font-size: 0.9rem;"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn-danger-custom" 
                                    style="padding: 8px 16px; font-size: 0.9rem;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#delete{{ $sparepart->id_sparepart }}"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px 20px;">
                        <i class="fas fa-cog" style="font-size: 4rem; color: #1a2332; margin-bottom: 20px;"></i>
                        <p style="color: #6c757d; font-size: 1.1rem; margin: 0;">Tidak ada data sparepart</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modals (Outside Table) -->
@foreach ($spareparts as $sparepart)
<div class="modal fade" id="delete{{ $sparepart->id_sparepart }}" tabindex="-1" aria-labelledby="deleteLabel{{ $sparepart->id_sparepart }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="border: none; padding: 30px 30px 0;">
                <h5 class="modal-title" id="deleteLabel{{ $sparepart->id_sparepart }}" style="color: #1a2332; font-weight: 700;">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('spareparts.destroy', $sparepart->id_sparepart) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body" style="padding: 20px 30px;">
                    <p style="color: #6c757d; margin: 0;">
                        Apakah Anda yakin ingin menghapus sparepart <strong style="color: #1a2332;">{{ $sparepart->nama_sparepart }}</strong>?
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
@endforeach

<style>
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
