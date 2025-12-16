@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                    <i class="fas fa-motorcycle" style="color: #1a2332; margin-right: 10px;"></i>{{ $title }}
                </h2>
                <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">
                    Kelola semua data motor pelanggan
                </p>
            </div>
            <a href="{{ route('motor.create') }}" class="btn-success-custom" style="text-decoration: none;">
                <i class="fas fa-plus-circle me-2"></i>Tambah Motor
            </a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('motor.index') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 500px;">
                <input type="text" 
                       name="search" 
                       class="form-control-modern"
                       placeholder="Cari motor / customer..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn-primary-custom" style="border-radius: 0 10px 10px 0;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if (!empty($message))
        <div class="alert"
             style="background: {{ $alertType === 'success'
                ? 'linear-gradient(135deg, #10b981, #059669)'
                : 'linear-gradient(135deg, #f59e0b, #d97706)' }};
                color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px;"
             data-aos="fade-down">
            <i class="fas {{ $alertType === 'success'
                ? 'fa-check-circle'
                : 'fa-exclamation-triangle' }} me-2"></i>
            {{ $message }}
            <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert"
             style="background: linear-gradient(135deg, #10b981, #059669);
             color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px;"
             data-aos="fade-down">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table Section -->
    <div class="table-responsive" data-aos="fade-up">
        <table class="table-modern w-100">
            <thead style="background: linear-gradient(135deg, #1a2332, #2d3748);">
                <tr>
                    <th style="width: 60px;">NO</th>
                    <th style="width: 120px;">ID</th>
                    <th style="min-width: 130px;">No Plat</th>
                    <th>Merk Motor</th>
                    <th>Nama Customer</th> {{-- TAMBAHAN --}}
                    <th style="width: 120px;">Warna</th>
                    <th style="width: 100px;">Tahun</th>
                    <th style="width: 150px; text-align: center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($motors as $motor)
                <tr data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    <td style="font-weight: 600; color: #6c757d;">
                        {{ $loop->iteration }}
                    </td>

                    <td style="font-family: monospace; font-weight: 600;">
                        #{{ $motor->id_motor }}
                    </td>

                    <td>
                        <span style="background: linear-gradient(135deg, #1a2332, #2d3748);
                                     color: white; padding: 6px 12px; border-radius: 8px;
                                     font-weight: 600; font-size: 0.85rem;">
                            {{ $motor->no_plat_motor }}
                        </span>
                    </td>

                    <td style="font-weight: 600;">
                        {{ $motor->merk_motor }}
                    </td>

                    {{-- NAMA CUSTOMER --}}
                    <td>
                        <span style="background: #ecfeff; color: #0369a1;
                                     padding: 6px 12px; border-radius: 8px;
                                     font-weight: 600; font-size: 0.85rem;">
                            {{ $motor->customer->nama_customer ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <span style="background: #f3f4f6; padding: 5px 10px;
                                     border-radius: 6px; font-size: 0.85rem;">
                            {{ $motor->warna_motor }}
                        </span>
                    </td>

                    <td style="color: #6c757d;">
                        {{ $motor->tahun_motor }}
                    </td>

                    <td style="text-align: center;">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('motor.edit', $motor->id_motor) }}"
                               class="btn-warning-custom"
                               style="padding: 8px 16px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <button class="btn-danger-custom"
                                    style="padding: 8px 16px;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteMotor{{ $motor->id_motor }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 60px;">
                        <i class="fas fa-motorcycle"
                           style="font-size: 4rem; color: #1a2332;"></i>
                        <p style="margin-top: 15px; color: #6c757d;">
                            Tidak ada data motor
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modals -->
@foreach ($motors as $motor)
<div class="modal fade" id="deleteMotor{{ $motor->id_motor }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('motor.destroy', $motor->id_motor) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    Yakin hapus motor
                    <strong>{{ $motor->no_plat_motor }}</strong> ?
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn-danger-custom">
                        Ya, Hapus
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
