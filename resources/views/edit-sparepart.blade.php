@extends('layouts.admin-modern')

@section('content')
<div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
    <!-- Header Section -->
    <div class="mb-4" data-aos="fade-down">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
            <i class="fas fa-cog" style="color: #f59e0b; margin-right: 10px;"></i>Edit Sparepart
        </h2>
        <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Perbarui data sparepart</p>
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
            <form action="{{ route('spareparts.update', $sparepart->id_sparepart) }}" method="POST" id="sparepartForm">
                @csrf
                @method('PUT')
                
                <!-- Nama Sparepart -->
                <div class="mb-4">
                    <label for="nama_sparepart" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-cog me-2" style="color: #3b82f6;"></i>Nama Sparepart <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="nama_sparepart" 
                           id="nama_sparepart" 
                           class="form-control @error('nama_sparepart') is-invalid @enderror" 
                           style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;"
                           value="{{ old('nama_sparepart', $sparepart->nama_sparepart) }}"
                           placeholder="Contoh: Oli Mesin Castrol"
                           required
                           minlength="3"
                           maxlength="100">
                    @error('nama_sparepart')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                </div>

                <!-- Stok Sparepart -->
                <div class="mb-4">
                    <label for="stok_sparepart" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-boxes me-2" style="color: #10b981;"></i>Stok <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="number" 
                               name="stok_sparepart" 
                               id="stok_sparepart" 
                               class="form-control @error('stok_sparepart') is-invalid @enderror" 
                               style="border-radius: 10px 0 0 10px; padding: 12px 15px; border: 2px solid #e5e7eb; border-right: none;"
                               value="{{ old('stok_sparepart', $sparepart->stok_sparepart) }}"
                               placeholder="0"
                               required
                               min="0"
                               max="10000">
                        <span class="input-group-text" style="border-radius: 0 10px 10px 0; border: 2px solid #e5e7eb; border-left: none; background: #f9fafb;">pcs</span>
                        @error('stok_sparepart')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Minimal 0, maksimal 10.000 pcs</small>
                </div>

                <!-- Harga Sparepart -->
                <div class="mb-4">
                    <label for="harga_sparepart" class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                        <i class="fas fa-money-bill-wave me-2" style="color: #f59e0b;"></i>Harga <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; border: 2px solid #e5e7eb; border-right: none; background: #f9fafb;">Rp</span>
                        <input type="number" 
                               name="harga_sparepart" 
                               id="harga_sparepart" 
                               class="form-control @error('harga_sparepart') is-invalid @enderror" 
                               style="border-radius: 0 10px 10px 0; padding: 12px 15px; border: 2px solid #e5e7eb; border-left: none;"
                               value="{{ old('harga_sparepart', $sparepart->harga_sparepart) }}"
                               placeholder="50000"
                               required
                               min="100"
                               max="10000000"
                               step="100">
                        @error('harga_sparepart')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Minimal Rp 100, maksimal Rp 10.000.000 (akan dibulatkan ke ratusan terdekat)</small>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 2px solid #f3f4f6;">
                    <a href="{{ route('spareparts.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 12px 30px;">
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
// Auto-round price to nearest 100
document.getElementById('harga_sparepart').addEventListener('blur', function() {
    let value = parseInt(this.value);
    if (!isNaN(value)) {
        let rounded = Math.round(value / 100) * 100;
        this.value = rounded;
    }
});

// Form validation
document.getElementById('sparepartForm').addEventListener('submit', function(e) {
    const namaSparepart = document.getElementById('nama_sparepart').value.trim();
    const stokSparepart = parseInt(document.getElementById('stok_sparepart').value);
    const hargaSparepart = parseInt(document.getElementById('harga_sparepart').value);
    
    // Validate nama
    if (namaSparepart.length < 3) {
        e.preventDefault();
        alert('Nama sparepart minimal 3 karakter!');
        return false;
    }
    
    // Validate stok
    if (isNaN(stokSparepart) || stokSparepart < 0 || stokSparepart > 10000) {
        e.preventDefault();
        alert('Stok harus antara 0 - 10.000 pcs!');
        return false;
    }
    
    // Validate harga
    if (isNaN(hargaSparepart) || hargaSparepart < 100 || hargaSparepart > 10000000) {
        e.preventDefault();
        alert('Harga harus antara Rp 100 - Rp 10.000.000!');
        return false;
    }
    
    return true;
});
</script>
@endsection
