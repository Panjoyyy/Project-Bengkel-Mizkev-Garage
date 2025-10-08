<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\LayananController; 

// Route untuk menampilkan halaman porto
Route::get('/porto', function () {
    return view('porto');
});

    // Halaman Utama (Public)
    Route::get('/', [CustomerController::class, 'showHome'])->name('home');

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
    Route::get('/management-customer', [CustomerController::class, 'showManagementCustomer'])->name('management-customer');
    Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->name('create-customer');
    Route::put('/update-customer/{id_customer}', [CustomerController::class, 'updateCustomer'])->name('update-customer');
    Route::delete('/delete-customer/{id_customer}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');

    // Route Management Data Motor
    Route::get('/management-motors', [MotorController::class, 'index'])->name('motor.index');
    Route::get('/management-motor', [MotorController::class, 'index'])->name('management-motors');
    Route::post('/motor/store', [MotorController::class, 'store'])->name('motor.store');
    Route::put('/motor/update/{id}', [MotorController::class, 'update'])->name('motor.update');
    Route::delete('/motor/destroy/{id}', [MotorController::class, 'destroy'])->name('motor.destroy');

    // Route Management Data Sparepart
    Route::get('/management-spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
    Route::post('/management-spareparts', [SparepartController::class, 'store'])->name('spareparts.store');
    Route::get('/management-spareparts/{id}/edit', [SparepartController::class, 'edit'])->name('spareparts.edit');
    Route::put('/management-spareparts/{id}', [SparepartController::class, 'update'])->name('spareparts.update');
    Route::delete('/management-spareparts/{id}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');

    // ---------------------
    // Order
    // ---------------------
    Route::get('/create-order', [AdminController::class, 'showCreateOrder'])->name('create-order');
    Route::post('/create-order', [AdminController::class, 'createOrder'])->name('handle-create-order');

    // ---------------------
    // Management Layanan
    // ---------------------
    Route::get('/management-layanan', [LayananController::class, 'showManagementService'])->name('management-layanan');
    Route::post('/create-service', [LayananController::class, 'createService'])->name('create-service');
    Route::put('/update-service/{id_service}', [LayananController::class, 'updateService'])->name('update-service');
    Route::delete('/delete-service/{id_service}', [LayananController::class, 'deleteService'])->name('delete-service');

    // ---------------------
    // Management Mechanic
    // ---------------------
    Route::get('/management-mechanic', [MekanikController::class, 'showManagementMechanic'])->name('management-mechanic');
    Route::post('/create-mechanic', [MekanikController::class, 'createMechanic'])->name('create-mechanic');
    Route::put('/update-mechanic/{id_mechanic}', [MekanikController::class, 'updateMechanic'])->name('update-mechanic');
    Route::delete('/delete-mechanic/{id_mechanic}', [MekanikController::class, 'deleteMechanic'])->name('delete-mechanic');

    // ---------------------
    // Transaction
    // ---------------------
    Route::get('/transaction', [AdminController::class, 'showTransaction'])->name('transaction');

    // ---------------------
    // Logout
    // ---------------------
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
