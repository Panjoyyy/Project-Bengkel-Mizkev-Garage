@extends('admin')

@section('content')

@if ($message)
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
        <div class="col-12 d-flex justify-content-between">
            <div class="">
                <h5 class="card-title"><strong>{{ $title }}</strong></h5>
                <p class="card-text">Manajemen Data Mekanik.</p>
            </div>

        <form action="{{ route('management-mechanic') }}" method="GET" class="d-flex justify-content-end mb-3" style="gap: 10px;">
            <input type="text" name="search" class="form-control shadow-sm" 
            placeholder="Cari mekanik" 
            style="width: 350px; border-radius: 10px;">

            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
            <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMechanic">+ Tambah Mekanik</button>

            <div class="modal fade" id="addMechanic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('create-mechanic') }}" class="modal-content"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Mekanik</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-3">
                                <label for="mechanic_name">Nama Mekanik</label>
                                <input type="text" class="form-control" required placeholder="Masukkan nama mekanik"
                                    name="mechanic_name" id="mechanic_name">
                            </div>
                            <div class="mt-3">
                                <label for="mechanic_phone">Nomor Telepon</label>
                                <input type="text" class="form-control" required placeholder="Masukkan nomor telepon"
                                    name="mechanic_phone" id="mechanic_phone" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            <div class="mt-3">
                                <label for="mechanic_image">Gambar</label>
                                <input type="file" accept=".jpg,.png,.jpeg" class="form-control" required
                                    name="mechanic_image" id="mechanic_image">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mt-4 alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    <th>#</th>
                                    <th>ID Mekanik</th>
                                    <th>Mekanik</th>
                                    <th>Nomor Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mechanics as $item)
                                    <tr style="vertical-align: middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id_mechanic }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <img src="{{ asset('img/mechanics/' . $item->mechanic_image) }}" width="100"
                                                    class="me-3" alt="">
                                                <span class="align-middle">{{ $item->mechanic_name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->mechanic_phone }}</td>
                                        <td>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="{{ '#delete' . $item->id_mechanic }}"><i
                                                    class="bi bi-trash"></i></button>
                                            <div class="modal fade" id="{{ 'delete' . $item->id_mechanic }}" tabindex="-1"
                                                aria-labelledby="confirmLogoutLabel" aria-hidden="true">
                                                <form action="{{ route('delete-mechanic', $item->id_mechanic) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                Apakah anda yakin untuk menghapus mekanik
                                                                <strong>{{ $item->mechanic_name }}</strong>?
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

                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="{{ '#edit' . $item->id_mechanic }}"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <div class="modal fade" id="{{ 'edit' . $item->id_mechanic }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('update-mechanic', $item->id_mechanic) }}"
                                                        class="modal-content" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Mekanik
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mt-3">
                                                                <label for="mechanic_name">Nama Mekanik</label>
                                                                <input type="text" value="{{ $item->mechanic_name }}"
                                                                    class="form-control" required
                                                                    placeholder="Masukkan nama mekanik" name="mechanic_name"
                                                                    id="mechanic_name">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="mechanic_phone">Nomor Telepon</label>
                                                                <input type="text" value="{{ $item->mechanic_phone }}" class="form-control" required placeholder="Masukkan nomor telepon"
                                                                name="mechanic_phone" id="mechanic_phone" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="mechanic_image">Gambar</label>
                                                                <input type="file" accept=".jpg,.png,.jpeg" class="form-control"
                                                                    name="mechanic_image" id="mechanic_image">
                                                                <a
                                                                    href="{{ asset('img/mechanics/' . $item->mechanic_image) }}">Preview</a>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
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

    {{-- <div class="row">

    </div> --}}

@endsection