@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Edit Layanan</strong></h5>
        <p class="card-text">Perbarui data layanan.</p>

        <form action="{{ route('update-service', $service->id_layanan) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" required
                       value="{{ $service->nama_layanan }}">
            </div>

            <div class="mb-3">
                <label for="lokasi_layanan" class="form-label">Lokasi Layanan</label>
                <select class="form-select" name="lokasi_layanan" id="lokasi_layanan" required>
                    <option value="Garage Paingan" {{ $service->lokasi_layanan=='Garage Paingan' ? 'selected' : '' }}>Garage Paingan</option>
                    <option value="Garage Mrican" {{ $service->lokasi_layanan=='Garage Mrican' ? 'selected' : '' }}>Garage Mrican</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="harga_layanan" class="form-label">Harga</label>
                <input type="number" name="harga_layanan" id="harga_layanan" class="form-control" required
                       value="{{ $service->harga_layanan }}">
            </div>

            <div class="mb-3">
                <label for="deskripsi_layanan" class="form-label">Deskripsi</label>
                <textarea name="deskripsi_layanan" id="deskripsi_layanan" class="form-control" rows="3">{{ $service->deskripsi_layanan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="foto_layanan" class="form-label">Gambar</label>
                <input type="file" name="foto_layanan" id="foto_layanan" class="form-control" accept=".jpg,.png,.jpeg">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('management-layanan') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
