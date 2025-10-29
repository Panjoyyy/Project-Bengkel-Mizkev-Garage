@extends('admin')

@section('content')
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
            <p class="card-text">Manajemen Data Servis.</p>
        </div>

        {{-- FORM PENCARIAN --}}
        <form action="{{ route('management-servis') }}" method="GET" 
              class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control shadow-sm" 
                   placeholder="Cari servis..." 
                   style="width: 300px; border-radius: 10px;" 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>
        <a href="{{ route('servis.create') }}" class="btn btn-success">+ Tambah Servis</a>
    </div>
</div>

@if (session()->has('success'))
    <div class="mt-4 alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>ID Servis</th>
                                <th>Tanggal & Waktu Servis</th>
                                <th>Motor</th>
                                <th>Mekanik</th>
                                <th>Staff</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servis as $item)
                                <tr style="vertical-align: middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->id_servis }}</td>
                                    <td>{{ $item->tanggal_servis }}</td>
                                    <td>{{ $item->motor->merk_motor ?? '-' }} - {{ $item->motor->no_plat_motor ?? '-' }}</td>
                                    <td>{{ $item->mechanic->mechanic_name ?? '-' }}</td>
                                    <td>{{ $item->staff->nama_staff ?? '-' }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('servis.edit', $item->id_servis) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- Tombol Hapus --}}
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="{{ '#delete' . $item->id_servis }}"><i
                                                class="bi bi-trash"></i></button>
                                        <div class="modal fade" id="{{ 'delete' . $item->id_servis }}" tabindex="-1">
                                            <form action="{{ route('servis.destroy', $item->id_servis) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            Apakah anda yakin menghapus servis tanggal
                                                            <strong>{{ $item->tanggal_servis }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
