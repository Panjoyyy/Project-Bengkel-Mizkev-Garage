<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Customer;

class MotorController extends Controller
{
    // Tampilkan daftar motor
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Motor::with('customer');

        if ($search) {
            $motors = $query->where('id_motor', 'like', "%{$search}%")
                ->orWhere('no_plat_motor', 'like', "%{$search}%")
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('nama_customer', 'like', "%{$search}%");
                })
                ->get();

            if ($motors->count() > 0) {
                $message = "Data ID/Nama motor atau customer '{$search}' berhasil ditemukan.";
                $alertType = 'success';
            } else {
                $message = "Tidak ada hasil untuk pencarian '{$search}'.";
                $alertType = 'warning';
            }
        } else {
            $motors = $query->get();
            $message = null;
            $alertType = null;
        }

        $customers = Customer::all();
        $title = "Manajemen Kelola Motor";

        return view('management-motors', compact('motors', 'customers', 'title', 'message', 'alertType'));
    }

    // Tampilkan form tambah motor
    public function create()
    {
        $customers = Customer::all();
        $title = "Tambah Motor";
        return view('create-motors', compact('customers', 'title'));
    }

    // Simpan motor baru
    public function store(Request $request)
    {
        $request->validate([
            'no_plat_motor' => 'required|string|max:255',
            'merk_motor' => 'required|string|max:255',
            'warna_motor' => 'required|string|max:50',
            'tahun_motor' => 'required|digits:4|integer',
            'id_customer' => 'required|exists:customers,id_customer',
        ]);

        $newIdMotor = Motor::generateMotorId(); // fungsi generate ID di model Motor

        Motor::create([
            'id_motor' => $newIdMotor,
            'no_plat_motor' => $request->no_plat_motor,
            'merk_motor' => $request->merk_motor,
            'warna_motor' => $request->warna_motor,
            'tahun_motor' => $request->tahun_motor,
            'id_customer' => $request->id_customer,
        ]);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil ditambahkan!');
    }

    // Tampilkan form edit motor
    public function edit($id)
    {
        $motor = Motor::findOrFail($id);
        $customers = Customer::all();
        $title = "Edit Motor";
        return view('edit-motors', compact('motor', 'customers', 'title'));
    }

    // Update motor
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_plat_motor' => 'required|string|max:255',
            'merk_motor' => 'required|string|max:255',
            'warna_motor' => 'required|string|max:50',
            'tahun_motor' => 'required|digits:4|integer',
            'id_customer' => 'required|exists:customers,id_customer',
        ]);

        $motor = Motor::findOrFail($id);
        $motor->update([
            'no_plat_motor' => $request->no_plat_motor,
            'merk_motor' => $request->merk_motor,
            'warna_motor' => $request->warna_motor,
            'tahun_motor' => $request->tahun_motor,
            'id_customer' => $request->id_customer,
        ]);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil diupdate!');
    }

    // Hapus motor
    public function destroy($id)
    {
        $motor = Motor::findOrFail($id);
        $motor->delete();

        return redirect()->route('motor.index')->with('success', 'Motor berhasil dihapus!');
    }
}
