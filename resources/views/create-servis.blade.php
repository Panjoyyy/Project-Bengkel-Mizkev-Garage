@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-tools" style="color: #10b981; margin-right: 10px;"></i>Tambah Servis
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Masukkan data servis baru</p>
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
            <form method="POST" action="{{ route('servis.store') }}" id="servisForm">
                @csrf
                
                <!-- Tanggal & Waktu Servis -->
                <div class="mb-4">
                    <label for="tanggal_servis" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-calendar-alt me-2" style="color: #3b82f6;"></i>Tanggal & Waktu Servis <span class="text-danger">*</span>
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
                    <small class="text-muted">Pilih tanggal dan waktu servis</small>
                </div>

                <!-- Customer -->
                <div class="mb-4">
                    <label for="id_customer" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user me-2" style="color: #10b981;"></i>Customer <span class="text-danger">*</span>
                    </label>
                    <select name="id_customer" 
                            id="id_customer" 
                            class="form-select @error('id_customer') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="">-- Pilih Customer --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id_customer }}" {{ old('id_customer') == $customer->id_customer ? 'selected' : '' }}>
                                {{ $customer->nama_customer }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_customer')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Pilih customer pemilik motor</small>
                </div>

                <!-- Motor -->
                <div class="mb-4">
                    <label for="id_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-motorcycle me-2" style="color: #f59e0b;"></i>Motor <span class="text-danger">*</span>
                    </label>
                    <select name="id_motor" 
                            id="id_motor" 
                            class="form-select @error('id_motor') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required
                            disabled>
                        <option value="">-- Pilih Customer Terlebih Dahulu --</option>
                    </select>
                    @error('id_motor')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Motor akan muncul setelah memilih customer</small>
                </div>

                <!-- Mekanik -->
                <div class="mb-4">
                    <label for="id_mechanic" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user-cog me-2" style="color: #3b82f6;"></i>Mekanik <span class="text-danger">*</span>
                    </label>
                    <select name="id_mechanic" 
                            id="id_mechanic" 
                            class="form-select @error('id_mechanic') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="">-- Pilih Mekanik --</option>
                        @foreach ($mechanics as $mekanik)
                            <option value="{{ $mekanik->id_mechanic }}" {{ old('id_mechanic') == $mekanik->id_mechanic ? 'selected' : '' }}>
                                {{ $mekanik->mechanic_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_mechanic')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Pilih mekanik yang akan menangani</small>
                </div>

                <!-- Staff -->
                <div class="mb-4">
                    <label for="id_staff" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user-tie me-2" style="color: #ef4444;"></i>Staff <span class="text-danger">*</span>
                    </label>
                    <select name="id_staff" 
                            id="id_staff" 
                            class="form-select @error('id_staff') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="">-- Pilih Staff --</option>
                        @foreach ($staffs as $staff)
                            <option value="{{ $staff->id_staff }}" {{ old('id_staff') == $staff->id_staff ? 'selected' : '' }}>
                                {{ $staff->nama_staff }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_staff')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Pilih staff yang mencatat servis</small>
                </div>

                <!-- Keluhan -->
                <div class="mb-4">
                    <label for="keluhan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-comment-alt me-2" style="color: #06b6d4;"></i>Keluhan <span class="text-danger">*</span>
                    </label>
                    <textarea name="keluhan" 
                              id="keluhan" 
                              rows="4" 
                              class="form-control @error('keluhan') is-invalid @enderror"
                              style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                              placeholder="Masukkan keluhan atau kerusakan motor..."
                              required
                              minlength="10"
                              maxlength="500">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Keluhan minimal 5 karakter!</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('management-servis') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn-success-custom" style="padding: 12px 30px;">
                        <i class="fas fa-save me-2"></i>Simpan Servis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Dynamic Motor Selection based on Customer
document.getElementById('id_customer').addEventListener('change', function() {
    let customerId = this.value;
    let motorSelect = document.getElementById('id_motor');

    if(customerId) {
        motorSelect.disabled = false;
        motorSelect.innerHTML = '<option value="">-- Memuat Motor... --</option>';

        let url = "{{ url('/servis/motors') }}/" + customerId;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                motorSelect.innerHTML = '<option value="">-- Pilih Motor --</option>';
                if(data.length > 0) {
                    data.forEach(motor => {
                        motorSelect.innerHTML += `<option value="${motor.id_motor}">${motor.merk_motor} - ${motor.no_plat_motor}</option>`;
                    });
                } else {
                    motorSelect.innerHTML = '<option value="">-- Customer belum memiliki motor --</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                motorSelect.innerHTML = '<option value="">-- Error memuat motor --</option>';
            });
    } else {
        motorSelect.disabled = true;
        motorSelect.innerHTML = '<option value="">-- Pilih Customer Terlebih Dahulu --</option>';
    }
});

// Form Validation
document.getElementById('servisForm').addEventListener('submit', function(e) {
    const tanggalServis = document.getElementById('tanggal_servis').value;
    const idCustomer = document.getElementById('id_customer').value;
    const idMotor = document.getElementById('id_motor').value;
    const idMechanic = document.getElementById('id_mechanic').value;
    const idStaff = document.getElementById('id_staff').value;
    const keluhan = document.getElementById('keluhan').value.trim();
    
    // Validate tanggal
    if (!tanggalServis) {
        e.preventDefault();
        alert('Pilih tanggal dan waktu servis!');
        return false;
    }
    
    // Validate customer
    if (!idCustomer) {
        e.preventDefault();
        alert('Pilih customer!');
        return false;
    }
    
    // Validate motor
    if (!idMotor) {
        e.preventDefault();
        alert('Pilih motor!');
        return false;
    }
    
    // Validate mechanic
    if (!idMechanic) {
        e.preventDefault();
        alert('Pilih mekanik!');
        return false;
    }
    
    // Validate staff
    if (!idStaff) {
        e.preventDefault();
        alert('Pilih staff!');
        return false;
    }
    
    // Validate keluhan
    if (keluhan.length < 5) {
        e.preventDefault();
        alert('Keluhan minimal 5 karakter!');
        return false;
    }
    
    return true;
});
</script>
@endsection
