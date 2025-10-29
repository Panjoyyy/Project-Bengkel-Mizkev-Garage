@extends('admin')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambah Servis</h5>

        <form method="POST" action="{{ route('servis.store') }}">
            @csrf
            <div class="mb-3">
                <label for="tanggal_servis">Tanggal & Waktu Servis</label>
                <input type="datetime-local" class="form-control" name="tanggal_servis" required>
            </div>

            <div class="mb-3">
                <label for="id_customer">Customer</label>
                <select class="form-select" name="id_customer" id="id_customer" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id_customer }}">{{ $customer->nama_customer }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_motor">Motor</label>
                <select class="form-select" name="id_motor" id="id_motor" required>
                    <option value="">-- Pilih Motor --</option>
                    {{-- Motor akan diisi via JS saat customer dipilih --}}
                </select>
            </div>

            <div class="mb-3">
                <label for="id_mechanic">Mekanik</label>
                <select class="form-select" name="id_mechanic" required>
                    <option value="">-- Pilih Mekanik --</option>
                    @foreach ($mechanics as $mekanik)
                        <option value="{{ $mekanik->id_mechanic }}">{{ $mekanik->mechanic_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_staff">Staff</label>
                <select class="form-select" name="id_staff" required>
                    <option value="">-- Pilih Staff --</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id_staff }}">{{ $staff->nama_staff }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="keluhan">Keluhan</label>
                <textarea class="form-control" name="keluhan" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('management-servis') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.getElementById('id_customer').addEventListener('change', function() {
    let customerId = this.value;
    let motorSelect = document.getElementById('id_motor');

    motorSelect.innerHTML = '<option value="">-- Memuat Motor --</option>';

    if(customerId) {
        let url = "{{ url('/servis/motors') }}/" + customerId;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                motorSelect.innerHTML = '<option value="">-- Pilih Motor --</option>';
                data.forEach(motor => {
                    motorSelect.innerHTML += `<option value="${motor.id_motor}">${motor.merk_motor} - ${motor.no_plat_motor}</option>`;
                });
            });
    } else {
        motorSelect.innerHTML = '<option value="">-- Pilih Motor --</option>';
    }
});
</script>

@endsection
