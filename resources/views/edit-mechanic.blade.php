@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-user-edit" style="color: #f59e0b; margin-right: 10px;"></i>Edit Mekanik
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Ubah data mekanik</p>
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
            <form method="POST" action="{{ route('update-mechanic', $mechanic->id_mechanic) }}" enctype="multipart/form-data" id="mechanicForm">
                @csrf
                @method('PUT')
                
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
                           value="{{ old('mechanic_name', $mechanic->mechanic_name) }}"
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
                               value="{{ old('mechanic_phone', $mechanic->mechanic_phone) }}"
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
                        <i class="fas fa-camera me-2" style="color: #3b82f6;"></i>Foto Mekanik
                    </label>
                    
                    <!-- Current Image or Avatar -->
                    <div class="mb-3">
                        @if(isset($mechanic->mechanic_image) && $mechanic->mechanic_image != '' && $mechanic->mechanic_image != null)
                        <p class="mb-2" style="font-weight: 600; color: #1a2332; font-size: 0.9rem;">
                            <i class="fas fa-image me-2" style="color: #10b981;"></i>Foto saat ini:
                        </p>
                        @else
                        <p class="mb-2" style="font-weight: 600; color: #6c757d; font-size: 0.9rem;">
                            <i class="fas fa-user-circle me-2"></i>Avatar default (belum ada foto):
                        </p>
                        @endif
                        
                        <div style="display: inline-block; position: relative;">
                            @if(isset($mechanic->mechanic_image) && $mechanic->mechanic_image != '' && $mechanic->mechanic_image != null)
                            <img src="{{ asset('img/mechanics/' . $mechanic->mechanic_image) }}" 
                                 alt="Foto {{ $mechanic->mechanic_name }}" 
                                 id="currentImage"
                                 style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; border: 3px solid #10b981;"
                                 onclick="openCurrentImageModal()"
                                 onerror="this.style.border='3px solid #6c757d'; this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($mechanic->mechanic_name) }}&size=150&background=3b82f6&color=fff';">
                            <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(16, 185, 129, 0.9); color: white; padding: 8px; border-radius: 50%; font-size: 0.9rem; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-search-plus"></i>
                            </div>
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mechanic->mechanic_name) }}&size=150&background=6c757d&color=fff" 
                                 alt="Avatar {{ $mechanic->mechanic_name }}" 
                                 style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 3px solid #e5e7eb;">
                            <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(108, 117, 125, 0.9); color: white; padding: 8px; border-radius: 50%; font-size: 0.9rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <input type="file" 
                           name="mechanic_image" 
                           id="mechanic_image" 
                           class="form-control @error('mechanic_image') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           accept="image/jpeg,image/jpg,image/png"
                           onchange="previewImage(event)">
                    @error('mechanic_image')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                    
                    <!-- New Image Preview Thumbnail -->
                    <div id="imagePreviewThumb" class="mt-3" style="display: none;">
                        <p class="mb-2" style="font-weight: 600; color: #1a2332; font-size: 0.9rem;">Foto baru:</p>
                        <div style="display: inline-block; position: relative;">
                            <img id="previewThumb" src="" alt="Preview" 
                                 style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer;"
                                 onclick="openImageModal()">
                            <div style="position: absolute; bottom: 5px; right: 5px; background: rgba(59, 130, 246, 0.9); color: white; padding: 6px; border-radius: 50%; font-size: 0.8rem;">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('management-mechanic') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
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

<!-- Image Preview Modal for Current Image -->
@if(!empty($mechanic->mechanic_image))
<div id="currentImageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;">
    <span onclick="closeCurrentImageModal()" 
          style="position: fixed; top: 20px; right: 40px; color: white; font-size: 50px; font-weight: bold; cursor: pointer; transition: all 0.3s; z-index: 10001; text-shadow: 0 2px 10px rgba(0,0,0,0.5); background: rgba(0,0,0,0.5); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"
          onmouseover="this.style.color='#ef4444'; this.style.transform='scale(1.1)'; this.style.background='rgba(239,68,68,0.2)'"
          onmouseout="this.style.color='white'; this.style.transform='scale(1)'; this.style.background='rgba(0,0,0,0.5)'">&times;</span>
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 100px 40px 120px 40px; box-sizing: border-box;">
        <img src="{{ asset('img/mechanics/' . $mechanic->mechanic_image) }}" 
             alt="Foto {{ $mechanic->mechanic_name }}" 
             style="max-width: calc(100% - 80px); width: auto; height: auto; display: block; margin: 0 auto; border-radius: 15px; box-shadow: 0 10px 50px rgba(0,0,0,0.7);"
             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($mechanic->mechanic_name) }}&size=500&background=3b82f6&color=fff';">
    </div>
    <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); color: white; text-align: center; background: rgba(0,0,0,0.8); padding: 12px 25px; border-radius: 10px; backdrop-filter: blur(10px); z-index: 10001; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
        <p style="margin: 0; font-size: 0.9rem;">
            <i class="fas fa-user me-2"></i>{{ $mechanic->mechanic_name }}
        </p>
    </div>
</div>
@endif

<!-- Image Preview Modal for New Image -->
<div id="imageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;">
    <span onclick="closeImageModal()" 
          style="position: fixed; top: 20px; right: 40px; color: white; font-size: 50px; font-weight: bold; cursor: pointer; transition: all 0.3s; z-index: 10001; text-shadow: 0 2px 10px rgba(0,0,0,0.5); background: rgba(0,0,0,0.5); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"
          onmouseover="this.style.color='#ef4444'; this.style.transform='scale(1.1)'; this.style.background='rgba(239,68,68,0.2)'"
          onmouseout="this.style.color='white'; this.style.transform='scale(1)'; this.style.background='rgba(0,0,0,0.5)'">&times;</span>
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 100px 40px 120px 40px; box-sizing: border-box;">
        <img id="modalImage" src="" alt="Preview" 
             style="max-width: calc(100% - 80px); width: auto; height: auto; display: block; margin: 0 auto; border-radius: 15px; box-shadow: 0 10px 50px rgba(0,0,0,0.7);">
    </div>
</div>

<script>
// Preview new image
function previewImage(event) {
    const file = event.target.files[0];
    const previewThumb = document.getElementById('previewThumb');
    const modalImage = document.getElementById('modalImage');
    const previewContainer = document.getElementById('imagePreviewThumb');
    
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid! Gunakan JPG, JPEG, atau PNG');
            event.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewThumb.src = e.target.result;
            modalImage.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Modal functions for current image
function openCurrentImageModal() {
    document.getElementById('currentImageModal').style.display = 'block';
}

function closeCurrentImageModal() {
    const modal = document.getElementById('currentImageModal');
    modal.style.display = 'none';
    modal.scrollTop = 0;
}

// Modal functions for new image
function openImageModal() {
    document.getElementById('imageModal').style.display = 'block';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    modal.scrollTop = 0;
}

// Close with ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCurrentImageModal();
        closeImageModal();
    }
});

// Form validation
document.getElementById('mechanicForm').addEventListener('submit', function(e) {
    const mechanicName = document.getElementById('mechanic_name').value.trim();
    const mechanicPhone = document.getElementById('mechanic_phone').value;
    
    if (mechanicName.length < 3) {
        e.preventDefault();
        alert('Nama mekanik minimal 3 karakter!');
        return false;
    }
    
    if (mechanicPhone.length < 10 || mechanicPhone.length > 13) {
        e.preventDefault();
        alert('Nomor telepon harus 10-13 digit!');
        return false;
    }
    
    return true;
});
</script>
@endsection
