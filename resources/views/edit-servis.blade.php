@extends('admin')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Servis</h5>

        <form method="POST" action="{{ route('servis.update', $servis->id_servis) }}">
            @csrf
            @method('PUT')

            {{-- Tanggal & Waktu Servis --}}
            <div class="mb-3">
                <label for="tanggal_servis">Tanggal & Waktu Servis</label>
                <input type="datetime-local" class="form-control" name="tanggal_servis"
                       value="{{ date('Y-m-d\TH:i', strtotime($servis->tanggal_servis)) }}" required>
            </div>

            {{-- Customer --}}
            <div class="mb-3">
                <label for="id_customer">Customer</label>
                <select class="form-select" name="id_customer" id="id_customer" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id_customer }}"
                            {{ $servis->id_customer == $customer->id_customer ? 'selected' : '' }}>
                            {{ $customer->nama_customer }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Motor --}}
            <div class="mb-3">
                <label for="id_motor">Motor</label>
                <select class="form-select" name="id_motor" id="id_motor" required>
                    <option value="">-- Pilih Motor --</option>
                    @foreach ($motors_for_customer as $motor)
                        <option value="{{ $motor->id_motor }}"
                            {{ $servis->id_motor == $motor->id_motor ? 'selected' : '' }}>
                            {{ $motor->merk_motor }} - {{ $motor->no_plat_motor }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Mekanik --}}
            <div class="mb-3">
                <label for="id_mechanic">Mekanik</label>
                <select class="form-select" name="id_mechanic" required>
                    <option value="">-- Pilih Mekanik --</option>
                    @foreach ($mechanics as $mekanik)
                        <option value="{{ $mekanik->id_mechanic }}"
                            {{ $servis->id_mechanic == $mekanik->id_mechanic ? 'selected' : '' }}>
                            {{ $mekanik->mechanic_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Staff --}}
            <div class="mb-3">
                <label for="id_staff">Staff</label>
                <select class="form-select" name="id_staff" required>
                    <option value="">-- Pilih Staff --</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id_staff }}"
                            {{ $servis->id_staff == $staff->id_staff ? 'selected' : '' }}>
                            {{ $staff->nama_staff }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Keluhan --}}
            <div class="mb-3">
                <label for="keluhan">Keluhan</label>
                <textarea class="form-control" name="keluhan" rows="3" required>{{ $servis->keluhan }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
