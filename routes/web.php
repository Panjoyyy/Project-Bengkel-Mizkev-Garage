<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\TransaksiController;


    // Route untuk menampilkan halaman porto brian
    Route::get('/porto', function () {
    return view('porto');
});

    // Halaman Utama (Public)
    Route::get('/', [CustomerController::class, 'showHomeCustomer'])->name('porto');

    // Route untuk Tamu (Belum Login)
    Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'handleLogin'])->name('handleLogin');
});

    // Route untuk yang sudah login (Auth)
    Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route Management Data Customer
    // Halaman index customer (tabel + search)
    Route::get('/management-customer', [CustomerController::class, 'showManagementCustomer'])->name('management-customer');
    // Halaman tambah customer (form di halaman baru)
    Route::get('/create-customer', [CustomerController::class, 'createCustomer'])->name('create-customer-form');
    // Submit form tambah customer
    Route::post('/create-customer', [CustomerController::class, 'store'])->name('create-customer');
    // Tampilkan form edit customer
    Route::get('/edit-customer/{id_customer}', [CustomerController::class, 'edit'])->name('edit-customer-form');
    // Update customer
    Route::put('/update-customer/{id_customer}', [CustomerController::class, 'updateCustomer'])->name('update-customer');
    // Delete customer
    Route::delete('/delete-customer/{id_customer}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');


    // Route Management Data Motor
    // Management Data Motor
    Route::get('/management-motors', [MotorController::class, 'index'])->name('motor.index');
    // Form Tambah Motor
    Route::get('/management-motors/create', [MotorController::class, 'create'])->name('motor.create');
    Route::post('/management-motors/store', [MotorController::class, 'store'])->name('motor.store');
    // Form Edit Motor
    Route::get('/management-motors/{id}/edit', [MotorController::class, 'edit'])->name('motor.edit');
    Route::put('/management-motors/{id}/update', [MotorController::class, 'update'])->name('motor.update');
    // Hapus Motor
    Route::delete('/management-motors/{id}/destroy', [MotorController::class, 'destroy'])->name('motor.destroy');

    // Route Management Data Sparepart
    // Management Sparepart
    Route::get('/management-sparepart', [SparepartController::class, 'index'])->name('spareparts.index');
    // Tambah sparepart
    Route::get('/create-sparepart', [SparepartController::class, 'createForm'])->name('spareparts.create-form');
    Route::post('/create-sparepart', [SparepartController::class, 'store'])->name('spareparts.store');
    // Edit sparepart
    Route::get('/edit-sparepart/{id}', [SparepartController::class, 'editForm'])->name('spareparts.edit-form');
    Route::put('/update-sparepart/{id}', [SparepartController::class, 'update'])->name('spareparts.update');
    // Hapus sparepart
    Route::delete('/delete-sparepart/{id}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');


   // Route Management Data Servis
    // Halaman manajemen servis
    Route::get('/management-servis', [ServisController::class, 'showManagementServis'])->name('management-servis');
    // Halaman tambah servis
    Route::get('/servis/create', [ServisController::class, 'createServisView'])->name('servis.create');
    // CRUD Servis
    Route::get('/servis/motors/{customerId}', [ServisController::class, 'getMotorsByCustomer'])->name('servis.getMotors');
    Route::post('/servis/create', [ServisController::class, 'createServis'])->name('servis.store');
    Route::get('/servis/edit/{id_servis}', [ServisController::class, 'editServisView'])->name('servis.edit');
    Route::put('/servis/update/{id_servis}', [ServisController::class, 'updateServis'])->name('servis.update');
    Route::delete('/servis/delete/{id_servis}', [ServisController::class, 'deleteServis'])->name('servis.destroy');
    // =======================
// MANAGEMENT SERVIS
// =======================

// Halaman manajemen servis
Route::get('/management-servis', [ServisController::class, 'showManagementServis'])
    ->name('management-servis');

// Form tambah servis
Route::get('/servis/create', [ServisController::class, 'createServisView'])
    ->name('servis.create');

// Simpan servis
Route::post('/servis', [ServisController::class, 'createServis'])
    ->name('servis.store');

// Form edit servis
Route::get('/servis/{id_servis}/edit', [ServisController::class, 'editServisView'])
    ->name('servis.edit');

    // Update servis
    Route::put('/servis/{id_servis}', [ServisController::class, 'updateServis'])
        ->name('servis.update');

    // 🔥 UPDATE STATUS SERVIS (INI YANG HILANG)
    Route::put('/servis/{id_servis}/status', [ServisController::class, 'updateStatus'])
        ->name('servis.updateStatus');

    // Hapus servis
    Route::delete('/servis/{id_servis}', [ServisController::class, 'deleteServis'])
        ->name('servis.destroy');

    // AJAX: motor berdasarkan customer
    Route::get('/servis/motors/{customerId}', [ServisController::class, 'getMotorsByCustomer'])
        ->name('servis.getMotors');

    // --- ROUTE BARU UNTUK AJAX ---
    // Route ini akan dipanggil oleh JavaScript untuk mengambil data motor berdasarkan customer yang dipilih.
    Route::get('/get-motors-by-customer/{customerId}', [ServisController::class, 'getMotorsByCustomer'])->name('get.motors.by.customer');
    // ----------------------------

    // // AJAX: dapatkan motor berdasarkan customer
    // Route::get('/servis/motors/{customerId}', [ServisController::class, 'getMotorsByCustomer']);
   
    // ----------------------------
    // ---------------------
    // Order
    // ---------------------
    Route::get('/create-order', [AdminController::class, 'showCreateOrder'])->name('create-order');
    Route::post('/create-order', [AdminController::class, 'createOrder'])->name('handle-create-order');

    // ---------------------
    // Management Layanan
    // ---------------------
    Route::get('/management-layanan', [LayananController::class, 'showManagementService'])->name('management-layanan');
    // Tambah layanan
    Route::get('/create-layanan', [LayananController::class, 'showCreateForm'])->name('create-service-form');
    Route::post('/create-layanan', [LayananController::class, 'createService'])->name('create-service');
    // Edit layanan
    Route::get('/edit-layanan/{id_layanan}', [LayananController::class, 'showEditForm'])->name('edit-service-form');
    Route::put('/update-service/{id_layanan}', [LayananController::class, 'updateService'])->name('update-service');
    Route::get('/edit-layanan/{id_layanan}', [LayananController::class, 'editServiceForm'])->name('edit-service-form');
    // Hapus layanan
    Route::delete('/delete-service/{id_layanan}', [LayananController::class, 'deleteService'])->name('delete-service');
    
    // ---------------------
    // Management Mechanic
    // ---------------------
    // Management mekanik
    Route::get('/management-mechanic', [MekanikController::class, 'showManagementMechanic'])->name('management-mechanic');
    // Form tambah & simpan mekanik
    Route::get('/create-mechanic', [MekanikController::class, 'createMechanicForm'])->name('create-mechanic-form');
    Route::post('/create-mechanic', [MekanikController::class, 'createMechanic'])->name('create-mechanic');
    // Form edit & update mekanik
    Route::get('/edit-mechanic/{id}', [MekanikController::class, 'editMechanicForm'])->name('edit-mechanic-form');
    Route::put('/update-mechanic/{id}', [MekanikController::class, 'updateMechanic'])->name('update-mechanic');
    // Hapus mekanik
    Route::delete('/delete-mechanic/{id}', [MekanikController::class, 'deleteMechanic'])->name('delete-mechanic');


   // ---------------------
// TRANSAKSI
// ---------------------
Route::get('/management-transaction', [TransaksiController::class, 'index'])
    ->name('transaksi.index');

Route::get('/transaction/create', [TransaksiController::class, 'create'])
    ->name('transaksi.create');

Route::post('/transaction/store', [TransaksiController::class, 'store'])
    ->name('transaksi.store');

Route::get('/transaction/{id}', [TransaksiController::class, 'show'])
    ->name('transaksi.show');

Route::delete('/transaction/{id}', [TransaksiController::class, 'destroy'])
    ->name('transaksi.destroy');

Route::get('/transaction/{id}/cetak', [TransaksiController::class, 'cetak'])
    ->name('transaksi.cetak');


    // ---------------------
    // Logout
    // ---------------------
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
