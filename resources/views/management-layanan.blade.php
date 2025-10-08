@extends('admin')

@section('content')
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>        
            <h5 class="card-title"><strong>{{ $title }}</strong></h5>
            <p class="card-text">Manajemen Data Layanan.</p>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addService">+ Tambah Layanan</button>
    </div>
</div>

{{-- Modal Tambah Layanan --}}
<div class="modal fade" id="addService" tabindex="-1" aria-labelledby="addServiceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('create-service') }}" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addServiceLabel">Tambah Layanan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    <label for="nama_layanan">Nama Layanan</label>
                    <input type="text" class="form-control" required name="nama_layanan" id="nama_layanan" placeholder="Masukkan nama layanan">
                </div>
                <div class="mt-3">
                    <label for="lokasi_layanan">Lokasi Layanan</label>
                    <input type="text" class="form-control" required name="lokasi_layanan" id="lokasi_layanan" placeholder="Masukkan lokasi layanan">
                </div>
                <div class="mt-3">
                    <label for="harga_layanan">Harga</label>
                    <input type="number" step="0.01" class="form-control" required name="harga_layanan" id="harga_layanan" placeholder="Masukkan harga layanan">
                </div>
                <div class="mt-3">
                    <label for="deskripsi_layanan">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi_layanan" id="deskripsi_layanan" rows="3"></textarea>
                </div>
                <div class="mt-3">
                    <label for="foto_layanan">Gambar</label>
                    <input type="file" accept=".jpg,.png,.jpeg" class="form-control" required name="foto_layanan" id="foto_layanan">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
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
                                <th>#</th>
                                <th>ID Layanan</th>
                                <th>Layanan</th>
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
                                    {{-- Tombol Hapus --}}
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id_layanan }}">
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

                                    {{-- Tombol Edit --}}
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id_layanan }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <div class="modal fade" id="edit{{ $item->id_layanan }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('update-service', $item->id_layanan) }}" class="modal-content" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Edit Layanan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mt-3">
                                                        <label for="nama_layanan">Nama Layanan</label>
                                                        <input type="text" value="{{ $item->nama_layanan }}" class="form-control" required name="nama_layanan">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="lokasi_layanan">Lokasi Layanan</label>
                                                        <input type="text" value="{{ $item->lokasi_layanan }}" class="form-control" required name="lokasi_layanan">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="harga_layanan">Harga</label>
                                                        <input type="text" step="0.01" value="{{ $item->harga_layanan }}" class="form-control" required name="harga_layanan">

                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="deskripsi_layanan">Deskripsi</label>
                                                        <textarea name="deskripsi_layanan" class="form-control" rows="3">{{ $item->deskripsi_layanan }}</textarea>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="foto_layanan">Gambar</label>
                                                        <input type="file" accept=".jpg,.png,.jpeg" class="form-control" name="foto_layanan">
                                                        <a href="{{ asset('img/services/'.$item->foto_layanan) }}" target="_blank">Preview</a>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
@endsection
