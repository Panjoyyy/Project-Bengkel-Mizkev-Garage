@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-plus-circle" style="color: #10b981; margin-right: 10px;"></i>Tambah Layanan
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Masukkan data layanan baru</p>
    </div>

    <!-- Alert Messages -->
    @if (!empty($message))
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
            <form method="POST" action="{{ route('create-service') }}" enctype="multipart/form-data" id="layananForm">
                @csrf
                
                <!-- Nama Layanan -->
                <div class="mb-4">
                    <label for="nama_layanan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-tag me-2" style="color: #3b82f6;"></i>Nama Layanan <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="nama_layanan" 
                           id="nama_layanan" 
                           class="form-control @error('nama_layanan') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('nama_layanan') }}"
                           placeholder="Contoh: Ganti Oli Mesin"
                           required
                           minlength="3"
                           maxlength="100">
                    @error('nama_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                </div>

                <!-- Lokasi Layanan -->
                <div class="mb-4">
                    <label for="lokasi_layanan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>Lokasi Layanan <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('lokasi_layanan') is-invalid @enderror" 
                            name="lokasi_layanan" 
                            id="lokasi_layanan" 
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            required>
                        <option value="" selected disabled>Pilih lokasi layanan</option>
                        <option value="Garage Paingan" {{ old('lokasi_layanan') == 'Garage Paingan' ? 'selected' : '' }}>Garage Paingan</option>
                        <option value="Garage Mrican" {{ old('lokasi_layanan') == 'Garage Mrican' ? 'selected' : '' }}>Garage Mrican</option>
                    </select>
                    @error('lokasi_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-4">
                    <label for="harga_layanan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-money-bill-wave me-2" style="color: #10b981;"></i>Harga <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; border-right: none; background: #f9fafb;">Rp</span>
                        <input type="number" 
                               name="harga_layanan" 
                               id="harga_layanan" 
                               class="form-control @error('harga_layanan') is-invalid @enderror" 
                               style="border-radius: 0 10px 10px 0; padding: 12px 15px; border: 2px solid #e5e7eb; border-left: none;"
                               value="{{ old('harga_layanan') }}"
                               placeholder="50000"
                               required
                               min="1000"
                               max="10000000"
                               step="1000">
                        @error('harga_layanan')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Minimal Rp 1.000, maksimal Rp 10.000.000</small>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi_layanan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-align-left me-2" style="color: #f59e0b;"></i>Deskripsi
                    </label>
                    <textarea name="deskripsi_layanan" 
                              id="deskripsi_layanan" 
                              rows="4" 
                              class="form-control @error('deskripsi_layanan') is-invalid @enderror"
                              style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                              placeholder="Masukkan deskripsi layanan..."
                              maxlength="500">{{ old('deskripsi_layanan') }}</textarea>
                    @error('deskripsi_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Maksimal 500 karakter (opsional)</small>
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label for="foto_layanan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-image me-2" style="color: #3b82f6;"></i>Gambar <span class="text-danger">*</span>
                    </label>
                    <input type="file" 
                           name="foto_layanan" 
                           id="foto_layanan" 
                           class="form-control @error('foto_layanan') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           accept="image/jpeg,image/jpg,image/png"
                           required
                           onchange="previewImage(event)">
                    @error('foto_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    
                    <!-- Image Preview Thumbnail -->
                    <div id="imagePreviewThumb" class="mt-3" style="display: none;">
                        <p class="mb-2" style="font-weight: 600; color: #1a2332; font-size: 0.9rem;">File terpilih:</p>
                        <div style="display: inline-block; position: relative;">
                            <img id="previewThumb" src="" alt="Preview" 
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer;"
                                 onclick="openImageModal()">
                            <div style="position: absolute; bottom: 5px; right: 5px; background: rgba(59, 130, 246, 0.9); color: white; padding: 4px 8px; border-radius: 5px; font-size: 0.7rem;">
                                <i class="fas fa-search-plus"></i> Klik untuk preview
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Preview Modal -->
                <div id="imageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;">
                    <!-- Close Button -->
                    <span onclick="closeImageModal()" 
                          style="position: fixed; top: 20px; right: 40px; color: white; font-size: 50px; font-weight: bold; cursor: pointer; transition: all 0.3s; z-index: 10001; text-shadow: 0 2px 10px rgba(0,0,0,0.5); background: rgba(0,0,0,0.5); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"
                          onmouseover="this.style.color='#ef4444'; this.style.transform='scale(1.1)'; this.style.background='rgba(239,68,68,0.2)'"
                          onmouseout="this.style.color='white'; this.style.transform='scale(1)'; this.style.background='rgba(0,0,0,0.5)'">&times;</span>
                    
                    <!-- Image Container -->
                    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 100px 40px 120px 40px; box-sizing: border-box;">
                        <img id="modalImage" src="" alt="Preview" 
                             style="max-width: calc(100% - 80px); width: auto; height: auto; display: block; margin: 0 auto; border-radius: 15px; box-shadow: 0 10px 50px rgba(0,0,0,0.7);">
                    </div>
                    
                    <!-- Instructions -->
                    <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); color: white; text-align: center; background: rgba(0,0,0,0.8); padding: 12px 25px; border-radius: 10px; backdrop-filter: blur(10px); z-index: 10001; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
                        <p style="margin: 0; font-size: 0.9rem;">
                            <i class="fas fa-info-circle me-2"></i>
                            Tekan <kbd style="background: #3b82f6; padding: 5px 12px; border-radius: 5px; font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">ESC</kbd> 
                            atau klik <strong style="color: #ef4444;">X</strong> untuk menutup
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('management-layanan') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn-success-custom" style="padding: 12px 30px;">
                        <i class="fas fa-save me-2"></i>Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image Preview with Thumbnail and Modal
function previewImage(event) {
    const file = event.target.files[0];
    const previewThumb = document.getElementById('previewThumb');
    const modalImage = document.getElementById('modalImage');
    const previewContainer = document.getElementById('imagePreviewThumb');
    
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
            previewThumb.src = e.target.result;
            modalImage.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Open Image Modal
function openImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'block';
    // Don't prevent body scroll, let modal handle it
}

// Close Image Modal
function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    modal.scrollTop = 0; // Reset scroll position
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Close modal when clicking outside image
document.getElementById('imageModal')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeImageModal();
    }
});

// Form Validation
document.getElementById('layananForm').addEventListener('submit', function(e) {
    const namaLayanan = document.getElementById('nama_layanan').value.trim();
    const lokasiLayanan = document.getElementById('lokasi_layanan').value;
    const hargaLayanan = document.getElementById('harga_layanan').value;
    const fotoLayanan = document.getElementById('foto_layanan').files[0];
    
    // Validate nama layanan
    if (namaLayanan.length < 3) {
        e.preventDefault();
        alert('Nama layanan minimal 3 karakter!');
        return false;
    }
    
    // Validate lokasi
    if (!lokasiLayanan) {
        e.preventDefault();
        alert('Pilih lokasi layanan!');
        return false;
    }
    
    // Validate harga
    if (hargaLayanan < 1000 || hargaLayanan > 10000000) {
        e.preventDefault();
        alert('Harga harus antara Rp 1.000 - Rp 10.000.000!');
        return false;
    }
    
    // Validate foto
    if (!fotoLayanan) {
        e.preventDefault();
        alert('Pilih gambar layanan!');
        return false;
    }
    
    return true;
});
</script>
@endsection
