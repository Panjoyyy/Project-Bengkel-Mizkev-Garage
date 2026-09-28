<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Servis;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // ============================================================
        // 1. TENTUKAN RENTANG TANGGAL BERDASARKAN FILTER
        // ============================================================
        $filter   = $request->input('filter', 'bulan_ini');
        $dateFrom = null;
        $dateTo   = null;

        switch ($filter) {
            case 'hari_ini':
                $dateFrom = Carbon::today();
                $dateTo   = Carbon::today()->endOfDay();
                $labelPeriode = 'Hari Ini (' . Carbon::today()->format('d M Y') . ')';
                break;

            case 'minggu_ini':
                $dateFrom = Carbon::now()->startOfWeek(Carbon::MONDAY);
                $dateTo   = Carbon::now()->endOfWeek(Carbon::SUNDAY)->endOfDay();
                $labelPeriode = 'Minggu Ini (' . $dateFrom->format('d M') . ' – ' . $dateTo->format('d M Y') . ')';
                break;

            case 'tahun_ini':
                $dateFrom = Carbon::now()->startOfYear();
                $dateTo   = Carbon::now()->endOfYear()->endOfDay();
                $labelPeriode = 'Tahun ' . Carbon::now()->year;
                break;

            case 'custom':
                // Validasi dan sanitasi input custom
                $rawFrom = $request->input('date_from');
                $rawTo   = $request->input('date_to');

                // Pastikan format valid sebelum parsing
                try {
                    $dateFrom = $rawFrom ? Carbon::createFromFormat('Y-m-d', $rawFrom)->startOfDay() : Carbon::now()->startOfMonth();
                    $dateTo   = $rawTo   ? Carbon::createFromFormat('Y-m-d', $rawTo)->endOfDay()     : Carbon::now()->endOfDay();
                } catch (\Exception $e) {
                    $dateFrom = Carbon::now()->startOfMonth();
                    $dateTo   = Carbon::now()->endOfDay();
                }

                // Pastikan dateFrom tidak lebih besar dari dateTo
                if ($dateFrom->gt($dateTo)) {
                    [$dateFrom, $dateTo] = [$dateTo, $dateFrom];
                }

                $labelPeriode = $dateFrom->format('d M Y') . ' – ' . $dateTo->format('d M Y');
                break;

            case 'bulan_ini':
            default:
                $filter   = 'bulan_ini';
                $dateFrom = Carbon::now()->startOfMonth();
                $dateTo   = Carbon::now()->endOfMonth()->endOfDay();
                $labelPeriode = 'Bulan ' . Carbon::now()->format('F Y');
                break;
        }

        // ============================================================
        // 2. QUERY SUMMARY — satu query agregasi, hindari N+1
        // ============================================================
        $summary = DB::table('transaction')
            ->whereBetween('tanggal_transaksi', [$dateFrom, $dateTo])
            ->selectRaw('
                COUNT(*)                    AS jumlah_transaksi,
                COALESCE(SUM(subtotal), 0)        AS total_pendapatan,
                COALESCE(SUM(harga_layanan), 0)   AS total_layanan,
                COALESCE(SUM(harga_sparepart), 0) AS total_sparepart,
                COALESCE(AVG(subtotal), 0)        AS rata_rata
            ')
            ->first();

        // ============================================================
        // 3. QUERY GRAFIK — pendapatan & jumlah transaksi per tanggal
        // ============================================================
        $grafikRaw = DB::table('transaction')
            ->whereBetween('tanggal_transaksi', [$dateFrom, $dateTo])
            ->selectRaw('
                DATE(tanggal_transaksi) AS tanggal,
                COALESCE(SUM(subtotal), 0) AS total,
                COUNT(*) AS jumlah
            ')
            ->groupByRaw('DATE(tanggal_transaksi)')
            ->orderBy('tanggal')
            ->get();

        // Siapkan data grafik dalam format yang bisa langsung di-json untuk JS
        $grafikLabels    = $grafikRaw->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('d M'))->values();
        $grafikPendapatan = $grafikRaw->pluck('total')->map(fn($v) => (float) $v)->values();
        $grafikJumlah    = $grafikRaw->pluck('jumlah')->map(fn($v) => (int) $v)->values();

        // ============================================================
        // 4. QUERY TABEL TRANSAKSI — eager load relasi chain
        //    transaksi → servis → motor → customer
        //                       → mechanic
        // ============================================================
        $transaksi = Transaksi::with([
                'servis.motor.customer',
                'servis.mechanic',
            ])
            ->whereBetween('tanggal_transaksi', [$dateFrom, $dateTo])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // ============================================================
        // 5. RINGKASAN METODE PEMBAYARAN (bonus info untuk sidebar card)
        // ============================================================
        $metodeSummary = DB::table('transaction')
            ->whereBetween('tanggal_transaksi', [$dateFrom, $dateTo])
            ->selectRaw('metode_pembayaran, COUNT(*) AS jumlah, COALESCE(SUM(subtotal), 0) AS total')
            ->groupBy('metode_pembayaran')
            ->orderByDesc('total')
            ->get();

        return view('laporan-keuangan', compact(
            'filter',
            'dateFrom',
            'dateTo',
            'labelPeriode',
            'summary',
            'grafikLabels',
            'grafikPendapatan',
            'grafikJumlah',
            'transaksi',
            'metodeSummary'
        ));
    }
}
