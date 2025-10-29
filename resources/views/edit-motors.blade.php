@extends('admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h5 class="card-title"><strong>Edit Motor</strong></h5>
        <p class="card-text">Update data motor.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('motor.update', $motor->id_motor) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>No Plat Motor</label>
                <input type="text" name="no_plat_motor" class="form-control" value="{{ old('no_plat_motor', $motor->no_plat_motor) }}" required>
            </div>
            <div class="mb-3">
                <label>Merk Motor</label>
                <input type="text" name="merk_motor" class="form-control" value="{{ old('merk_motor', $motor->merk_motor) }}" required>
            </div>
            <div class="mb-3">
                <label>Warna Motor</label>
                <input type="text" name="warna_motor" class="form-control" value="{{ old('warna_motor', $motor->warna_motor) }}" required>
            </div>
            <div class="mb-3">
                <label>Tahun Motor</label>
                <select name="tahun_motor" class="form-select" required>
                    <option value="" disabled>Pilih Tahun</option>
                    @for ($year = date('Y'); $year >= 1990; $year--)
                        <option value="{{ $year }}" {{ old('tahun_motor', $motor->tahun_motor) == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label>Pemilik (Customer)</label>
                <input type="text" id="customerSearch" class="form-control mb-2" placeholder="Cari customer...">
                <select name="id_customer" id="customerSelect" class="form-select" required>
                    <option value="">--Pilih Customer--</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id_customer }}" {{ $motor->id_customer == $customer->id_customer ? 'selected' : '' }}>
                            {{ $customer->nama_customer }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('motor.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    const searchInput = document.getElementById('customerSearch');
    const customerSelect = document.getElementById('customerSelect');
    const allOptions = Array.from(customerSelect.options);

    searchInput.addEventListener('input', function() {
        const search = this.value.toLowerCase();
        customerSelect.innerHTML = '';
        allOptions.forEach(option => {
            if (option.text.toLowerCase().includes(search) || option.value === "") {
                customerSelect.appendChild(option);
            }
        });
    });
</script>
@endsection
