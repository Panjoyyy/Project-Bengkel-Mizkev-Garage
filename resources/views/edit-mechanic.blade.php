@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Edit Mekanik</strong></h5>
        <p class="card-text">Ubah data mekanik.</p>

        @if ($message ?? false)
            <div class="alert alert-{{ $alertType }} mt-3">
                {{ $message }}
            </div>
        @endif

        <form method="POST" action="{{ route('update-mechanic', $mechanic->id_mechanic) }}" 
              class="mt-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="mechanic_name" class="form-label">Nama Mekanik</label>
                <input type="text" name="mechanic_name" id="mechanic_name" class="form-control" required
                       value="{{ $mechanic->mechanic_name }}">
            </div>

            <div class="mb-3">
                <label for="mechanic_phone" class="form-label">Nomor Telepon</label>
                <input type="text" name="mechanic_phone" id="mechanic_phone" class="form-control" required
                       value="{{ $mechanic->mechanic_phone }}"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <div class="mb-3">
                <label for="mechanic_image" class="form-label">Gambar</label>
                <input type="file" name="mechanic_image" id="mechanic_image" class="form-control"
                       accept=".jpg,.png,.jpeg">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('management-mechanic') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
