@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Tambah Customer</strong></h5>
        <p class="card-text">Masukkan data customer baru.</p>

        @if ($message ?? false)
            <div class="alert alert-{{ $alertType }} mt-3">
                {{ $message }}
            </div>
        @endif

        <form method="POST" action="{{ route('create-customer') }}" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="nama_customer" class="form-label">Nama Customer</label>
                <input type="text" name="nama_customer" id="nama_customer" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="no_telp_customer" class="form-label">Nomor Telepon</label>
                <input type="text" name="no_telp_customer" id="no_telp_customer" class="form-control" required
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <div class="mb-3">
                <label for="alamat_customer" class="form-label">Alamat</label>
                <input type="text" name="alamat_customer" id="alamat_customer" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email_customer" class="form-label">Email</label>
                <input type="email" name="email_customer" id="email_customer" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('management-customer') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
