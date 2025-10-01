<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LayananController extends Controller
{
    // Tampilkan semua layanan
    public function showManagementService()
    {
        $data = [
            'title'     => 'Manajemen Layanan',
            'services'  => Layanan::all()
        ];
        return view('management-layanan', $data);
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

        return back()->with('success', 'Berhasil menambahkan data layanan');
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

        return back()->with('success', 'Berhasil memperbarui data layanan');
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
