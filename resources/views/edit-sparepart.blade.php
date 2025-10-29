@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Edit Sparepart</strong></h5>
        <p class="card-text">Perbarui data sparepart.</p>

        <form action="{{ route('spareparts.update', $sparepart->id_sparepart) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama_sparepart" class="form-label">Nama Sparepart</label>
                <input type="text" name="nama_sparepart" id="nama_sparepart" class="form-control" required value="{{ $sparepart->nama_sparepart }}">
            </div>
            <div class="mb-3">
                <label for="stok_sparepart" class="form-label">Stok</label>
                <input type="number" name="stok_sparepart" id="stok_sparepart" class="form-control" required value="{{ $sparepart->stok_sparepart }}">
            </div>
            <div class="mb-3">
                <label for="harga_sparepart" class="form-label">Harga (Rp)</label>
                <input type="number" name="harga_sparepart" id="harga_sparepart" class="form-control" required value="{{ $sparepart->harga_sparepart }}">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('spareparts.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
