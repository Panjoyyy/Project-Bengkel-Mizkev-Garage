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

    if ($search) {
        // Jika ada input pencarian
        $servis = Servis::with(['motor', 'mechanic', 'staff'])
            ->where('id_servis', 'like', "%{$search}%")
            ->get();

        if ($servis->isEmpty()) {
            $message = "Tidak ada hasil untuk pencarian '{$search}'.";
            $alertType = 'warning';
        } else {
            $message = "Data ID Servis '{$search}' berhasil ditemukan.";
            $alertType = 'success';
        }
    } else {
        // Jika tidak mencari, tampilkan semua
        $servis = Servis::with(['motor', 'mechanic', 'staff'])->get();
    }

    $motors = Motor::all();
    $mechanics = Mechanic::all();
    $staffs = Staff::all();

    return view('management-servis', [
        'title' => 'Manajemen Data Servis',
        'servis' => $servis,
        'motors' => $motors,
        'mechanics' => $mechanics,
        'staffs' => $staffs,
        'message' => $message,
        'alertType' => $alertType,
    ]);
}

public function getMotorsByCustomer($customerId)
{
    $motors = Motor::where('id_customer', $customerId)->get();
    return response()->json($motors);
}


public function createServisView()
{
    $customers = Customer::all();      
    $motors = Motor::all();            
    $mechanics = Mechanic::all();     
    $staffs = Staff::all();            

    return view('create-servis', compact('customers','motors','mechanics','staffs'));
}


public function createServis(Request $request)
{
    $request->validate([
    'tanggal_servis' => 'required',
    'keluhan' => 'required',
    'id_motor' => 'required|exists:motors,id_motor',
    'id_mechanic' => 'required|exists:mechanics,id_mechanic',
    'id_staff' => 'required|exists:staff,id_staff', 
]);

    $newIdServis = Servis::generateServisId();

    Servis::create([
        'id_servis' => $newIdServis, 
        'tanggal_servis' => $request->tanggal_servis,
        'keluhan' => $request->keluhan,
        'id_motor' => $request->id_motor,
        'id_mechanic' => $request->id_mechanic,
        'id_staff' => $request->id_staff,
    ]);

    return redirect()->route('management-servis')
        ->with(['message' => 'Data servis berhasil ditambahkan!', 'alertType' => 'success']);
}

public function editServisView($id_servis)
{
    $servis = Servis::findOrFail($id_servis);
    $customers = Customer::all();
    $mechanics = Mechanic::all();
    $staffs = Staff::all();
    
    $motors_for_customer = Motor::where('id_customer', $servis->motor->id_customer)->get();

    return view('edit-servis', compact('servis','customers','mechanics','staffs','motors_for_customer'));
}

    public function updateServis(Request $request, $id_servis)
{
    $servis = Servis::findOrFail($id_servis);

    $servis->update([
        'tanggal_servis' => $request->tanggal_servis,
        'keluhan' => $request->keluhan,
        'id_motor' => $request->id_motor,
        'id_mechanic' => $request->id_mechanic,
        'id_staff' => $request->id_staff,
    ]);

    return redirect()->route('management-servis')
        ->with(['message' => 'Data servis berhasil diperbarui!', 'alertType' => 'success']);
}

   public function deleteServis($id_servis)
{
    $servis = Servis::findOrFail($id_servis);
    $servis->delete();

    return redirect()->route('management-servis')
        ->with(['message' => 'Data servis berhasil dihapus!', 'alertType' => 'warning']);
}

}
