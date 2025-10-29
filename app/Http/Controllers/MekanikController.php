<?php

namespace App\Http\Controllers;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MekanikController extends Controller
{
    // Tampilkan halaman management
    public function showManagementMechanic(Request $request)
    {
        $search = $request->input('search');
        $query = Mechanic::query();

        if ($search) {
            $mechanics = $query->where('mechanic_name', 'like', "%{$search}%")
                ->orWhere('id_mechanic', 'like', "%{$search}%")
                ->get();

            $message = $mechanics->count() > 0
                ? "Data ID/Nama mekanik '{$search}' berhasil ditemukan."
                : "Tidak ada hasil untuk pencarian '{$search}'.";
            $alertType = $mechanics->count() > 0 ? 'success' : 'warning';
        } else {
            $mechanics = Mechanic::all();
            $message = null;
            $alertType = null;
        }

        return view('management-mechanic', [
            'title'     => 'Manajemen Kelola Mekanik',
            'mechanics' => $mechanics,
            'message'   => $message,
            'alertType' => $alertType
        ]);
    }

    // Tampilkan form tambah mekanik
    public function createMechanicForm()
    {
        return view('create-mechanic', [
            'title' => 'Tambah Mekanik'
        ]);
    }

    // Simpan mekanik baru
    public function createMechanic(Request $request)
    {
        $mechanic = new Mechanic();
        $mechanic->id_mechanic = Mechanic::generateMechanicId();
        $mechanic->mechanic_name = $request->mechanic_name;
        $mechanic->mechanic_phone = $request->mechanic_phone;

        if ($request->hasFile('mechanic_image')) {
            $file = $request->file('mechanic_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/mechanics'), $filename);
            $mechanic->mechanic_image = $filename;
        }

        $mechanic->save();

        return redirect()->route('management-mechanic')
                         ->with('success', 'Berhasil menambahkan data mekanik');
    }

    // Tampilkan form edit mekanik
    public function editMechanicForm($id)
    {
        $mechanic = Mechanic::findOrFail($id);

        return view('edit-mechanic', [
            'title' => 'Edit Mekanik',
            'mechanic' => $mechanic
        ]);
    }

    // Update mekanik
    public function updateMechanic(Request $request, $id_mechanic)
    {
        $mechanic = Mechanic::findOrFail($id_mechanic);
        $mechanic->mechanic_name = $request->mechanic_name;
        $mechanic->mechanic_phone = $request->mechanic_phone;

        if ($request->hasFile('mechanic_image')) {
            $oldImagePath = public_path('img/mechanics/' . $mechanic->mechanic_image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $file = $request->file('mechanic_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/mechanics'), $filename);
            $mechanic->mechanic_image = $filename;
        }

        $mechanic->save();

        return redirect()->route('management-mechanic')
                         ->with('success', 'Berhasil memperbarui data mekanik');
    }

    // Hapus mekanik
    public function deleteMechanic($id)
    {
        $mechanic = Mechanic::findOrFail($id);
        $oldImagePath = public_path('img/mechanics/' . $mechanic->mechanic_image);
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }
        $mechanic->delete();

        return redirect()->route('management-mechanic')
                         ->with('success', 'Berhasil menghapus data mekanik');
    }
}
