@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Tambah Transaksi</strong></h5>
        <p class="card-text">Masukkan data transaksi baru.</p>

        {{-- Alert error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
            @csrf

            {{-- Pilih Servis --}}
            <div class="mb-3">
                <label for="id_servis">Pilih Servis</label>
                <input type="text" id="servisSearch" class="form-control mb-2" placeholder="Cari servis...">
                <select name="id_servis" id="servisSelect" class="form-select" required>
                    <option value="">-- Pilih Servis --</option>
                    @foreach ($servis as $item)
                        <option value="{{ $item->id_servis }}">
                            {{ $item->id_servis }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Layanan --}}
            <div class="mb-3">
                <label class="form-label">Pilih Layanan</label>
                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                    @foreach($layanan as $l)
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                name="id_layanan[]" 
                                value="{{ $l->id_layanan }}" 
                                id="layanan_{{ $l->id_layanan }}" 
                                class="form-check-input layanan-checkbox"
                                data-harga="{{ $l->harga_layanan }}">
                            <label for="layanan_{{ $l->id_layanan }}" class="form-check-label">
                                {{ $l->nama_layanan }} - Rp{{ number_format($l->harga_layanan, 0, ',', '.') }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pilih Sparepart --}}
            <div class="mb-3">
                <label class="form-label">Pilih Sparepart (Boleh lebih dari satu)</label>
                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                    @foreach($spareparts as $sp)
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-check me-2">
                                <input 
                                    type="checkbox" 
                                    name="id_sparepart[]" 
                                    value="{{ $sp->id_sparepart }}" 
                                    id="sparepart_{{ $sp->id_sparepart }}" 
                                    class="form-check-input sparepart-checkbox"
                                    data-harga="{{ $sp->harga_sparepart }}">
                                <label for="sparepart_{{ $sp->id_sparepart }}" class="form-check-label">
                                    {{ $sp->nama_sparepart }} (Stok: {{ $sp->stok_sparepart }}) - Rp{{ number_format($sp->harga_sparepart, 0, ',', '.') }}
                                </label>
                            </div>
                            <input 
                                type="number" 
                                name="jumlah_sparepart[{{ $sp->id_sparepart }}]" 
                                class="form-control ms-2 sparepart-qty" 
                                style="width: 100px;" 
                                min="0" 
                                value="0" 
                                placeholder="Qty" 
                                disabled>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="mb-3">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            {{-- Input Tambahan untuk Metode Pembayaran --}}
            <div id="pembayaran-detail">
                {{-- Untuk Tunai --}}
                <div class="mb-3" id="tunai-section" style="display: none;">
                    <label for="uang_dibayar">Jumlah Uang Tunai</label>
                    <input type="number" name="uang_dibayar" id="uang_dibayar" class="form-control" min="0" placeholder="Masukkan jumlah uang tunai">
                    <small id="uang-warning" class="text-danger" style="display:none;">Uang tunai kurang dari subtotal!</small>

                    <div class="mt-2">
                        <label for="kembalian">Kembalian</label>
                        <input type="text" id="kembalian" class="form-control" readonly>
                    </div>
                </div>

                {{-- Untuk Transfer --}}
                <div class="mb-3" id="transfer-section" style="display: none;">
                    <label for="nama_bank">Pilih Bank</label>
                    <select name="nama_bank" id="nama_bank" class="form-select">
                        <option value="">-- Pilih Bank --</option>
                        <option value="BCA">BCA</option>
                        <option value="BRI">BRI</option>
                        <option value="BNI">BNI</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="CIMB">CIMB</option>
                    </select>
                    <small class="text-muted">Pastikan transfer sesuai subtotal.</small>
                </div>
            </div>

            {{-- Status Pembayaran --}}
            <div class="mb-3">
                <label for="status_pembayaran">Status Pembayaran</label>
                <select name="status_pembayaran" id="status_pembayaran" class="form-select">
                    <option value="Belum Lunas" selected>Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
                </select>
            </div>

            {{-- Total Harga --}}
            <div class="mb-3">
                <label for="subtotal">Total Harga</label>
                <input type="text" name="subtotal" id="subtotal" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
    // === Cari Servis ===
    const searchInput = document.getElementById('servisSearch');
    const servisSelect = document.getElementById('servisSelect');
    const allServisOptions = Array.from(servisSelect.options);

    searchInput.addEventListener('input', function() {
        const search = this.value.toLowerCase();
        servisSelect.innerHTML = '';
        allServisOptions.forEach(option => {
            if (option.text.toLowerCase().includes(search) || option.value === "") {
                servisSelect.appendChild(option);
            }
        });
    });

    // === Checkbox dan Hitung Total ===
    const layananCheckboxes = document.querySelectorAll('.layanan-checkbox');
    const sparepartCheckboxes = document.querySelectorAll('.sparepart-checkbox');
    const sparepartQtyInputs = document.querySelectorAll('.sparepart-qty');
    const subtotalInput = document.getElementById('subtotal');

    function hitungTotal() {
        let total = 0;

        layananCheckboxes.forEach(cb => {
            if (cb.checked) total += parseInt(cb.dataset.harga);
        });

        sparepartCheckboxes.forEach(cb => {
            const qtyInput = cb.closest('.d-flex').querySelector('.sparepart-qty');
            const qty = parseInt(qtyInput.value) || 0;
            const harga = parseInt(cb.dataset.harga);
            if (cb.checked && qty > 0) total += harga * qty;
        });

        subtotalInput.value = total.toLocaleString('id-ID');
        hitungKembalian();
    }

    // Aktifkan qty saat sparepart dicentang
    sparepartCheckboxes.forEach(cb => {
        const qtyInput = cb.closest('.d-flex').querySelector('.sparepart-qty');
        cb.addEventListener('change', () => {
            qtyInput.disabled = !cb.checked;
            if (!cb.checked) qtyInput.value = 0;
            hitungTotal();
        });
    });

    layananCheckboxes.forEach(cb => cb.addEventListener('change', hitungTotal));
    sparepartQtyInputs.forEach(input => input.addEventListener('input', hitungTotal));

    // === Tampilkan Input Berdasarkan Metode Pembayaran ===
    const metodeSelect = document.getElementById('metode_pembayaran');
    const tunaiSection = document.getElementById('tunai-section');
    const transferSection = document.getElementById('transfer-section');
    const uangInput = document.getElementById('uang_dibayar');
    const warning = document.getElementById('uang-warning');
    const kembalianInput = document.getElementById('kembalian');
    const form = document.getElementById('formTransaksi');

    metodeSelect.addEventListener('change', () => {
        tunaiSection.style.display = metodeSelect.value === 'Tunai' ? 'block' : 'none';
        transferSection.style.display = metodeSelect.value === 'Transfer' ? 'block' : 'none';
        if (metodeSelect.value !== 'Tunai') {
            warning.style.display = 'none';
        }
    });

    // === Validasi Tunai ===
    function hitungKembalian() {
        if (metodeSelect.value === 'Tunai') {
            const subtotal = parseInt(subtotalInput.value.replace(/\D/g, '')) || 0;
            const uang = parseInt(uangInput.value) || 0;
            if (uang < subtotal) {
                warning.style.display = 'block';
                kembalianInput.value = '';
            } else {
                warning.style.display = 'none';
                const kembalian = uang - subtotal;
                kembalianInput.value = "Rp " + kembalian.toLocaleString('id-ID');
            }
        }
    }

    uangInput.addEventListener('input', hitungKembalian);

    // Cegah submit jika uang tunai kurang
    form.addEventListener('submit', (e) => {
        if (metodeSelect.value === 'Tunai') {
            const subtotal = parseInt(subtotalInput.value.replace(/\D/g, '')) || 0;
            const uang = parseInt(uangInput.value) || 0;
            if (uang < subtotal) {
                e.preventDefault();
                warning.style.display = 'block';
                uangInput.focus();
            }
        }
    });
</script>
@endsection
