@extends('admin')

@section('content')
<div class="row">
    <div class="col-12 d-flex justify-content-between">
        <div class="">
            <h5 class="card-title"><strong>{{ $title }}</strong></h5>
            <p class="card-text">Manajemen Data Servis.</p>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addServis">+ Tambah Servis</button>

        {{-- Modal Tambah Servis --}}
        <div class="modal fade" id="addServis" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('servis.store') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Tambah Servis</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-3">
                            <label for="tanggal_servis">Tanggal & Waktu Servis</label>
                            <input type="datetime-local" class="form-control" name="tanggal_servis" id="tanggal_servis" required>
                        </div>
                        <div class="mt-3">
                            <label for="keluhan">Keluhan</label>
                            <textarea class="form-control" name="keluhan" id="keluhan" rows="3" required></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="id_motor">Motor</label>
                            <select class="form-control" name="id_motor" id="id_motor" required>
                                <option value="">-- Pilih Motor --</option>
                                @foreach ($motors as $motor)
                                    <option value="{{ $motor->id_motor }}">{{ $motor->id_motor }}. {{ $motor->merk_motor }} - {{ $motor->no_plat_motor }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="id_mechanic">Mekanik</label>
                            <select class="form-control" name="id_mechanic" id="id_mechanic" required>
                                <option value="">-- Pilih Mekanik --</option>
                                @foreach ($mechanics as $mekanik)
                                    <option value="{{ $mekanik->id_mechanic }}">
                                    {{ $mekanik->id_mechanic }}. {{ $mekanik->mechanic_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="id_staff">Staff</label>
                            <select class="form-control" name="id_staff" id="id_staff" required>
                                <option value="">-- Pilih Staff --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id_staff }}">{{ $staff->id_staff }}. {{ $staff->nama_staff }}</option>
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
                                <th>#</th>
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

                                        {{-- Tombol Edit --}}
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="{{ '#edit' . $item->id_servis }}"><i
                                                class="bi bi-pencil-square"></i></button>
                                        <div class="modal fade" id="{{ 'edit' . $item->id_servis }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('servis.update', $item->id_servis) }}"
                                                    class="modal-content">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Edit Servis</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mt-3">
                                                            <label for="tanggal_servis">Tanggal & Waktu Servis</label>
                                                            <input type="datetime-local" class="form-control"
                                                                name="tanggal_servis" value="{{ $item->tanggal_servis }}" required>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label for="keluhan">Keluhan</label>
                                                            <textarea class="form-control" name="keluhan" rows="3" required>{{ $item->keluhan }}</textarea>
                                                        </div>

                                                        <div class="mt-3">
                                                            <label for="id_motor">Motor</label>
                                                            <select class="form-control" name="id_motor" required>
                                                                @foreach ($motors as $motor)
                                                                   <option value="{{ $motor->id_motor }}"
                                                                    {{ $item->id_motor == $motor->id_motor ? 'selected' : '' }}>
                                                                   {{ $motor->id_motor }}. {{ $motor->merk_motor }} - {{ $motor->no_plat_motor }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mt-3">
                                                            <label for="id_mechanic">Mekanik</label>
                                                            <select class="form-control" name="id_mechanic" required>
                                                                @foreach ($mechanics as $mekanik)
                                                                    <option value="{{ $mekanik->id_mechanic }}"
                                                                    {{ $item->id_mechanic == $mekanik->id_mechanic ? 'selected' : '' }}>
                                                                    {{ $mekanik->id_mechanic }}. {{ $mekanik->mechanic_name }}
                                                                    </option>
                                                                    @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mt-3">
                                                            <label for="id_staff">Staff</label>
                                                            <select class="form-control" name="id_staff" required>
                                                                @foreach ($staffs as $staff)
                                                                    <option value="{{ $staff->id_staff }}"
                                                                        {{ $item->id_staff == $staff->id_staff ? 'selected' : '' }}>
                                                                        {{ $staff->id_staff }}. {{ $staff->nama_staff }}
                                                                    </option>
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
