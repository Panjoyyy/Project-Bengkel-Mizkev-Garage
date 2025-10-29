@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Tambah Layanan</strong></h5>
        <p class="card-text">Masukkan data layanan baru.</p>

        @if (!empty($message))
            <div class="alert alert-{{ $alertType }} mt-3">
                {{ $message }}
            </div>
        @endif

        <form method="POST" action="{{ route('create-service') }}" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="lokasi_layanan" class="form-label">Lokasi Layanan</label>
                <select class="form-select" name="lokasi_layanan" id="lokasi_layanan" required>
                    <option value="" selected disabled>Pilih lokasi layanan</option>
                    <option value="Garage Paingan">Garage Paingan</option>
                    <option value="Garage Mrican">Garage Mrican</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="harga_layanan" class="form-label">Harga</label>
                <input type="number" step="0.01" name="harga_layanan" id="harga_layanan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi_layanan" class="form-label">Deskripsi</label>
                <textarea name="deskripsi_layanan" id="deskripsi_layanan" rows="3" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="foto_layanan" class="form-label">Gambar</label>
                <input type="file" name="foto_layanan" id="foto_layanan" class="form-control" accept=".jpg,.png,.jpeg" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('management-layanan') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
