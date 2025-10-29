@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Tambah Mekanik</strong></h5>
        <p class="card-text">Masukkan data mekanik baru.</p>

        @if ($message ?? false)
            <div class="alert alert-{{ $alertType }} mt-3">
                {{ $message }}
            </div>
        @endif

        <form method="POST" action="{{ route('create-mechanic') }}" class="mt-3" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="mechanic_name" class="form-label">Nama Mekanik</label>
                <input type="text" name="mechanic_name" id="mechanic_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mechanic_phone" class="form-label">Nomor Telepon</label>
                <input type="text" name="mechanic_phone" id="mechanic_phone" class="form-control" required
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <div class="mb-3">
                <label for="mechanic_image" class="form-label">Gambar</label>
                <input type="file" name="mechanic_image" id="mechanic_image" class="form-control" required
                       accept=".jpg,.png,.jpeg">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('management-mechanic') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
