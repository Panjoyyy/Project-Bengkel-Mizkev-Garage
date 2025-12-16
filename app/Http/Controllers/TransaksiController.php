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
   public function index(Request $request)
{
    $search = $request->search;
    $message = null;
    $alertType = 'success';

    $query = Transaksi::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('id_transaksi', 'like', "%{$search}%")
              ->orWhere('no_nota', 'like', "%{$search}%")
              ->orWhere('id_servis', 'like', "%{$search}%");
        });
    }

    $transaksi = $query->orderBy('tanggal_transaksi', 'desc')->get();

    // ===== PESAN SEARCH =====
    if ($search) {
        if ($transaksi->count() > 0) {
            $message = "Menampilkan hasil pencarian transaksi untuk kata kunci: \"$search\"";
            $alertType = 'success';
        } else {
            $message = "Data transaksi dengan kata kunci \"$search\" tidak ditemukan";
            $alertType = 'warning';
        }
    }

    // ===== LOAD RELASI =====
    foreach ($transaksi as $t) {
        $t->servis = Servis::find($t->id_servis);

        $layananIds = json_decode($t->id_layanan, true);
        $t->layanan = Layanan::whereIn('id_layanan', $layananIds ?? [])->get();

        $sparepartIds = json_decode($t->id_sparepart, true);
        $t->sparepart = Sparepart::whereIn('id_sparepart', $sparepartIds ?? [])->get();
    }

    return view('management-transaction', [
        'transaksi' => $transaksi,
        'title' => 'Manajemen Transaksi',
        'message' => $message,
        'alertType' => $alertType
    ]);
}

    // Halaman tambah transaksi
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
    $cekTransaksi = Transaksi::where('id_servis', $request->id_servis)->first();

if ($cekTransaksi) {
    DB::rollBack();
    return back()
        ->with('error', 'Servis ini sudah memiliki transaksi!')
        ->withInput();
}

    $request->validate([
        'id_servis' => 'required',
        'id_layanan' => 'required|array',
        'metode_pembayaran' => 'required',
    ]);

    DB::beginTransaction();
    try {
        // ======================================================
        // VALIDASI STATUS SERVIS (WAJIB SELESAI)
        // ======================================================
        $servis = Servis::where('id_servis', $request->id_servis)
            ->where('status_servis', 'selesai')
            ->first();

        if (!$servis) {
            DB::rollBack();
            return back()
                ->with('error', 'Servis belum selesai, transaksi tidak dapat diproses.')
                ->withInput();
        }

        // ======================================================
        // Generate ID Transaksi & Nota
        // ======================================================
        $idTransaksi = Transaksi::generateTransaksiId();
        $noNota = 'NT' . strtoupper(uniqid());

        // ======================================================
        // Hitung Total Harga Layanan
        // ======================================================
        $totalHargaLayanan = Layanan::whereIn('id_layanan', $request->id_layanan)
            ->sum('harga_layanan');

        // ======================================================
        // Hitung Total Harga Sparepart + Kurangi Stok
        // ======================================================
        $totalHargaSparepart = 0;

        if ($request->has('id_sparepart')) {
            foreach ($request->id_sparepart as $id_sparepart) {
                $jumlah = $request->jumlah_sparepart[$id_sparepart] ?? 0;
                $sp = Sparepart::find($id_sparepart);

                if ($sp && $jumlah > 0) {

                    // Validasi stok
                    if ($sp->stok_sparepart < $jumlah) {
                        DB::rollBack();
                        return back()
                            ->with('error', "Stok sparepart {$sp->nama_sparepart} tidak mencukupi!")
                            ->withInput();
                    }

                    // Kurangi stok
                    $sp->stok_sparepart -= $jumlah;
                    $sp->save();

                    $totalHargaSparepart += $sp->harga_sparepart * $jumlah;
                }
            }
        }

        // ======================================================
        // Hitung Subtotal
        // ======================================================
        $subtotal = $totalHargaLayanan + $totalHargaSparepart;

        // ======================================================
        // Validasi Pembayaran Tunai
        // ======================================================
        if ($request->metode_pembayaran === 'Tunai') {
            $uang_dibayar = $request->uang_dibayar ?? 0;

            if ($uang_dibayar < $subtotal) {
                DB::rollBack();
                return back()
                    ->with('error', 'Uang tunai tidak mencukupi untuk membayar transaksi!')
                    ->withInput();
            }
        }

        // ======================================================
        // Simpan Transaksi
        // ======================================================
        Transaksi::create([
            'id_transaksi' => $idTransaksi,
            'no_nota' => $noNota,
            'id_servis' => $request->id_servis,
            'id_layanan' => json_encode($request->id_layanan),
            'id_sparepart' => json_encode($request->id_sparepart),
            'jumlah_sparepart' => json_encode($request->jumlah_sparepart ?? []),
            'harga_layanan' => $totalHargaLayanan,
            'harga_sparepart' => $totalHargaSparepart,
            'tanggal_transaksi' => now(),
            'subtotal' => $subtotal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        DB::commit();
        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
    }
}
public function show($id)
{
    $transaksi = Transaksi::findOrFail($id);

    // Decode JSON
    $layananIds = json_decode($transaksi->id_layanan, true);
    $sparepartIds = json_decode($transaksi->id_sparepart, true);
    $jumlahSparepart = json_decode($transaksi->jumlah_sparepart, true);

    // Relasi data
    $transaksi->servis = Servis::find($transaksi->id_servis);
    $transaksi->layanan = Layanan::whereIn('id_layanan', $layananIds ?? [])->get();
    $transaksi->sparepart = Sparepart::whereIn('id_sparepart', $sparepartIds ?? [])->get();
    $transaksi->jumlah_sp = $jumlahSparepart;

    return view('show-transaction', compact('transaksi'));
}

public function destroy($id)
{
    $transaksi = Transaksi::findOrFail($id);

    // Kembalikan stok sparepart (jika pernah dipakai)
    if ($transaksi->id_sparepart && $transaksi->jumlah_sparepart) {
        $sparepartIds = json_decode($transaksi->id_sparepart, true);
        $jumlahs = json_decode($transaksi->jumlah_sparepart, true);

        foreach ($sparepartIds as $spId) {
            $sp = Sparepart::find($spId);
            if ($sp) {
                $sp->stok_sparepart += ($jumlahs[$spId] ?? 0);
                $sp->save();
            }
        }
    }

    // Hapus transaksi
    $transaksi->delete();

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
}

public function cetak($id)
{
    $transaksi = Transaksi::with('servis')->findOrFail($id);
    return view('nota-transaction', compact('transaksi'));
}

}
