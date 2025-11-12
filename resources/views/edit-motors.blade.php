@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-motorcycle" style="color: #f59e0b; margin-right: 10px;"></i>Edit Motor
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Update data motor</p>
    </div>

    <!-- Alert Messages -->
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
            <form action="{{ route('motor.update', $motor->id_motor) }}" method="POST" id="motorForm">
                @csrf
                @method('PUT')
                
                <!-- No Plat Motor -->
                <div class="mb-4">
                    <label for="no_plat_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-id-card me-2" style="color: #3b82f6;"></i>No Plat Motor <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="no_plat_motor" 
                           id="no_plat_motor" 
                           class="form-control @error('no_plat_motor') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb; text-transform: uppercase;"
                           value="{{ old('no_plat_motor', $motor->no_plat_motor) }}"
                           placeholder="Contoh: B 1234 XYZ"
                           required
                           maxlength="15"
                           oninput="this.value = this.value.toUpperCase()">
                    @error('no_plat_motor')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: Huruf dan angka, maksimal 15 karakter</small>
                </div>

                <!-- Merk Motor -->
                <div class="mb-4">
                    <label for="merk_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-tag me-2" style="color: #10b981;"></i>Merk Motor <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="merk_motor" 
                           id="merk_motor" 
                           class="form-control @error('merk_motor') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('merk_motor', $motor->merk_motor) }}"
                           placeholder="Contoh: Honda Beat"
                           required
                           minlength="2"
                           maxlength="50">
                    @error('merk_motor')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 2 karakter, maksimal 50 karakter</small>
                </div>

                <!-- Warna Motor -->
                <div class="mb-4">
                    <label for="warna_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-palette me-2" style="color: #3b82f6;"></i>Warna Motor <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="warna_motor" 
                           id="warna_motor" 
                           class="form-control @error('warna_motor') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('warna_motor', $motor->warna_motor) }}"
                           placeholder="Contoh: Hitam Metalik"
                           required
                           minlength="3"
                           maxlength="30">
                    @error('warna_motor')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 3 karakter, maksimal 30 karakter</small>
                </div>

                <!-- Tahun Motor -->
                <div class="mb-4">
                    <label for="tahun_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-calendar-alt me-2" style="color: #f59e0b;"></i>Tahun Motor <span class="text-danger">*</span>
                    </label>
                    <select name="tahun_motor" 
                            id="tahun_motor" 
                            class="form-select @error('tahun_motor') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="" disabled>Pilih Tahun</option>
                        @for ($year = date('Y'); $year >= 1990; $year--)
                            <option value="{{ $year }}" {{ old('tahun_motor', $motor->tahun_motor) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    @error('tahun_motor')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Pilih tahun pembuatan motor (1990 - {{ date('Y') }})</small>
                </div>

                <!-- Pemilik (Customer) -->
                <div class="mb-4">
                    <label for="id_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user me-2" style="color: #ef4444;"></i>Pemilik (Customer) <span class="text-danger">*</span>
                    </label>
                    
                    <!-- Search Input -->
                    <div class="mb-2">
                        <input type="text" 
                               id="customerSearch" 
                               class="form-control" 
                               style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                               placeholder="🔍 Cari customer...">
                    </div>
                    
                    <!-- Customer Select -->
                    <select name="id_customer" 
                            id="customerSelect" 
                            class="form-select @error('id_customer') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="">--Pilih Customer--</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id_customer }}" {{ $motor->id_customer == $customer->id_customer ? 'selected' : '' }}>
                                {{ $customer->nama_customer }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_customer')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Gunakan search box untuk mencari customer dengan cepat</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('motor.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; border-radius: 10px; padding: 12px 30px; font-weight: 600; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Customer search functionality
const searchInput = document.getElementById('customerSearch');
const customerSelect = document.getElementById('customerSelect');
const allOptions = Array.from(customerSelect.options);

searchInput.addEventListener('input', function() {
    const search = this.value.toLowerCase();
    customerSelect.innerHTML = '';
    allOptions.forEach(option => {
        if (option.text.toLowerCase().includes(search) || option.value === "") {
            customerSelect.appendChild(option);
        }
    });
});

// Form validation
document.getElementById('motorForm').addEventListener('submit', function(e) {
    const noPlatMotor = document.getElementById('no_plat_motor').value.trim();
    const merkMotor = document.getElementById('merk_motor').value.trim();
    const warnaMotor = document.getElementById('warna_motor').value.trim();
    const tahunMotor = document.getElementById('tahun_motor').value;
    const idCustomer = document.getElementById('customerSelect').value;
    
    // Validate no plat
    if (noPlatMotor.length === 0 || noPlatMotor.length > 15) {
        e.preventDefault();
        alert('No plat motor maksimal 15 karakter!');
        return false;
    }
    
    // Validate merk
    if (merkMotor.length < 2) {
        e.preventDefault();
        alert('Merk motor minimal 2 karakter!');
        return false;
    }
    
    // Validate warna
    if (warnaMotor.length < 3) {
        e.preventDefault();
        alert('Warna motor minimal 3 karakter!');
        return false;
    }
    
    // Validate tahun
    if (!tahunMotor) {
        e.preventDefault();
        alert('Pilih tahun motor!');
        return false;
    }
    
    // Validate customer
    if (!idCustomer) {
        e.preventDefault();
        alert('Pilih pemilik motor!');
        return false;
    }
    
    return true;
});
</script>
@endsection
