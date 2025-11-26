@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-edit" style="color: #3b82f6; margin-right: 10px;"></i>Edit Layanan
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Perbarui data layanan</p>
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
            <form method="POST" action="{{ route('update-service', $service->id_layanan) }}" enctype="multipart/form-data" id="layananForm">
                @csrf
                @method('PUT')

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
                        value="{{ old('nama_layanan', $service->nama_layanan) }}"
                        required minlength="3" maxlength="100">

                    @error('nama_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="mb-4">
                    <label for="lokasi_layanan" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>Lokasi Layanan <span class="text-danger">*</span>
                    </label>

                    <select name="lokasi_layanan" id="lokasi_layanan"
                        class="form-select @error('lokasi_layanan') is-invalid @enderror"
                        style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;" required>
                        
                        <option disabled>Pilih lokasi</option>
                        <option value="Garage Paingan" {{ $service->lokasi_layanan == 'Garage Paingan' ? 'selected' : '' }}>Garage Paingan</option>
                        <option value="Garage Mrican" {{ $service->lokasi_layanan == 'Garage Mrican' ? 'selected' : '' }}>Garage Mrican</option>
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
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb;">Rp</span>

                        <input type="number" name="harga_layanan" id="harga_layanan"
                            class="form-control @error('harga_layanan') is-invalid @enderror"
                            style="border-radius: 0 10px 10px 0; padding: 12px 15px; border: 2px solid #e5e7eb;"
                            value="{{ old('harga_layanan', $service->harga_layanan) }}"
                            required min="1000" max="10000000" step="1000">

                    </div>
                    @error('harga_layanan')
                        <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="deskripsi_layanan" class="form-label">
                        <i class="fas fa-align-left me-2" style="color: #f59e0b;"></i>Deskripsi
                    </label>
                    <textarea name="deskripsi_layanan" id="deskripsi_layanan" rows="4"
                        class="form-control @error('deskripsi_layanan') is-invalid @enderror"
                        style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                        maxlength="500">{{ old('deskripsi_layanan', $service->deskripsi_layanan) }}</textarea>

                    @error('deskripsi_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-image me-2" style="color: #3b82f6;"></i>Gambar Layanan
                    </label>

                    <input type="file" name="foto_layanan" id="foto_layanan"
                        class="form-control @error('foto_layanan') is-invalid @enderror"
                        style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                        accept="image/jpeg,image/jpg,image/png"
                        onchange="previewImage(event)">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>

                    @error('foto_layanan')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror

                    <!-- Current Preview -->
                    <div id="imagePreviewThumb" class="mt-3" style="display: block;">
                        <p class="mb-2" style="font-weight: 600;">Gambar Saat Ini:</p>
                        <div style="display:inline-block; position:relative;">
                            <img id="previewThumb" 
                                src="{{ asset('img/layanan/' . $service->foto_layanan) }}"
                                style="width:100px; height:100px; object-fit:cover; border-radius:10px; cursor:pointer;"
                                onclick="openImageModal()">
                        </div>
                    </div>
                </div>

                <!-- Modal Preview -->
                <div id="imageModal" style="display:none; position:fixed; z-index:9999; inset:0; background:rgba(0,0,0,0.95);">
                    <span onclick="closeImageModal()" 
                          style="position:fixed; top:20px; right:40px; font-size:50px; color:white; cursor:pointer;">&times;</span>

                    <div style="display:flex; justify-content:center; align-items:center; height:100%;">
                        <img id="modalImage"
                             src="{{ asset('img/layanan/' . $service->foto_layanan) }}"
                             style="max-width:90%; height:auto; border-radius:15px;">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between pt-3" style="border-top:2px solid #f3f4f6;">
                    <a href="{{ route('management-layanan') }}" class="btn btn-secondary" style="padding:12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>

                    <button type="submit" class="btn-success-custom" style="padding:12px 30px;">
                        <i class="fas fa-save me-2"></i>Update Layanan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const thumb = document.getElementById('previewThumb');
    const modal = document.getElementById('modalImage');

    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert("Ukuran file maksimal 2MB");
            event.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            thumb.src = e.target.result;
            modal.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

function openImageModal() {
    document.getElementById('imageModal').style.display = 'block';
}
function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}
</script>
@endsection
