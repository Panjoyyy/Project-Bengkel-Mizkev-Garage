@extends('admin')

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="">
                <h5 class="card-title"><strong>{{ $title }}</strong></h5>
                <p class="card-text">Manajemen Data Customer.</p>
            </div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCustomer">+ Tambah Customer</button>

            <div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('create-customer') }}" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Customer</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-3">
                                <label for="nama_customer">Nama Customer</label>
                                <input type="text" class="form-control" required placeholder="Masukkan nama customer"
                                    name="nama_customer" id="nama_customer">
                            </div>
                            <div class="mt-3">
                                <label for="no_telp_customer">Nomor Telepon</label>
                                <input type="text" class="form-control" required placeholder="Masukkan nomor telepon"
                                    name="no_telp_customer" id="no_telp_customer">
                            </div>
                            <div class="mt-3">
                                <label for="alamat_customer">Alamat</label>
                                <input type="text" class="form-control" required placeholder="Masukkan alamat"
                                    name="alamat_customer" id="alamat_customer">
                            </div>
                            <div class="mt-3">
                                <label for="email_customer">Email</label>
                                <input type="email" class="form-control" required placeholder="Masukkan email"
                                    name="email_customer" id="email_customer">
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Customer</th>
                                    <th>Nama</th>
                                    <th>No Telepon</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $item)
                                    <tr style="vertical-align: middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->id_customer }}</td>
                                        <td>{{ $item->nama_customer }}</td>
                                        <td>{{ $item->no_telp_customer }}</td>
                                        <td>{{ $item->alamat_customer }}</td>
                                        <td>{{ $item->email_customer }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="{{ '#edit' . $item->id_customer }}"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <div class="modal fade" id="{{ 'edit' . $item->id_customer }}" tabindex="-1"
                                                aria-labelledby="editCustomerLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('update-customer', $item->id_customer) }}"
                                                        class="modal-content">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="editCustomerLabel">Edit Customer
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mt-3">
                                                                <label for="nama_customer">Nama Customer</label>
                                                                <input type="text" value="{{ $item->nama_customer }}"
                                                                    class="form-control" required name="nama_customer"
                                                                    id="nama_customer">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="no_telp_customer">Nomor Telepon</label>
                                                                <input type="text" value="{{ $item->no_telp_customer }}"
                                                                    class="form-control" required name="no_telp_customer"
                                                                    id="no_telp_customer">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="alamat_customer">Alamat</label>
                                                                <input type="text" value="{{ $item->alamat_customer }}"
                                                                    class="form-control" required name="alamat_customer"
                                                                    id="alamat_customer">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="email_customer">Email</label>
                                                                <input type="email" value="{{ $item->email_customer }}"
                                                                    class="form-control" required name="email_customer"
                                                                    id="email_customer">
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

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="{{ '#delete' . $item->id_customer }}"><i
                                                    class="bi bi-trash"></i></button>
                                            <div class="modal fade" id="{{ 'delete' . $item->id_customer }}" tabindex="-1"
                                                aria-labelledby="deleteCustomerLabel" aria-hidden="true">
                                                <form action="{{ route('delete-customer', $item->id_customer) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                Apakah anda yakin menghapus customer
                                                                <strong>{{ $item->nama_customer }}</strong>?
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