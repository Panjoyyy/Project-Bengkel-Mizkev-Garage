@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-user-plus" style="color: #10b981; margin-right: 10px;"></i>Tambah Mekanik
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Masukkan data mekanik baru</p>
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
            <form method="POST" action="{{ route('create-mechanic') }}" enctype="multipart/form-data" id="mechanicForm">
                @csrf
                
                <!-- Nama Mekanik -->
                <div class="mb-4">
                    <label for="mechanic_name" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-user me-2" style="color: #3b82f6;"></i>Nama Mekanik <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="mechanic_name" 
                           id="mechanic_name" 
                           class="form-control @error('mechanic_name') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('mechanic_name') }}"
                           placeholder="Contoh: Budi Santoso"
                           required
                           minlength="3"
                           maxlength="100">
                    @error('mechanic_name')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label for="mechanic_phone" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-phone me-2" style="color: #10b981;"></i>Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; border-right: none; background: #f9fafb;">+62</span>
                        <input type="tel" 
                               name="mechanic_phone" 
                               id="mechanic_phone" 
                               class="form-control @error('mechanic_phone') is-invalid @enderror" 
                               style="border-radius: 0 10px 10px 0; padding: 12px 15px; border: 2px solid #e5e7eb; border-left: none;"
                               value="{{ old('mechanic_phone') }}"
                               placeholder="81234567890"
                               required
                               pattern="[0-9]{10,13}"
                               minlength="10"
                               maxlength="13"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('mechanic_phone')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Format: 10-13 digit angka (tanpa +62 atau 0 di depan)</small>
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label for="mechanic_image" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-camera me-2" style="color: #3b82f6;"></i>Foto Mekanik <span class="text-danger">*</span>
                    </label>
                    <input type="file" 
                           name="mechanic_image" 
                           id="mechanic_image" 
                           class="form-control @error('mechanic_image') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           accept="image/jpeg,image/jpg,image/png"
                           required
                           onchange="previewImage(event)">
                    @error('mechanic_image')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <p class="mb-2" style="font-weight: 600; color: #1a2332;">Preview:</p>
                        <img id="preview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('management-mechanic') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn-success-custom" style="padding: 12px 30px;">
                        <i class="fas fa-save me-2"></i>Simpan Mekanik
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image Preview
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid! Gunakan JPG, JPEG, atau PNG');
            event.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Form Validation
document.getElementById('mechanicForm').addEventListener('submit', function(e) {
    const mechanicName = document.getElementById('mechanic_name').value.trim();
    const mechanicPhone = document.getElementById('mechanic_phone').value;
    const mechanicImage = document.getElementById('mechanic_image').files[0];
    
    // Validate nama mekanik
    if (mechanicName.length < 3) {
        e.preventDefault();
        alert('Nama mekanik minimal 3 karakter!');
        return false;
    }
    
    // Validate phone
    if (mechanicPhone.length < 10 || mechanicPhone.length > 13) {
        e.preventDefault();
        alert('Nomor telepon harus 10-13 digit!');
        return false;
    }
    
    // Validate foto
    if (!mechanicImage) {
        e.preventDefault();
        alert('Pilih foto mekanik!');
        return false;
    }
    
    return true;
});
</script>
@endsection
