@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">

    <!-- Header -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332;">
            <i class="fas fa-tools text-primary me-2"></i>Edit Servis
        </h2>
        <p class="text-muted">Perbarui data servis pelanggan</p>
    </div>

    <!-- Error -->
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('servis.update', $servis->id_servis) }}">
                @csrf
                @method('PUT')

                <!-- Tanggal Servis -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Servis
                    </label>
                    <input type="datetime-local"
                           name="tanggal_servis"
                           id="tanggal_servis"
                           class="form-control @error('tanggal_servis') is-invalid @enderror"
                           value="{{ old('tanggal_servis', date('Y-m-d\TH:i', strtotime($servis->tanggal_servis))) }}"
                           required>
                    @error('tanggal_servis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Customer (HANYA UNTUK FILTER MOTOR) -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user me-2 text-success"></i>Customer
                    </label>
                    <select id="id_customer" class="form-select">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id_customer }}"
                                {{ $servis->motor->id_customer == $customer->id_customer ? 'selected' : '' }}>
                                {{ $customer->nama_customer }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Digunakan untuk memfilter motor</small>
                </div>

                <!-- Motor -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-motorcycle me-2 text-warning"></i>Motor
                    </label>
                    <select name="id_motor"
                            id="id_motor"
                            class="form-select @error('id_motor') is-invalid @enderror"
                            required>
                        @foreach ($motors_for_customer as $motor)
                            <option value="{{ $motor->id_motor }}"
                                {{ old('id_motor', $servis->id_motor) == $motor->id_motor ? 'selected' : '' }}>
                                {{ $motor->merk_motor }} - {{ $motor->no_plat_motor }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_motor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mekanik -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user-cog me-2 text-info"></i>Mekanik
                    </label>
                    <select name="id_mechanic"
                            id="id_mechanic"
                            class="form-select @error('id_mechanic') is-invalid @enderror"
                            required>
                        @foreach ($mechanics as $mechanic)
                            <option value="{{ $mechanic->id_mechanic }}"
                                {{ old('id_mechanic', $servis->id_mechanic) == $mechanic->id_mechanic ? 'selected' : '' }}>
                                {{ $mechanic->mechanic_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_mechanic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Staff -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user-tie me-2 text-secondary"></i>Staff
                    </label>
                    <select name="id_staff"
                            id="id_staff"
                            class="form-select @error('id_staff') is-invalid @enderror"
                            required>
                        @foreach ($staffs as $staff)
                            <option value="{{ $staff->id_staff }}"
                                {{ old('id_staff', $servis->id_staff) == $staff->id_staff ? 'selected' : '' }}>
                                {{ $staff->nama_staff }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_staff')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Servis -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-sync-alt me-2 text-primary"></i>Status Servis
                    </label>
                    <select name="status_servis"
                            class="form-select @error('status_servis') is-invalid @enderror"
                            required>
                        <option value="Sedang Dikerjakan"
                            {{ $servis->status_servis == 'Sedang Dikerjakan' ? 'selected' : '' }}>
                            Sedang Dikerjakan
                        </option>
                        <option value="Selesai"
                            {{ $servis->status_servis == 'Selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>
                </div>

                <!-- Keluhan -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-comment-dots me-2 text-danger"></i>Keluhan
                    </label>
                    <textarea name="keluhan"
                              id="keluhan"
                              class="form-control @error('keluhan') is-invalid @enderror"
                              rows="3"
                              required>{{ old('keluhan', $servis->keluhan) }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-between border-top pt-3">
                    <a href="{{ route('management-servis') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- AJAX MOTOR -->
<script>
document.getElementById('id_customer').addEventListener('change', function () {
    const customerId = this.value;
    const motorSelect = document.getElementById('id_motor');

    motorSelect.innerHTML = '<option>Memuat...</option>';

    fetch(`/servis/motors/${customerId}`)
        .then(res => res.json())
        .then(data => {
            motorSelect.innerHTML = '';
            data.forEach(motor => {
                motorSelect.innerHTML +=
                    `<option value="${motor.id_motor}">
                        ${motor.merk_motor} - ${motor.no_plat_motor}
                    </option>`;
            });
        });
});
</script>

<script>
// Dynamic motor loading based on customer selection
document.getElementById('id_customer').addEventListener('change', function() {
    let customerId = this.value;
    let motorSelect = document.getElementById('id_motor');
    let motorHelp = document.getElementById('motorHelp');

    // Show loading state
    motorSelect.innerHTML = '<option value="">⏳ Memuat motor...</option>';
    motorSelect.disabled = true;
    motorHelp.textContent = 'Sedang memuat motor...';
    motorHelp.style.color = '#f59e0b';

    if(customerId) {
        let url = "{{ url('/servis/motors') }}/" + customerId;

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                motorSelect.innerHTML = '<option value="">-- Pilih Motor --</option>';
                
                if (data.length === 0) {
                    motorSelect.innerHTML += '<option value="" disabled>Tidak ada motor untuk customer ini</option>';
                    motorHelp.textContent = '⚠️ Customer ini belum memiliki motor';
                    motorHelp.style.color = '#ef4444';
                } else {
                    data.forEach(motor => {
                        motorSelect.innerHTML += `<option value="${motor.id_motor}">${motor.merk_motor} - ${motor.no_plat_motor}</option>`;
                    });
                    motorHelp.textContent = `✓ ${data.length} motor ditemukan`;
                    motorHelp.style.color = '#10b981';
                }
                motorSelect.disabled = false;
            })
            .catch(error => {
                motorSelect.innerHTML = '<option value="">❌ Gagal memuat motor</option>';
                motorHelp.textContent = 'Terjadi kesalahan saat memuat motor';
                motorHelp.style.color = '#ef4444';
                console.error('Error:', error);
                motorSelect.disabled = false;
            });
    } else {
        motorSelect.innerHTML = '<option value="">-- Pilih Motor --</option>';
        motorSelect.disabled = true;
        motorHelp.textContent = 'Pilih customer terlebih dahulu';
        motorHelp.style.color = '#6c757d';
    }
});

// Form validation
document.getElementById('servisForm').addEventListener('submit', function(e) {
    const tanggalServis = document.getElementById('tanggal_servis').value;
    const idCustomer = document.getElementById('id_customer').value;
    const idMotor = document.getElementById('id_motor').value;
    const idMechanic = document.getElementById('id_mechanic').value;
    const idStaff = document.getElementById('id_staff').value;
    const keluhan = document.getElementById('keluhan').value.trim();
    
    // Validate all required fields
    if (!tanggalServis) {
        e.preventDefault();
        alert('Pilih tanggal dan waktu servis!');
        return false;
    }
    
    if (!idCustomer) {
        e.preventDefault();
        alert('Pilih customer!');
        return false;
    }
    
    if (!idMotor) {
        e.preventDefault();
        alert('Pilih motor!');
        return false;
    }
    
    if (!idMechanic) {
        e.preventDefault();
        alert('Pilih mekanik!');
        return false;
    }
    
    if (!idStaff) {
        e.preventDefault();
        alert('Pilih staff!');
        return false;
    }
    
    if (keluhan.length < 10) {
        e.preventDefault();
        alert('Keluhan minimal 10 karakter!');
        return false;
    }
    
    return true;
});
</script>
@endsection
