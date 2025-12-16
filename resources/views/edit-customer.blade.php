@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-user-edit" style="color: #3b82f6; margin-right: 10px;"></i>Edit Customer
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Perbarui data customer</p>
    </div>

    <!-- Alert Messages -->
    @if ($message ?? false)
    <div class="alert" style="background: {{ $alertType === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)' }}; color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px;">
        <i class="fas {{ $alertType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }} me-2"></i>
        <span>{{ $message }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" style="border-radius: 15px; border-left: 4px solid #ef4444;">
        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan input:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Card -->
    <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="card-body" style="padding: 30px;">
            <form method="POST" action="{{ route('update-customer', $customer->id_customer) }}" id="customerForm">
                @csrf
                @method('PUT')

                <!-- Nama Customer -->
                <div class="mb-4">
                    <label class="form-label" style="font-weight: 600;">
                        <i class="fas fa-user me-2 text-primary"></i>Nama Customer <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama_customer"
                           class="form-control @error('nama_customer') is-invalid @enderror"
                           value="{{ old('nama_customer', $customer->nama_customer) }}"
                           required minlength="3" maxlength="100">
                    @error('nama_customer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label class="form-label" style="font-weight: 600;">
                        <i class="fas fa-phone me-2 text-success"></i>Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">+62</span>
                        <input type="tel"
                               name="no_telp_customer"
                               class="form-control @error('no_telp_customer') is-invalid @enderror"
                               value="{{ old('no_telp_customer', $customer->no_telp_customer) }}"
                               required minlength="10" maxlength="13"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        @error('no_telp_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label class="form-label" style="font-weight: 600;">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>Alamat <span class="text-danger">*</span>
                    </label>
                    <textarea name="alamat_customer"
                              class="form-control @error('alamat_customer') is-invalid @enderror"
                              rows="3"
                              required minlength="10">{{ old('alamat_customer', $customer->alamat_customer) }}</textarea>
                    @error('alamat_customer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="form-label" style="font-weight: 600;">
                        <i class="fas fa-envelope me-2 text-warning"></i>Email <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           name="email_customer"
                           class="form-control @error('email_customer') is-invalid @enderror"
                           value="{{ old('email_customer', $customer->email_customer) }}"
                           required maxlength="100">
                    @error('email_customer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between pt-3 border-top">
                    <a href="{{ route('management-customer') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn-success-custom px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('customerForm').addEventListener('submit', function(e) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const email = document.querySelector('[name="email_customer"]').value;
    if (!emailPattern.test(email)) {
        e.preventDefault();
        alert('Format email tidak valid!');
    }
});
</script>
@endsection
