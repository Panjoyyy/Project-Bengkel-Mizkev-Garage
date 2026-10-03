<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Servis;
use App\Models\Layanan;
use App\Models\Sparepart;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function __construct(
        protected MidtransService $midtrans
    ) {}
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
    // ======================================================
    // 1. CEK DUPLIKASI (sebelum DB transaction dimulai)
    // ======================================================
    $cekTransaksi = Transaksi::where('id_servis', $request->id_servis)->first();
    if ($cekTransaksi) {
        return back()
            ->with('error', 'Servis ini sudah memiliki transaksi!')
            ->withInput();
    }

    // ======================================================
    // 2. VALIDASI INPUT
    // ======================================================
    $request->validate([
        'id_servis'          => 'required|string',
        'id_layanan'         => 'required|array|min:1',
        'metode_pembayaran'  => 'required|in:Cash,QRIS,Transfer,Pembayaran Online',
    ]);

    $isOnlinePayment = $request->metode_pembayaran === 'Pembayaran Online';

    // ======================================================
    // 3. DB TRANSACTION — simpan data inti + kurangi stok
    //    Pemanggilan API Midtrans dilakukan DI LUAR blok ini
    //    untuk menghindari DB lock timeout.
    // ======================================================
    DB::beginTransaction();
    try {
        // ── Validasi status servis ────────────────────────
        $servis = Servis::where('id_servis', $request->id_servis)
            ->where('status_servis', 'selesai')
            ->first();

        if (!$servis) {
            DB::rollBack();
            return back()
                ->with('error', 'Servis belum selesai, transaksi tidak dapat diproses.')
                ->withInput();
        }

        // ── Generate ID & Nota ────────────────────────────
        $idTransaksi = Transaksi::generateTransaksiId();
        $noNota      = 'NT' . strtoupper(uniqid());

        // ── Hitung total layanan ──────────────────────────
        $totalHargaLayanan = Layanan::whereIn('id_layanan', $request->id_layanan)
            ->sum('harga_layanan');

        // ── Hitung total sparepart + kurangi stok ─────────
        $totalHargaSparepart = 0;

        if ($request->has('id_sparepart')) {
            foreach ($request->id_sparepart as $id_sparepart) {
                $jumlah = $request->jumlah_sparepart[$id_sparepart] ?? 0;
                $sp     = Sparepart::find($id_sparepart);

                if ($sp && $jumlah > 0) {
                    if ($sp->stok_sparepart < $jumlah) {
                        DB::rollBack();
                        return back()
                            ->with('error', "Stok sparepart {$sp->nama_sparepart} tidak mencukupi!")
                            ->withInput();
                    }
                    $sp->stok_sparepart -= $jumlah;
                    $sp->save();
                    $totalHargaSparepart += $sp->harga_sparepart * $jumlah;
                }
            }
        }

        // ── Subtotal ──────────────────────────────────────
        $subtotal = $totalHargaLayanan + $totalHargaSparepart;

        // ── Validasi uang tunai (hanya untuk Cash) ────────
        if ($request->metode_pembayaran === 'Cash') {
            $uang_dibayar = (float) ($request->uang_dibayar ?? 0);
            if ($uang_dibayar < $subtotal) {
                DB::rollBack();
                return back()
                    ->with('error', 'Uang tunai tidak mencukupi untuk membayar transaksi!')
                    ->withInput();
            }
        }

        // ── Tentukan status & midtrans_order_id ───────────
        $statusPembayaran  = $isOnlinePayment ? 'Belum Lunas' : 'Lunas';
        $midtransOrderId   = $isOnlinePayment ? 'MZKV-' . $idTransaksi : null;

        // ── Simpan transaksi ──────────────────────────────
        $transaksi = Transaksi::create([
            'id_transaksi'      => $idTransaksi,
            'no_nota'           => $noNota,
            'id_servis'         => $request->id_servis,
            'id_layanan'        => json_encode($request->id_layanan),
            'id_sparepart'      => json_encode($request->id_sparepart),
            'jumlah_sparepart'  => json_encode($request->jumlah_sparepart ?? []),
            'harga_layanan'     => $totalHargaLayanan,
            'harga_sparepart'   => $totalHargaSparepart,
            'tanggal_transaksi' => now(),
            'subtotal'          => $subtotal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $statusPembayaran,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('[TransaksiController] Gagal menyimpan transaksi', [
            'error' => $e->getMessage(),
        ]);
        return back()
            ->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())
            ->withInput();
    }

    // ======================================================
    // 4. ALUR BERDASARKAN METODE PEMBAYARAN
    //    Panggilan Midtrans API dilakukan di sini, DI LUAR
    //    blok DB::transaction agar tidak menyebabkan lock.
    // ======================================================
    if ($isOnlinePayment) {
        // ── Ambil Snap Token dari Midtrans ────────────────
        try {
            // Muat relasi yang dibutuhkan MidtransService
            $transaksi->load(['servis.motor.customer']);

            $snapData = $this->midtrans->createSnapToken($transaksi);

            // Simpan snap_token dan waktu expired (default Midtrans: 24 jam)
            $transaksi->update([
                'snap_token'       => $snapData['snap_token'],
                'payment_expired_at' => now()->addHours(24),
            ]);

            Log::info('[TransaksiController] Snap Token berhasil dibuat', [
                'id_transaksi'     => $transaksi->id_transaksi,
                'midtrans_order_id'=> $transaksi->midtrans_order_id,
            ]);

        } catch (\Exception $e) {
            // Snap token gagal: transaksi tetap tersimpan sebagai Belum Lunas,
            // admin bisa coba generate ulang atau ubah ke metode manual.
            Log::error('[TransaksiController] Gagal mendapatkan Snap Token', [
                'id_transaksi' => $transaksi->id_transaksi,
                'error'        => $e->getMessage(),
            ]);
            return redirect()->route('transaksi.payment', ['id' => $transaksi->id_transaksi])
                ->with('warning', 'Transaksi tersimpan, tetapi koneksi ke Midtrans gagal: '
                    . $e->getMessage()
                    . '. Silakan coba lagi dari halaman pembayaran.');
        }

        // ── Redirect ke halaman pembayaran ───────────────
        return redirect()->route('transaksi.payment', ['id' => $transaksi->id_transaksi])
            ->with('success', 'Transaksi berhasil dibuat. Silakan selesaikan pembayaran.');
    }

    // ── Offline: redirect langsung ke index ──────────────
    return redirect()->route('transaksi.index')
        ->with('success', 'Transaksi berhasil ditambahkan!');
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
