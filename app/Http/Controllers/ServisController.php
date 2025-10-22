<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Motor;
use App\Models\Mechanic;
use App\Models\Staff;
use App\Models\Customer;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    // Menampilkan halaman manajemen servis
    public function showManagementServis()
    {
        $data = [
            'title'     => 'Manajemen Kelola Servis',
            'servis'    => Servis::with(['customer', 'motor', 'mechanic', 'staff'])->latest()->get(),
            'customers' => Customer::all(), 
            'mechanics' => Mechanic::all(),
            'staffs'    => Staff::all(),
        ];

        return view('management-servis', $data);
    }

    // Fungsi untuk mengambil motor berdasarkan customer via AJAX
    public function getMotorsByCustomer($customerId)
    {
        $motors = Motor::where('id_customer', $customerId)->get();
        return response()->json($motors);
    }

    // Menambahkan data servis
    public function createServis(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customers,id_customer', 
            'id_motor'    => 'required|exists:motors,id_motor',
            'id_mechanic' => 'required|exists:mechanics,id_mechanic',
            // --- PERBAIKAN DI SINI ---
            'id_staff'    => 'required|exists:staff,id_staff', // Dihapus 's' dari 'staffs'
            // -------------------------
            'keluhan'     => 'required|string',
            'tanggal_servis' => 'required|date',
        ]);

        $servis = new Servis();
        $servis->id_customer = $request->id_customer;
        $servis->id_mechanic = $request->id_mechanic;
        $servis->id_motor = $request->id_motor;
        $servis->id_staff = $request->id_staff;
        $servis->keluhan = $request->keluhan;
        $servis->tanggal_servis = $request->tanggal_servis;
        $servis->save();

        return back()->with('success', 'Berhasil menambahkan data servis');
    }

    // Memperbarui data servis
    public function updateServis(Request $request, $id_servis)
    {
        $request->validate([
            'id_customer' => 'required|exists:customers,id_customer',
            'id_motor'    => 'required|exists:motors,id_motor',
            'id_mechanic' => 'required|exists:mechanics,id_mechanic',
            // --- PERBAIKAN DI SINI ---
            'id_staff'    => 'required|exists:staff,id_staff', // Dihapus 's' dari 'staffs'
            // -------------------------
            'keluhan'     => 'required|string',
            'tanggal_servis' => 'required|date',
        ]);

        $servis = Servis::findOrFail($id_servis);
        $servis->id_customer = $request->id_customer;
        $servis->id_mechanic = $request->id_mechanic;
        $servis->id_motor = $request->id_motor;
        $servis->id_staff = $request->id_staff;
        $servis->keluhan = $request->keluhan;
        $servis->tanggal_servis = $request->tanggal_servis;
        $servis->save();

        return back()->with('success', 'Berhasil memperbarui data servis');
    }

    // Menghapus data servis
    public function deleteServis($id_servis)
    {
        $servis = Servis::findOrFail($id_servis);
        $servis->delete();

        return back()->with('success', 'Berhasil menghapus data servis');
    }
}