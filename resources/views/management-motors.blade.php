@extends('admin')

@section('content')

    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="">
                <h5 class="card-title"><strong>{{ $title }}</strong></h5>
                <p class="card-text">Manajemen Data Motor.</p>
            </div>
            
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMotor">+ Tambah Motor</button>

            <!-- Tambah Motor -->
            <div class="modal fade" id="addMotor" tabindex="-1" aria-labelledby="addMotorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('motor.store') }}" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addMotorLabel">Tambah Motor</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-3">
                                <label>No Plat Motor</label>
                                <input type="text" name="no_plat_motor" class="form-control" required>
                            </div>
                            <div class="mt-3">
                                <label>Merk Motor</label>
                                <input type="text" name="merk_motor" class="form-control" required>
                            </div>
                            <div class="mt-3">
                                <label>Warna Motor</label>
                                <input type="text" name="warna_motor" class="form-control" required>
                            </div>
                            <div class="mt-3">
                                <label>Tahun Motor</label>
                                <input type="number" name="tahun_motor" class="form-control" required>
                            </div>
                            <div class="mt-3">
                                <label>Pemilik (Customer)</label>
                                <select name="id_customer" class="form-control" required>
                                    <option value="">--Pilih Customer--</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id_customer }}">{{ $customer->nama_customer }}</option>
                                    @endforeach
                                </select>
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
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID Motor</th>
                                    <th>No Plat</th>
                                    <th>Merk</th>
                                    <th>Warna</th>
                                    <th>Tahun</th>
                                    <th>ID Customer</th>
                                    <th>Nama Customer</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($motors as $motor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $motor->id_motor }}</td>
                                        <td>{{ $motor->no_plat_motor }}</td>
                                        <td>{{ $motor->merk_motor }}</td>
                                        <td>{{ $motor->warna_motor }}</td>
                                        <td>{{ $motor->tahun_motor }}</td>
                                        <td>{{ $motor->id_customer }}</td>
                                        <td>{{ $motor->customer->nama_customer ?? '-' }}</td>
                                        <td>
                                            <!-- Edit -->
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editMotor{{ $motor->id_motor }}"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <div class="modal fade" id="editMotor{{ $motor->id_motor }}" tabindex="-1"
                                                aria-labelledby="editMotorLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST" action="{{ route('motor.update', $motor->id_motor) }}"
                                                        class="modal-content">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="editMotorLabel">Edit Motor</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mt-3">
                                                                <label>No Plat Motor</label>
                                                                <input type="text" name="no_plat_motor" class="form-control"
                                                                    value="{{ $motor->no_plat_motor }}" required>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label>Merk Motor</label>
                                                                <input type="text" name="merk_motor" class="form-control"
                                                                    value="{{ $motor->merk_motor }}" required>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label>Warna Motor</label>
                                                                <input type="text" name="warna_motor" class="form-control"
                                                                    value="{{ $motor->warna_motor }}" required>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label>Tahun Motor</label>
                                                                <input type="number" name="tahun_motor" class="form-control"
                                                                    value="{{ $motor->tahun_motor }}" required>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label>Pemilik (Customer)</label>
                                                                <select name="id_customer" class="form-control" required>
                                                                    <option value="">--Pilih Customer--</option>
                                                                    @foreach($customers as $customer)
                                                                        <option value="{{ $customer->id_customer }}" {{ $motor->id_customer == $customer->id_customer ? 'selected' : '' }}>{{ $customer->nama_customer }}</option>
                                                                    @endforeach
                                                                </select>
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

                                            <!-- Hapus -->
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