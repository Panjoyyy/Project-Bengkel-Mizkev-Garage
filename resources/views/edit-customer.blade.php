@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Edit Customer</strong></h5>
        <p class="card-text">Ubah data customer.</p>

        @if ($message ?? false)
            <div class="alert alert-{{ $alertType }} mt-3">
                {{ $message }}
            </div>
        @endif

        <form method="POST" action="{{ route('update-customer', $customer->id_customer) }}" class="mt-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_customer" class="form-label">Nama Customer</label>
                <input type="text" name="nama_customer" id="nama_customer" class="form-control" required
                       value="{{ $customer->nama_customer }}">
            </div>

            <div class="mb-3">
                <label for="no_telp_customer" class="form-label">Nomor Telepon</label>
                <input type="text" name="no_telp_customer" id="no_telp_customer" class="form-control" required
                       value="{{ $customer->no_telp_customer }}"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <div class="mb-3">
                <label for="alamat_customer" class="form-label">Alamat</label>
                <input type="text" name="alamat_customer" id="alamat_customer" class="form-control" required
                       value="{{ $customer->alamat_customer }}">
            </div>

            <div class="mb-3">
                <label for="email_customer" class="form-label">Email</label>
                <input type="email" name="email_customer" id="email_customer" class="form-control" required
                       value="{{ $customer->email_customer }}">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('management-customer') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
