<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Servis;
use App\Models\Layanan;
use App\Models\Sparepart;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Transaksi::with('servis'); 

        if ($search) {
            $query->where('id_transaksi', 'like', "%{$search}%")
                  ->orWhere('no_nota', 'like', "%{$search}%")
                  ->orWhere('id_servis', 'like', "%{$search}%");
        }

        $transaksi = $query->orderBy('tanggal_transaksi', 'desc')->get();
        
        $message = null;
        $alertType = 'success';

        if ($search) {
            if ($transaksi->isEmpty()) {
                $message = "Data transaksi dengan kata kunci \"$search\" tidak ditemukan";
                $alertType = 'warning';
            } else {
                $message = "Menampilkan hasil pencarian untuk: \"$search\"";
            }
        }

        return view('management-transaction', compact('transaksi', 'message', 'alertType'));
    }

    public function create()
    {
        $servis = Servis::where('status_servis', 'selesai')
            ->whereDoesntHave('transaksi')
            ->get();

        $layanan = Layanan::all();
        $spareparts = Sparepart::all();

        return view('create-transaction', compact('servis', 'layanan', 'spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_servis' => 'required',
            'id_layanan' => 'required|array',
            'metode_pembayaran' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if (Transaksi::where('id_servis', $request->id_servis)->exists()) {
                throw new \Exception('Servis ini sudah memiliki transaksi!');
            }

            $servis = Servis::where('id_servis', $request->id_servis)
                            ->where('status_servis', 'selesai')
                            ->firstOrFail();

            $idTransaksi = Transaksi::generateTransaksiId();
            $noNota = 'NT' . strtoupper(uniqid());

            $totalHargaLayanan = Layanan::whereIn('id_layanan', $request->id_layanan)->sum('harga_layanan');

            $totalHargaSparepart = 0;
            $sparepartIds = $request->id_sparepart ?? [];
            $jumlahInputs = $request->jumlah_sparepart ?? [];

            foreach ($sparepartIds as $spId) {
                $qty = $jumlahInputs[$spId] ?? 0;
                if ($qty > 0) {
                    $sp = Sparepart::lockForUpdate()->find($spId);
                    if (!$sp || $sp->stok_sparepart < $qty) {
                        throw new \Exception("Stok sparepart {$sp->nama_sparepart} tidak mencukupi!");
                    }
                    $sp->decrement('stok_sparepart', $qty);
                    $totalHargaSparepart += ($sp->harga_sparepart * $qty);
                }
            }

            $subtotal = $totalHargaLayanan + $totalHargaSparepart;

            if ($request->metode_pembayaran === 'Tunai' && ($request->uang_dibayar < $subtotal)) {
                throw new \Exception('Uang tunai tidak mencukupi!');
            }

            Transaksi::create([
                'id_transaksi' => $idTransaksi,
                'no_nota' => $noNota,
                'id_servis' => $request->id_servis,
                'id_layanan' => $request->id_layanan, 
                'id_sparepart' => $sparepartIds,
                'jumlah_sparepart' => $jumlahInputs,
                'harga_layanan' => $totalHargaLayanan,
                'harga_sparepart' => $totalHargaSparepart,
                'tanggal_transaksi' => now(),
                'subtotal' => $subtotal,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    // --- MENAMBAHKAN KEMBALI METHOD SHOW ---
    public function show($id)
    {
        $transaksi = Transaksi::with('servis')->findOrFail($id);
        return view('show-transaction', compact('transaksi'));
    }

    // --- MENAMBAHKAN KEMBALI METHOD CETAK ---
    public function cetak($id)
    {
        $transaksi = Transaksi::with('servis')->findOrFail($id);
        return view('nota-transaction', compact('transaksi'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $t = Transaksi::findOrFail($id);
            $sparepartIds = $t->id_sparepart ?? [];
            $jumlahs = $t->jumlah_sparepart ?? [];

            foreach ($sparepartIds as $spId) {
                $qty = $jumlahs[$spId] ?? 0;
                Sparepart::where('id_sparepart', $spId)->increment('stok_sparepart', $qty);
            }

            $t->delete();
            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}