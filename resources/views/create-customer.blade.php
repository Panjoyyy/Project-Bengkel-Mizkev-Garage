@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-user-plus" style="color: #10b981; margin-right: 10px;"></i>Tambah Customer
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Masukkan data customer baru</p>
    </div>

    <!-- Alert Messages -->
    @if ($message ?? false)
    <div class="alert" style="background: {{ $alertType === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)' }}; color: white; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" data-aos="fade-down">
        <i class="fas {{ $alertType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }} me-2"></i>
        <span>{{ $message }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" style="border-radius: 15px; border-left: 4px solid #ef4444;" data-aos="fade-down">
        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan input:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Card -->
    <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);" data-aos="fade-up">
        <div class="card-body" style="padding: 30px;">
            <form method="POST" action="{{ route('create-customer') }}" id="customerForm">
                @csrf
                
                <!-- Nama Customer -->
                <div class="mb-4">
                    <label for="nama_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user me-2" style="color: #3b82f6;"></i>Nama Customer <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="nama_customer" 
                           id="nama_customer" 
                           class="form-control @error('nama_customer') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('nama_customer') }}"
                           placeholder="Contoh: Ahmad Rizki"
                           required
                           minlength="3"
                           maxlength="100">
                    @error('nama_customer')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label for="no_telp_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-phone me-2" style="color: #10b981;"></i>Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; border-right: none; background: #f9fafb;">+62</span>
                        <input type="tel" 
                               name="no_telp_customer" 
                               id="no_telp_customer" 
                               class="form-control @error('no_telp_customer') is-invalid @enderror" 
                               style="border-radius: 0 10px 10px 0; padding: 12px 15px; border: 2px solid #e5e7eb; border-left: none;"
                               value="{{ old('no_telp_customer') }}"
                               placeholder="81234567890"
                               required
                               pattern="[0-9]{10,13}"
                               minlength="10"
                               maxlength="13"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('no_telp_customer')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Format: 10-13 digit angka (tanpa +62 atau 0 di depan)</small>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>Alamat <span class="text-danger">*</span>
                    </label>
                    <textarea name="alamat_customer" 
                              id="alamat_customer" 
                              rows="3" 
                              class="form-control @error('alamat_customer') is-invalid @enderror"
                              style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                              placeholder="Masukkan alamat lengkap..."
                              required
                              minlength="10"
                              maxlength="200">{{ old('alamat_customer') }}</textarea>
                    @error('alamat_customer')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 10 karakter, maksimal 200 karakter</small>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-envelope me-2" style="color: #f59e0b;"></i>Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" 
                           name="email_customer" 
                           id="email_customer" 
                           class="form-control @error('email_customer') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('email_customer') }}"
                           placeholder="contoh@email.com"
                           required
                           maxlength="100">
                    @error('email_customer')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format email yang valid (contoh@email.com)</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('management-customer') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn-success-custom" style="padding: 12px 30px;">
                        <i class="fas fa-save me-2"></i>Simpan Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Form Validation
document.getElementById('customerForm').addEventListener('submit', function(e) {
    const namaCustomer = document.getElementById('nama_customer').value.trim();
    const noTelpCustomer = document.getElementById('no_telp_customer').value;
    const alamatCustomer = document.getElementById('alamat_customer').value.trim();
    const emailCustomer = document.getElementById('email_customer').value.trim();
    
    // Validate nama
    if (namaCustomer.length < 3) {
        e.preventDefault();
        alert('Nama customer minimal 3 karakter!');
        return false;
    }
    
    // Validate phone
    if (noTelpCustomer.length < 10 || noTelpCustomer.length > 13) {
        e.preventDefault();
        alert('Nomor telepon harus 10-13 digit!');
        return false;
    }
    
    // Validate alamat
    if (alamatCustomer.length < 10) {
        e.preventDefault();
        alert('Alamat minimal 10 karakter!');
        return false;
    }
    
    // Validate email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailCustomer)) {
        e.preventDefault();
        alert('Format email tidak valid!');
        return false;
    }
    
    return true;
});
</script>
@endsection
