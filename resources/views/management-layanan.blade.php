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
            <p class="card-text">Manajemen Data Layanan.</p>
        </div>
        <form action="{{ route('management-layanan') }}" method="GET" class="d-flex justify-content-end mb-3" style="gap: 10px;">
            <input type="text" name="search" class="form-control shadow-sm" 
            placeholder="Cari layanan..." 
            style="width: 350px; border-radius: 10px;">

            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
            <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>
            <a href="{{ route('create-service-form') }}" class="btn btn-success">+ Tambah Layanan</a>
    </div>
</div>

{{-- Alert sukses --}}
@if (session()->has('success'))
<div class="mt-4 alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Tabel Layanan --}}
<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>ID Layanan</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $item->id_layanan }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('img/layanan/'.$item->foto_layanan) }}" width="100" class="me-3" alt="Gambar Layanan">
                                        {{ $item->nama_layanan }}
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->harga_layanan, 0, ',', '.') }}</td>
                                <td>{{ $item->deskripsi_layanan }}</td>
                                <td>

                                {{-- Tombol Edit --}}
                                <a href="{{ route('edit-service-form', $item->id_layanan) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                    {{-- Tombol Hapus --}}
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id_layanan }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    
                                    <div class="modal fade" id="delete{{ $item->id_layanan }}" tabindex="-1" aria-hidden="true">
                                        <form action="{{ route('delete-service', $item->id_layanan) }}" method="POST" class="modal-dialog">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Apakah anda yakin untuk menghapus layanan <strong>{{ $item->nama_layanan }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
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
