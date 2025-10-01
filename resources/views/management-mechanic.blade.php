@extends('admin')

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="">
                <h5 class="card-title"><strong>{{ $title }}</strong></h5>
                <p class="card-text">Manajemen Data Mekanik.</p>
            </div>
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
                                <input type="number" class="form-control" required placeholder="Masukkan nomor telepon"
                                    name="mechanic_phone" id="mechanic_phone">
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
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mekanik</th>
                                    <th>Nomor Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mechanics as $item)
                                    <tr style="vertical-align: middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <img src="{{ asset('img/mechanics/' . $item->mechanic_image) }}" width="100"
                                                    class="me-3" alt="">
                                                {{ $item->mechanic_name }}
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
                                                                    placeholder="Masukkan nama layanan" name="mechanic_name"
                                                                    id="mechanic_name">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="mechanic_phone">Nomor Telepon</label>
                                                                <input type="number" value="{{ $item->mechanic_phone }}"
                                                                    class="form-control" required
                                                                    placeholder="Masukkan harga layanan" name="mechanic_phone"
                                                                    id="mechanic_phone">
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