<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;

class SparepartController extends Controller
{
    // Tampilkan semua sparepart
    public function index(Request $request)
{
    $search = $request->input('search');
    $query = Sparepart::query();

    if ($search) {
        $spareparts = $query->where('nama_sparepart', 'like', "%{$search}%")
            ->orWhere('id_sparepart', 'like', "%{$search}%")
            ->get();

        if ($spareparts->count() > 0) {
            $message = "Data sparepart dengan kata kunci '{$search}' berhasil ditemukan.";
            $alertType = 'success';
        } else {
            $message = "Tidak ada hasil untuk pencarian '{$search}'.";
            $alertType = 'warning';
        }
    } else {
        $spareparts = Sparepart::all();
        $message = null;
        $alertType = null;
    }

    $title = 'Manajemen Kelola Sparepart';

    return view('management-spareparts', compact('spareparts', 'title', 'message', 'alertType'));
}

    // Form tambah
    public function createForm()
    {
        return view('create-sparepart', ['title' => 'Tambah Sparepart']);
    }

    // Simpan sparepart baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'stok_sparepart' => 'required|integer|min:0',
            'harga_sparepart' => 'required|numeric|min:0',
        ]);

        $newIdSparepart = Sparepart::generateSparepartId();

        Sparepart::create([
            'id_sparepart' => $newIdSparepart,
            'nama_sparepart' => $request->nama_sparepart,
            'stok_sparepart' => $request->stok_sparepart,
            'harga_sparepart' => $request->harga_sparepart,
        ]);

        return redirect()->route('spareparts.index')->with('success', 'Sparepart berhasil ditambahkan!');
    }

    // Form edit
    public function editForm($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('edit-sparepart', compact('sparepart'));
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
