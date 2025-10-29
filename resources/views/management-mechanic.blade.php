@extends('admin')

@section('content')

{{-- ALERT PESAN --}}
@if($message)
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
            <p class="card-text">Manajemen Data Mekanik</p>
        </div>

        {{-- FORM PENCARIAN --}}
        <form action="{{ route('management-mechanic') }}" method="GET" 
              class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control shadow-sm" 
                   placeholder="Cari mekanik..." 
                   style="width: 300px; border-radius: 10px;" 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>
        <a href="{{ route('create-mechanic-form') }}" class="btn btn-success">+ Tambah Mekanik</a>
    </div>
</div>

{{-- ALERT SESSION --}}
@if(session()->has('success'))
    <div class="mt-4 alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- TABEL DATA MEKANIK --}}
<div class="row my-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>ID Mekanik</th>
                                <th>Nama Mekanik</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mechanics as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->id_mechanic }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('img/mechanics/' . $item->mechanic_image) }}" 
                                             width="70" height="70" class="rounded shadow-sm" alt="">
                                        <span>{{ $item->mechanic_name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->mechanic_phone }}</td>
                                <td>
                                     {{-- EDIT --}}
                                    <a href="{{ route('edit-mechanic-form', $item->id_mechanic) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- HAPUS --}}
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#delete{{ $item->id_mechanic }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <div class="modal fade" id="delete{{ $item->id_mechanic }}" tabindex="-1" aria-hidden="true">
                                        <form action="{{ route('delete-mechanic', $item->id_mechanic) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus mekanik 
                                                        <strong>{{ $item->mechanic_name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

                    @if($mechanics->isEmpty())
                        <div class="text-center text-muted py-3">Belum ada data mekanik</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
