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
            <p class="card-text">Manajemen Data Motor.</p>
        </div>

        {{-- FORM PENCARIAN --}}
        <form action="{{ route('motor.index') }}" method="GET" 
              class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control shadow-sm" 
                   placeholder="Cari motor..." 
                   style="width: 300px; border-radius: 10px;" 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>

        <a href="{{ route('motor.create') }}" class="btn btn-success">+ Tambah Motor</a>
    </div>
</div>


@if(session()->has('success'))
    <div class="mt-4 alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Hanya gunakan class "table" -->
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>ID Motor</th>
                                <th>No Plat</th>
                                <th>Merk Motor</th>
                                <th>Warna</th>
                                <th>Tahun</th>
                                <th>ID Customer</th>
                                <th>Nama Customer</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($motors as $motor)
                                <tr style="vertical-align: middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $motor->id_motor }}</td>
                                    <td>{{ $motor->no_plat_motor }}</td>
                                    <td>{{ $motor->merk_motor }}</td>
                                    <td>{{ $motor->warna_motor }}</td>
                                    <td>{{ $motor->tahun_motor }}</td>
                                    <td>{{ $motor->id_customer }}</td>
                                    <td>{{ $motor->customer->nama_customer ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('motor.edit', $motor->id_motor) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteMotor{{ $motor->id_motor }}"><i
                                                class="bi bi-trash"></i></button>
                                        <div class="modal fade" id="deleteMotor{{ $motor->id_motor }}" tabindex="-1"
                                            aria-labelledby="deleteMotorLabel" aria-hidden="true">
                                            <form action="{{ route('motor.destroy', $motor->id_motor) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            Apakah anda yakin menghapus motor
                                                            <strong>{{ $motor->no_plat_motor }}</strong>?
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
