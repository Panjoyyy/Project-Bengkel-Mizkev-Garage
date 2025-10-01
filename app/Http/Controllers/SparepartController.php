<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;

class SparepartController extends Controller
{
    // Tampilkan semua sparepart
    public function index()
    {
        $spareparts = Sparepart::all();
        return view('management-spareparts', compact('spareparts'));
    }

    // Simpan sparepart baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'stok_sparepart' => 'required|integer|min:0',
            'harga_sparepart' => 'required|numeric|min:0',
        ]);

        Sparepart::create([
            'nama_sparepart' => $request->nama_sparepart,
            'stok_sparepart' => $request->stok_sparepart,
            'harga_sparepart' => $request->harga_sparepart,
        ]);

        return redirect()->route('spareparts.index')->with('success', 'Sparepart berhasil ditambahkan!');
    }

    // Edit sparepart 
    public function edit($id)
    {
    $sparepart = Sparepart::findOrFail($id);
    $spareparts = Sparepart::all();

    return view('management-spareparts', compact('spareparts', 'sparepart'));
    }
    // Update sparepart
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'stok_sparepart' => 'required|integer|min:0',
            'harga_sparepart' => 'required|numeric|min:0',
        ]);

        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update([
            'nama_sparepart' => $request->nama_sparepart,
            'stok_sparepart' => $request->stok_sparepart,
            'harga_sparepart' => $request->harga_sparepart,
        ]);

        return redirect()->route('spareparts.index')->with('success', 'Sparepart berhasil diperbarui!');
    }

    // Hapus sparepart
    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect()->route('spareparts.index')->with('success', 'Sparepart berhasil dihapus!');
    }
}
