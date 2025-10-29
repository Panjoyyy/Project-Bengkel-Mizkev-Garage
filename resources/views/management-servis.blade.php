@extends('admin')

@section('content')
@if (!empty($message))
    <div class="alert alert-{{ $alertType }} shadow-sm d-flex align-items-center gap-2 mt-3 fade show"
         style="border-left: 5px solid {{ $alertType === 'success' ? '#1abc9c' : '#f1c40f' }};
                background-color: {{ $alertType === 'success' ? '#ecfdf5' : '#fffbea' }};
                color: {{ $alertType === 'success' ? '#065f46' : '#92400e' }};
                border-radius: 8px; animation: fadeIn 0.4s ease;">
        <i class="bi {{ $alertType === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }}"></i>
        <span>{{ $message }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title"><strong>{{ $title }}</strong></h5>
            <p class="card-text">Manajemen Data Servis.</p>
        </div>

        {{-- FORM PENCARIAN --}}
        <form action="{{ route('management-servis') }}" method="GET" 
              class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control shadow-sm" 
                   placeholder="Cari servis..." 
                   style="width: 300px; border-radius: 10px;" 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">
                <i class="bi bi-search me-1"></i> Cari
            </button>
        </form>
        <a href="{{ route('servis.create') }}" class="btn btn-success">+ Tambah Servis</a>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addServisModal">+ Tambah Servis</button>

        {{-- =================================================================================== --}}
        {{-- MODAL TAMBAH SERVIS --}}
        {{-- =================================================================================== --}}
        <div class="modal fade" id="addServisModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('servis.store') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Tambah Servis Baru</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal_servis_add" class="form-label">Tanggal & Waktu Servis</label>
                            <input type="datetime-local" class="form-control" id="tanggal_servis_add" name="tanggal_servis" required>
                        </div>

                        <div class="mb-3">
                            <label for="keluhan_add" class="form-label">Keluhan</label>
                            <textarea class="form-control" id="keluhan_add" name="keluhan" rows="3" required></textarea>
                        </div>

                        {{-- Dropdown Customer --}}
                        <div class="mb-3">
                            <label for="customer_add" class="form-label">Customer</label>
                            <select class="form-select" id="customer_add" name="id_customer" required>
                                <option selected disabled value="">-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id_customer }}">{{ $customer->nama_customer }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dropdown Motor (akan diisi oleh JavaScript) --}}
                        <div class="mb-3">
                            <label for="motor_add" class="form-label">Motor</label>
                            <select class="form-select" id="motor_add" name="id_motor" required disabled>
                                <option selected disabled value="">-- Pilih Customer Terlebih Dahulu --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mechanic_add" class="form-label">Mekanik</label>
                            <select class="form-select" id="mechanic_add" name="id_mechanic" required>
                                <option selected disabled value="">-- Pilih Mekanik --</option>
                                @foreach ($mechanics as $mechanic)
                                    {{-- PERBAIKAN: Mengganti mechanic_name menjadi nama_mekanik --}}
                                    <option value="{{ $mechanic->id_mechanic }}">{{ $mechanic->mechanic_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="staff_add" class="form-label">Staff</label>
                            <select class="form-select" id="staff_add" name="id_staff" required>
                                <option selected disabled value="">-- Pilih Staff --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id_staff }}">{{ $staff->nama_staff }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session()->has('success'))
    <div class="mt-4 alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row my-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
<<<<<<< HEAD
                                <th>NO</th>
                                <th>ID Servis</th>
                                <th>Tanggal & Waktu Servis</th>
=======
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
>>>>>>> 2faee20c2e6c781f74b44dfab4014f781fd33239
                                <th>Motor</th>
                                <th>Mekanik</th>
                                <th>Staff</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servis as $item)
                                <tr style="vertical-align: middle">
                                    <td>{{ $loop->iteration }}</td>
<<<<<<< HEAD
                                    <td>{{ $item->id_servis }}</td>
                                    <td>{{ $item->tanggal_servis }}</td>
                                    <td>{{ $item->motor->merk_motor ?? '-' }} - {{ $item->motor->no_plat_motor ?? '-' }}</td>
                                    <td>{{ $item->mechanic->mechanic_name ?? '-' }}</td>
                                    <td>{{ $item->staff->nama_staff ?? '-' }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('servis.edit', $item->id_servis) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- Tombol Hapus --}}
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="{{ '#delete' . $item->id_servis }}"><i
                                                class="bi bi-trash"></i></button>
                                        <div class="modal fade" id="{{ 'delete' . $item->id_servis }}" tabindex="-1">
                                            <form action="{{ route('servis.destroy', $item->id_servis) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            Apakah anda yakin menghapus servis tanggal
                                                            <strong>{{ $item->tanggal_servis }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
=======
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_servis)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->customer?->nama_customer ?? 'N/A' }}</td>
                                    <td>{{ $item->motor?->no_plat_motor ?? 'N/A' }}</td>
                                    <td>{{ $item->mechanic?->mechanic_name ?? 'N/A' }}</td>
                                    <td>{{ $item->staff?->nama_staff ?? 'N/A' }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editServisModal{{ $item->id_servis }}"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteServisModal{{ $item->id_servis }}"><i class="bi bi-trash"></i></button>

                                        {{-- =================================================================================== --}}
                                        {{-- MODAL EDIT SERVIS (DENGAN LOGIKA DINAMIS) --}}
                                        {{-- =================================================================================== --}}
                                        <div class="modal fade" id="editServisModal{{ $item->id_servis }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('servis.update', $item->id_servis) }}" class="modal-content">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Edit Servis</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                         <div class="mb-3">
                                                            <label for="tanggal_servis_edit_{{ $item->id_servis }}" class="form-label">Tanggal & Waktu Servis</label>
                                                            <input type="datetime-local" class="form-control" id="tanggal_servis_edit_{{ $item->id_servis }}" name="tanggal_servis" value="{{ $item->tanggal_servis }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="keluhan_edit_{{ $item->id_servis }}" class="form-label">Keluhan</label>
                                                            <textarea class="form-control" id="keluhan_edit_{{ $item->id_servis }}" name="keluhan" rows="3" required>{{ $item->keluhan }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="customer_edit_{{ $item->id_servis }}" class="form-label">Customer</label>
                                                            <select class="form-select customer-edit" id="customer_edit_{{ $item->id_servis }}" name="id_customer" data-motor-dropdown-target="#motor_edit_{{ $item->id_servis }}" required>
                                                                <option disabled value="">-- Pilih Customer --</option>
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->id_customer }}" {{ $item->id_customer == $customer->id_customer ? 'selected' : '' }}>
                                                                        {{ $customer->nama_customer }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="motor_edit_{{ $item->id_servis }}" class="form-label">Motor</label>
                                                            <select class="form-select motor-edit" id="motor_edit_{{ $item->id_servis }}" name="id_motor" data-selected-motor="{{ $item->id_motor }}" required>
                                                                {{-- Opsi motor akan diisi oleh JavaScript --}}
                                                                <option selected disabled value="">-- Pilih Customer Terlebih Dahulu --</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="mechanic_edit_{{ $item->id_servis }}" class="form-label">Mekanik</label>
                                                            <select class="form-select" id="mechanic_edit_{{ $item->id_servis }}" name="id_mechanic" required>
                                                                @foreach ($mechanics as $mechanic)
                                                                    <option value="{{ $mechanic->id_mechanic }}" {{ $item->id_mechanic == $mechanic->id_mechanic ? 'selected' : '' }}>
                                                                        {{ $mechanic->mechanic_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="staff_edit_{{ $item->id_servis }}" class="form-label">Staff</label>
                                                            <select class="form-select" id="staff_edit_{{ $item->id_servis }}" name="id_staff" required>
                                                                @foreach ($staffs as $staff)
                                                                    <option value="{{ $staff->id_staff }}" {{ $item->id_staff == $staff->id_staff ? 'selected' : '' }}>
                                                                        {{ $staff->nama_staff }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
>>>>>>> 2faee20c2e6c781f74b44dfab4014f781fd33239
                                        </div>

                                        {{-- Modal Hapus --}}
                                        <div class="modal fade" id="deleteServisModal{{ $item->id_servis }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus data servis untuk motor <strong>{{ $item->motor?->no_plat_motor ?? '' }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('servis.destroy', $item->id_servis) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    
    // --- LOGIKA UNTUK MODAL TAMBAH SERVIS ---
    const customerAddDropdown = document.getElementById('customer_add');
    const motorAddDropdown = document.getElementById('motor_add');

    customerAddDropdown.addEventListener('change', function() {
        const customerId = this.value;
        fetchMotors(customerId, motorAddDropdown);
    });

    // --- LOGIKA UNTUK SEMUA MODAL EDIT SERVIS ---
    // Memicu pemuatan motor saat modal edit dibuka
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const customerEditDropdown = modal.querySelector('.customer-edit');
            if (customerEditDropdown) {
                // Trigger event 'change' untuk memuat motor sesuai customer yang sudah terpilih
                customerEditDropdown.dispatchEvent(new Event('change'));
            }
        });
    });
    
    // Menangani perubahan customer di form edit
    document.querySelectorAll('.customer-edit').forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const customerId = this.value;
            const targetMotorDropdownSelector = this.dataset.motorDropdownTarget;
            const motorDropdown = document.querySelector(targetMotorDropdownSelector);
            if (motorDropdown) {
                // Saat customer diubah, kita tidak tahu motor mana yang harus dipilih
                // jadi kita reset pilihan motornya
                const selectedMotorId = this.dataset.initialMotorId;
                fetchMotors(customerId, motorDropdown, selectedMotorId);
                // Hapus atribut ini agar tidak mengganggu pilihan selanjutnya
                this.dataset.initialMotorId = '';
            }
        });
    });

    /**
     * Fungsi utama untuk mengambil dan mengisi dropdown motor.
     * @param {string} customerId - ID customer yang dipilih.
     * @param {HTMLElement} motorDropdown - Elemen <select> untuk motor.
     * @param {string|null} selectedMotorId - (Opsional) ID motor yang harus dipilih secara default.
     */
    function fetchMotors(customerId, motorDropdown, selectedMotorId = null) {
        motorDropdown.innerHTML = '<option value="">Memuat...</option>';
        motorDropdown.disabled = true;

        if (!customerId) {
            motorDropdown.innerHTML = '<option selected disabled value="">-- Pilih Customer Terlebih Dahulu --</option>';
            return;
        }

        fetch(`/get-motors-by-customer/${customerId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                motorDropdown.innerHTML = '<option selected disabled value="">-- Pilih Motor --</option>';
                
                data.forEach(motor => {
                    const option = document.createElement('option');
                    option.value = motor.id_motor;
                    option.textContent = `${motor.no_plat_motor} - ${motor.merk_motor} ${motor.seri_motor}`;
                    
                    // Jika ada ID motor yang harus dipilih, tandai sebagai 'selected'
                    const currentSelectedMotor = motorDropdown.dataset.selectedMotor;
                    if (currentSelectedMotor && motor.id_motor == currentSelectedMotor) {
                        option.selected = true;
                    }

                    motorDropdown.appendChild(option);
                });

                motorDropdown.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching motors:', error);
                motorDropdown.innerHTML = '<option value="">Gagal memuat data motor</option>';
            });
    }
});
</script>
@endpush