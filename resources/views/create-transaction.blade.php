<!-- Updated create-transaction.blade.php with Search Servis + QRIS & Transfer Sub-options -->
@extends('layouts.admin-modern')

@section('content')
    <div style="background: white; min-height: calc(100vh - 60px); padding: 30px;">
        <div class="mb-4" data-aos="fade-down">
            <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a2332; margin-bottom: 5px;">
                <i class="fas fa-receipt" style="color: #10b981; margin-right: 10px;"></i>Tambah Transaksi
            </h2>
            <p style="color: #6c757d; margin: 0; font-size: 0.95rem;">Masukkan data transaksi baru</p>
        </div>

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

        <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);"
            data-aos="fade-up">
            <div class="card-body" style="padding: 30px;">
                <form method="POST" action="{{ route('transaksi.store') }}" id="transaksiForm">
                    @csrf

                    <!-- Search Servis -->
                    <div class="mb-3">
                        <label style="font-weight:600; color:#1a2332;">Cari Servis</label>
                        <input type="text" id="searchServis" class="form-control"
                            placeholder="Ketik ID Servis atau keluhan..."
                            style="border-radius:10px; border:2px solid #e5e7eb; padding:10px;">
                    </div>

                    <!-- Pilih Servis -->
                    <div class="mb-4">
                        <label class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-tools me-2" style="color: #3b82f6;"></i>Pilih Servis <span
                                class="text-danger">*</span>
                        </label>
                        <select name="id_servis" id="selectServis" class="form-select"
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;" required>
                            <option value="">-- Pilih Servis --</option>
                            @foreach ($servis as $s)
                                <option value="{{ $s->id_servis }}">{{ $s->id_servis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Layanan -->
                    <div class="mb-4">
                        <label class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-list-check me-2" style="color: #10b981;"></i>Pilih Layanan <span
                                class="text-danger">*</span>
                        </label>
                        <div style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 15px;">
                            @foreach ($layanan as $l)
                                <div class="form-check">
                                    <input class="form-check-input layanan-check" type="checkbox"
                                        data-harga="{{ $l->harga_layanan }}" name="id_layanan[]" value="{{ $l->id_layanan }}">
                                    <label class="form-check-label">{{ $l->nama_layanan }} (Rp
                                        {{ number_format($l->harga_layanan) }})</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sparepart -->
                    <div class="mb-4">
                        <label class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-cogs me-2" style="color: #f59e0b;"></i>Pilih Sparepart
                        </label>

                        <div style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 15px;">
                            @foreach ($spareparts as $sp)
                                <div class="row mb-2 align-items-center">
                                    <div class="col-6">
                                        <input class="form-check-input sparepart-check" type="checkbox" disabled
                                            data-id="{{ $sp->id_sparepart }}" data-harga="{{ $sp->harga_sparepart }}"
                                            name="id_sparepart[]" value="{{ $sp->id_sparepart }}">
                                        {{ $sp->nama_sparepart }} (Rp {{ number_format($sp->harga_sparepart) }})
                                    </div>
                                    <div class="col-6">
                                        <input type="number" min="1" disabled class="form-control jumlah-sparepart"
                                            data-id="{{ $sp->id_sparepart }}" name="jumlah_sparepart[{{ $sp->id_sparepart }}]"
                                            placeholder="Jumlah" style="border-radius: 10px; border: 2px solid #e5e7eb;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="mb-4">
                        <label class="form-label" style="font-weight: 600; color: #1a2332; margin-bottom: 8px;">
                            <i class="fas fa-money-bill-wave me-2" style="color: #06b6d4;"></i>Metode Pembayaran <span
                                class="text-danger">*</span>
                        </label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select"
                            style="border-radius: 10px; padding: 12px 15px; border: 2px solid #e5e7eb;" required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="Cash">Cash</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>

                    <!-- Sub Option Pembayaran -->
                    <div id="qris_options" class="mb-3" style="display:none;">
                        <label class="form-label">Pilih QRIS</label>
                        <select name="qris_jenis" class="form-select"
                            style="border-radius:10px; border:2px solid #e5e7eb; padding:10px;">
                            <option value="Gopay">Gopay</option>
                            <option value="Dana">Dana</option>
                            <option value="OVO">OVO</option>
                            <option value="ShopeePay">ShopeePay</option>
                        </select>
                    </div>

                    <div id="transfer_options" class="mb-3" style="display:none;">
                        <label class="form-label">Pilih Bank</label>
                        <select name="bank_transfer" class="form-select"
                            style="border-radius:10px; border:2px solid #e5e7eb; padding:10px;">
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="Mandiri">Mandiri</option>
                        </select>
                    </div>

                    <input type="hidden" name="status_pembayaran" id="status_pembayaran" value="Lunas">

                    <div class="mb-4 p-3" style="border-radius: 10px; background: #f3f4f6;">
                        <h5>Total Harga: <span id="totalHarga" style="font-weight:700; color:#10b981;">Rp 0</span></h5>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3"
                        style="border-top: 2px solid #f3f4f6;">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary"
                            style="border-radius: 10px; padding: 12px 30px;">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn-success-custom" style="padding: 12px 30px;">
                            <i class="fas fa-save me-2"></i>Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function hitungTotal() {
            let total = 0;

            // Hitung layanan
            document.querySelectorAll('.layanan-check:checked').forEach(chk => {
                total += parseInt(chk.dataset.harga) || 0;
            });

            // Hitung sparepart
            document.querySelectorAll('.sparepart-check:checked').forEach(chk => {
                const harga = parseInt(chk.dataset.harga) || 0;
                const id = chk.dataset.id;
                const jumlahInput = document.querySelector(`.jumlah-sparepart[data-id='${id}']`);
                const jumlah = parseInt(jumlahInput.value) || 0;
                total += harga * jumlah;
            });

            document.getElementById('totalHarga').innerText =
                'Rp ' + total.toLocaleString('id-ID');
        }

        /* ===============================
           EVENT LAYANAN
        ================================ */
        document.querySelectorAll('.layanan-check').forEach(chk => {
            chk.addEventListener('change', function () {

                const adaLayanan = document.querySelectorAll('.layanan-check:checked').length > 0;

                // Aktif / nonaktif sparepart
                document.querySelectorAll('.sparepart-check').forEach(sp => {
                    sp.disabled = !adaLayanan;

                    if (!adaLayanan) {
                        sp.checked = false;
                        const id = sp.dataset.id;
                        const jumlahInput = document.querySelector(`.jumlah-sparepart[data-id='${id}']`);
                        jumlahInput.disabled = true;
                        jumlahInput.value = '';
                    }
                });

                // LANGSUNG HITUNG TOTAL SAAT PILIH LAYANAN
                hitungTotal();
            });
        });

        /* ===============================
           EVENT SPAREPART
        ================================ */
        document.querySelectorAll('.sparepart-check').forEach(chk => {
            chk.addEventListener('change', function () {
                const id = this.dataset.id;
                const jumlahInput = document.querySelector(`.jumlah-sparepart[data-id='${id}']`);

                if (this.checked) {
                    jumlahInput.disabled = false;
                    jumlahInput.value = 1;
                    jumlahInput.focus();
                } else {
                    jumlahInput.disabled = true;
                    jumlahInput.value = '';
                }

                hitungTotal();
            });
        });

        // Update total saat jumlah diubah
        document.querySelectorAll('.jumlah-sparepart').forEach(input => {
            input.addEventListener('input', hitungTotal);
        });

        /* ===============================
           SEARCH SERVIS
        ================================ */
        const searchInput = document.getElementById('searchServis');
        const selectServis = document.getElementById('selectServis');

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            for (const option of selectServis.options) {
                const text = option.text.toLowerCase();
                option.style.display = text.includes(filter) ? 'block' : 'none';
            }
        });

        /* ===============================
           SUB OPSI PEMBAYARAN
        ================================ */
        const pembayaran = document.getElementById('metode_pembayaran');

        pembayaran.addEventListener('change', function () {
            document.getElementById('qris_options').style.display =
                this.value === 'QRIS' ? 'block' : 'none';

            document.getElementById('transfer_options').style.display =
                this.value === 'Transfer' ? 'block' : 'none';
        });
    </script>
@endsection