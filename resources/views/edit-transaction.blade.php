@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-edit" style="color: #f59e0b; margin-right: 10px;"></i>Edit Transaksi
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Update data transaksi servis</p>
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
            <form action="{{ route('transaction.update', $servis->id_servis) }}" method="POST" id="transactionForm">
                @csrf
                @method('PUT')
                
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
                               value="{{ old('tanggal_servis', date('Y-m-d\TH:i', strtotime($servis->tanggal_servis))) }}"
                               required>
                        @error('tanggal_servis')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Customer (Read Only) -->
                    <div class="col-md-6 mb-4">
                        <label for="customer_display" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-user me-2" style="color: #10b981;"></i>Customer
                        </label>
                        <input type="text" 
                               id="customer_display" 
                               class="form-control" 
                               style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb; background: #f9fafb;"
                               value="{{ $servis->motor->customer->nama_customer }} - {{ $servis->motor->customer->no_telp_customer }}"
                               readonly>
                        <small class="text-muted">Customer tidak dapat diubah</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Motor -->
                    <div class="col-md-6 mb-4">
                        <label for="id_motor" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-motorcycle me-2" style="color: #ef4444;"></i>Motor <span class="text-danger">*</span>
                        </label>
                        <select name="id_motor" 
                                id="id_motor" 
                                class="form-select @error('id_motor') is-invalid @enderror" 
                                style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                                required>
                            @foreach($motors->where('id_customer', $servis->motor->id_customer) as $motor)
                                <option value="{{ $motor->id_motor }}" {{ old('id_motor', $servis->id_motor) == $motor->id_motor ? 'selected' : '' }}>
                                    {{ $motor->merk_motor }} - {{ $motor->no_plat_motor }} ({{ $motor->warna_motor }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_motor')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Hanya motor dari customer yang sama</small>
                    </div>

                    <!-- Mekanik -->
                    <div class="col-md-6 mb-4">
                        <label for="id_mechanic" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-user-cog me-2" style="color: #3b82f6;"></i>Mekanik <span class="text-danger">*</span>
                        </label>
                        <select name="id_mechanic" 
                                id="id_mechanic" 
                                class="form-select @error('id_mechanic') is-invalid @enderror" 
                                style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                                required>
                            <option value="">Pilih Mekanik</option>
                            @foreach($mechanics as $mechanic)
                                <option value="{{ $mechanic->id_mechanic }}" {{ old('id_mechanic', $servis->id_mechanic) == $mechanic->id_mechanic ? 'selected' : '' }}>
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
                    <select name="id_staff" 
                            id="id_staff" 
                            class="form-select @error('id_staff') is-invalid @enderror" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="">Pilih Staff</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id_staff }}" {{ old('id_staff', $servis->id_staff) == $staff->id_staff ? 'selected' : '' }}>
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
                              maxlength="500">{{ old('keluhan', $servis->keluhan) }}</textarea>
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
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; border-radius: 10px; padding: 12px 30px; font-weight: 600; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Form validation
document.getElementById('transactionForm').addEventListener('submit', function(e) {
    const tanggalServis = document.getElementById('tanggal_servis').value;
    const idMotor = document.getElementById('id_motor').value;
    const idMechanic = document.getElementById('id_mechanic').value;
    const idStaff = document.getElementById('id_staff').value;
    const keluhan = document.getElementById('keluhan').value.trim();
    
    if (!tanggalServis) {
        e.preventDefault();
        alert('Tanggal & waktu servis harus diisi!');
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
