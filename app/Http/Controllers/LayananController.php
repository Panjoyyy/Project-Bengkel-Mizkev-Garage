<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LayananController extends Controller
{

    public function showManagementService(Request $request)
{
    $search = $request->input('search');
    $query = Layanan::query();

    if ($search) {
        $services = $query->where('nama_layanan', 'like', "%{$search}%")
            ->orWhere('id_layanan', 'like', "%{$search}%")
            ->get();

        if ($services->count() > 0) {
            $message = "Data ID/Nama layanan '{$search}' berhasil ditemukan.";
            $alertType = 'success';
        } else {
            $message = "Tidak ada hasil untuk pencarian '{$search}'.";
            $alertType = 'warning';
        }
    } else {
        $services = Layanan::all();
        $message = null;
        $alertType = null;
    }

    $data = [
        'title'     => 'Manajemen Kelola Layanan',
        'services'  => $services,
        'message'   => $message,
        'alertType' => $alertType
    ];

    return view('management-layanan', $data);
}
    // Tampilkan form tambah layanan
    public function showCreateForm()
    {
        return view('create-layanan', [
        'title' => 'Tambah Layanan'
        ]);
    }

    // Tambah layanan
    public function createService(Request $request)
    {
        $request->validate([
            'nama_layanan'       => 'required|string|max:255',
            'deskripsi_layanan'  => 'nullable|string',
            'lokasi_layanan'     => 'nullable|string',
            'harga_layanan'      => 'required|numeric',
            'foto_layanan'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $layanan = new Layanan();
        $layanan->id_layanan = Layanan::generateLayananId(); 
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->deskripsi_layanan = $request->deskripsi_layanan;
        $layanan->lokasi_layanan = $request->lokasi_layanan;
        $layanan->harga_layanan = $request->harga_layanan;

        if ($request->hasFile('foto_layanan')) {
            $file = $request->file('foto_layanan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/layanan'), $filename);
            $layanan->foto_layanan = $filename;
        }

        $layanan->save();

        return redirect()->route('management-layanan')
                         ->with('success', 'Berhasil menambahkan data layanan');
    }

     // Tampilkan form edit layanan
    public function editServiceForm($id_layanan)
    {
    $service = Layanan::findOrFail($id_layanan);
    return view('edit-layanan', compact('service'));
    }


    // Update layanan
    public function updateService(Request $request, $id_layanan)
    {
        $layanan = Layanan::findOrFail($id_layanan);

        $request->validate([
            'nama_layanan'       => 'required|string|max:255',
            'deskripsi_layanan'  => 'nullable|string',
            'lokasi_layanan'     => 'nullable|string',
            'harga_layanan'      => 'required|numeric',
            'foto_layanan'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->deskripsi_layanan = $request->deskripsi_layanan;
        $layanan->lokasi_layanan = $request->lokasi_layanan;
        $layanan->harga_layanan = $request->harga_layanan;

        if ($request->hasFile('foto_layanan')) {
            $oldImagePath = public_path('img/layanan/' . $layanan->foto_layanan);
            if ($layanan->foto_layanan && File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $file = $request->file('foto_layanan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/layanan'), $filename);
            $layanan->foto_layanan = $filename;
        }

        $layanan->save();

        return redirect()->route('management-layanan')
                         ->with('success', 'Berhasil memperbarui data layanan');
    }

    // Hapus layanan
    public function deleteService($id_layanan)
    {
        $layanan = Layanan::findOrFail($id_layanan);

        if ($layanan->foto_layanan) {
            $imagePath = public_path('img/layanan/' . $layanan->foto_layanan);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $layanan->delete();

        return back()->with('success', 'Berhasil menghapus data layanan');
    }
}
