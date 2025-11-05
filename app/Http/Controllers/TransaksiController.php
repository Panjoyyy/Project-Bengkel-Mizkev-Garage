<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Servis;
use App\Models\Layanan;
use App\Models\Sparepart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Halaman daftar transaksi
    public function index()
    {
        $transaksi = Transaksi::latest()->get();

        // Loop tiap transaksi untuk decode JSON-nya
        foreach ($transaksi as $t) {
        $layananIds = json_decode($t->id_layanan, true);
        $sparepartIds = json_decode($t->id_sparepart, true);

        // Ambil nama layanan dan sparepart berdasarkan ID
        $t->servis = Servis::find($t->id_servis);
        $t->layanan = Layanan::whereIn('id_layanan', $layananIds ?? [])->get();
        $t->sparepart = Sparepart::whereIn('id_sparepart', $sparepartIds ?? [])->get();
    }

    return view('management-transaction', compact('transaksi'));
    }

    // Halaman tambah transaksi
    public function create()
    {
        $servis = Servis::all();
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
        // === Generate ID Transaksi ===
        $idTransaksi = Transaksi::generateTransaksiId();

        // (Opsional) Generate nomor nota unik
        $noNota = 'NT' . strtoupper(uniqid());

        // === Hitung total harga layanan ===
        $totalHargaLayanan = Layanan::whereIn('id_layanan', $request->id_layanan)->sum('harga_layanan');

        // === Hitung total harga sparepart ===
        $totalHargaSparepart = 0;
        if ($request->has('id_sparepart')) {
            foreach ($request->id_sparepart as $id_sparepart) {
                $jumlah = $request->jumlah_sparepart[$id_sparepart] ?? 0;
                $sp = Sparepart::find($id_sparepart);

                if ($sp) {
                    // Cek stok
                    if ($sp->stok_sparepart < $jumlah) {
                        return back()->with('error', "Stok sparepart {$sp->nama_sparepart} tidak mencukupi!");
                    }

                    // Kurangi stok
                    $sp->stok_sparepart -= $jumlah;
                    $sp->save();

                    $totalHargaSparepart += $sp->harga_sparepart * $jumlah;
                }
            }
        }

        // === Hitung subtotal ===
        $subtotal = $totalHargaLayanan + $totalHargaSparepart;

        // === Validasi uang tunai jika metode pembayaran Tunai ===
        if ($request->metode_pembayaran === 'Tunai') {
            $uang_dibayar = $request->uang_dibayar ?? 0;
            if ($uang_dibayar < $subtotal) {
                return back()->with('error', 'Uang tunai tidak mencukupi untuk membayar subtotal transaksi!');
            }
        }

        // === Simpan data jumlah sparepart dalam JSON ===
        $jumlahSparepart = $request->input('jumlah_sparepart', []);
        $jumlahSparepartJson = json_encode($jumlahSparepart);

        // === Simpan Transaksi ke Database ===
        Transaksi::create([
            'id_transaksi' => $idTransaksi,
            'no_nota' => $noNota,
            'id_servis' => $request->id_servis,
            'id_layanan' => json_encode($request->id_layanan),
            'id_sparepart' => json_encode($request->id_sparepart),
            'harga_layanan' => $totalHargaLayanan,
            'harga_sparepart' => $totalHargaSparepart,
            'jumlah_sparepart' => $jumlahSparepartJson,
            'tanggal_transaksi' => now(),
            'subtotal' => $subtotal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        DB::commit();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
    }
}

}
