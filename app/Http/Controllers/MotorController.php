<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Customer;

class MotorController extends Controller
{
    // Menampilkan semua motor
    public function index()
    {
        $motors = Motor::with('customer')->get();
        $customers = Customer::all();
        $title = "Management Motor";
        return view('management-motors', compact('motors', 'customers', 'title'));
        $motors = Motor::all();
        return view('create-order', compact('customers', 'motors', 'services', 'mechanics'));

    }

    



    // Simpan motor baru
    public function store(Request $request)
    {
        $request->validate([
            'no_plat_motor' => 'required|string|max:255',
            'merk_motor' => 'required|string|max:255',
            'warna_motor' => 'required|string|max:50',
            'tahun_motor' => 'required|digits:4|integer', // YEAR
            'id_customer' => 'required|exists:customers,id_customer',
        ]);

        Motor::create([
            'no_plat_motor' => $request->no_plat_motor,
            'merk_motor' => $request->merk_motor,
            'warna_motor' => $request->warna_motor,
            'tahun_motor' => $request->tahun_motor,
            'id_customer' => $request->id_customer,
        ]);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil ditambahkan!');
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
        $motor->update($request->all());

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
