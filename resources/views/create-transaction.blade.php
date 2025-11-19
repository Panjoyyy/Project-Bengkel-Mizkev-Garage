@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-plus-circle" style="color: #3b82f6; margin-right: 10px;"></i>Tambah Transaksi
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Buat transaksi servis baru</p>
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
            <form action="{{ route('transaction.store') }}" method="POST" id="transactionForm">
                @csrf
                
                <div class="row">
                    <!-- Tanggal & Waktu Servis -->
                    <div class="col-md-6 mb-4">
                        <label for="tanggal_servis" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-calendar-check me-2" style="color: #3b82f6;"></i>Tanggal & Waktu Servis <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="tanggal_servis" 
                               id="tanggal_servis" 
                               class="form-control @error('tanggal_servis') is-invalid @enderror" 
                               style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                               value="{{ old('tanggal_servis') }}"
                               required>
                        @error('tanggal_servis')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Customer -->
                    <div class="col-md-6 mb-4">
                        <label for="id_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-user me-2" style="color: #10b981;"></i>Customer <span class="text-danger">*</span>
                        </label>
                        
                        <!-- Debug Info -->
                        @if($customers->count() == 0)
                        <div class="alert alert-warning mb-2" style="border-radius: 10px; padding: 10px 15px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Belum ada customer!</strong> Silakan tambah customer terlebih dahulu.
                            <a href="{{ route('create-customer-form') }}" class="btn btn-sm btn-primary ms-2">
                                <i class="fas fa-plus me-1"></i>Tambah Customer
                            </a>
                        </div>
                        @else
                        <small class="text-muted mb-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>{{ $customers->count() }} customer tersedia
                        </small>
                        @endif
                        
                        <select name="id_customer" 
                                id="id_customer" 
                                class="form-select @error('id_customer') is-invalid @enderror" 
                                style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                                required
                                onchange="loadMotors()"
                                {{ $customers->count() == 0 ? 'disabled' : '' }}>
                            <option value="">{{ $customers->count() == 0 ? 'Belum ada customer' : 'Pilih Customer' }}</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id_customer }}" {{ old('id_customer') == $customer->id_customer ? 'selected' : '' }}>
                                    {{ $customer->nama_customer }} - {{ $customer->no_telp_customer }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_customer')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Motor (Dynamic) -->
                    <div class="col-md-6 mb-4">
                        <label for="id_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-motorcycle me-2" style="color: #ef4444;"></i>Motor <span class="text-danger">*</span>
                        </label>
                        <select name="id_motor" 
                                id="id_motor" 
                                class="form-select @error('id_motor') is-invalid @enderror" 
                                style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                                required
                                disabled>
                            <option value="">Pilih customer terlebih dahulu</option>
                        </select>
                        @error('id_motor')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <small id="motorHelp" class="text-muted">Pilih customer untuk melihat motor</small>
                    </div>

                    <!-- Mekanik -->
                    <div class="col-md-6 mb-4">
                        <label for="id_mechanic" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-user-cog me-2" style="color: #3b82f6;"></i>Mekanik <span class="text-danger">*</span>
                        </label>
                        
                        @if($mechanics->count() == 0)
                        <div class="alert alert-warning mb-2" style="border-radius: 10px; padding: 10px 15px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Belum ada mekanik!</strong>
                            <a href="{{ route('create-mechanic-form') }}" class="btn btn-sm btn-primary ms-2">
                                <i class="fas fa-plus me-1"></i>Tambah Mekanik
                            </a>
                        </div>
                        @else
                        <small class="text-muted mb-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>{{ $mechanics->count() }} mekanik tersedia
                        </small>
                        @endif
                        
                        <select name="id_mechanic" 
                                id="id_mechanic" 
                                class="form-select @error('id_mechanic') is-invalid @enderror" 
                                style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                                required
                                {{ $mechanics->count() == 0 ? 'disabled' : '' }}>
                            <option value="">{{ $mechanics->count() == 0 ? 'Belum ada mekanik' : 'Pilih Mekanik' }}</option>
                            @foreach($mechanics as $mechanic)
                                <option value="{{ $mechanic->id_mechanic }}" {{ old('id_mechanic') == $mechanic->id_mechanic ? 'selected' : '' }}>
                                    {{ $mechanic->mechanic_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_mechanic')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Staff -->
                <div class="mb-4">
                    <label for="id_staff" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user-tie me-2" style="color: #f59e0b;"></i>Staff <span class="text-danger">*</span>
                    </label>
                    
                    @if($staffs->count() == 0)
                    <div class="alert alert-warning mb-2" style="border-radius: 10px; padding: 10px 15px;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Belum ada staff!</strong> Silakan tambah staff terlebih dahulu di menu Staff.
                    </div>
                    @else
                    <small class="text-muted mb-2 d-block">
                        <i class="fas fa-info-circle me-1"></i>{{ $staffs->count() }} staff tersedia
                    </small>
                    @endif
                    
                    <select name="id_staff" 
                            id="id_staff" 
                            class="form-select @error('id_staff') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required
                            {{ $staffs->count() == 0 ? 'disabled' : '' }}>
                        <option value="">{{ $staffs->count() == 0 ? 'Belum ada staff' : 'Pilih Staff' }}</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id_staff }}" {{ old('id_staff') == $staff->id_staff ? 'selected' : '' }}>
                                {{ $staff->staff_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_staff')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keluhan -->
                <div class="mb-4">
                    <label for="keluhan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-comment-dots me-2" style="color: #10b981;"></i>Keluhan <span class="text-danger">*</span>
                    </label>
                    <textarea name="keluhan" 
                              id="keluhan" 
                              rows="4" 
                              class="form-control @error('keluhan') is-invalid @enderror" 
                              style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                              placeholder="Deskripsikan keluhan atau kerusakan motor..."
                              required
                              minlength="10"
                              maxlength="500">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('transaction') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 10px; padding: 12px 30px; font-weight: 600; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
                        <i class="fas fa-save me-2"></i>Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Load motors based on selected customer
function loadMotors() {
    const customerId = document.getElementById('id_customer').value;
    const motorSelect = document.getElementById('id_motor');
    const motorHelp = document.getElementById('motorHelp');
    
    if (!customerId) {
        motorSelect.innerHTML = '<option value="">Pilih customer terlebih dahulu</option>';
        motorSelect.disabled = true;
        motorHelp.textContent = 'Pilih customer untuk melihat motor';
        motorHelp.style.color = '#6c757d';
        return;
    }
    
    motorSelect.disabled = true;
    motorSelect.innerHTML = '<option value="">Memuat motor...</option>';
    motorHelp.textContent = '⏳ Memuat data motor...';
    motorHelp.style.color = '#f59e0b';
    
    fetch(`/api/motors/customer/${customerId}`)
        .then(response => response.json())
        .then(data => {
            motorSelect.innerHTML = '';
            
            if (data.length === 0) {
                motorSelect.innerHTML = '<option value="">Customer ini belum memiliki motor</option>';
                motorHelp.textContent = '⚠️ Customer ini belum memiliki motor terdaftar';
                motorHelp.style.color = '#ef4444';
                motorSelect.disabled = true;
            } else {
                motorSelect.innerHTML = '<option value="">Pilih Motor</option>';
                data.forEach(motor => {
                    const option = document.createElement('option');
                    option.value = motor.id_motor;
                    option.textContent = `${motor.merk_motor} - ${motor.no_plat_motor} (${motor.warna_motor})`;
                    motorSelect.appendChild(option);
                });
                motorSelect.disabled = false;
                motorHelp.textContent = `✓ ${data.length} motor ditemukan`;
                motorHelp.style.color = '#10b981';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            motorSelect.innerHTML = '<option value="">Gagal memuat motor</option>';
            motorHelp.textContent = '❌ Gagal memuat data motor';
            motorHelp.style.color = '#ef4444';
            motorSelect.disabled = true;
        });
}

// Form validation
document.getElementById('transactionForm').addEventListener('submit', function(e) {
    const tanggalServis = document.getElementById('tanggal_servis').value;
    const idCustomer = document.getElementById('id_customer').value;
    const idMotor = document.getElementById('id_motor').value;
    const idMechanic = document.getElementById('id_mechanic').value;
    const idStaff = document.getElementById('id_staff').value;
    const keluhan = document.getElementById('keluhan').value.trim();
    
    if (!tanggalServis) {
        e.preventDefault();
        alert('Tanggal & waktu servis harus diisi!');
        return false;
    }
    
    if (!idCustomer) {
        e.preventDefault();
        alert('Customer harus dipilih!');
        return false;
    }
    
    if (!idMotor) {
        e.preventDefault();
        alert('Motor harus dipilih!');
        return false;
    }
    
    if (!idMechanic) {
        e.preventDefault();
        alert('Mekanik harus dipilih!');
        return false;
    }
    
    if (!idStaff) {
        e.preventDefault();
        alert('Staff harus dipilih!');
        return false;
    }
    
    if (keluhan.length < 10) {
        e.preventDefault();
        alert('Keluhan minimal 10 karakter!');
        return false;
    }
    
    if (keluhan.length > 500) {
        e.preventDefault();
        alert('Keluhan maksimal 500 karakter!');
        return false;
    }
    
    return true;
});
</script>
@endsection
