<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'no_nota',
        'id_servis',
        'id_layanan',
        'id_sparepart',
        'harga_layanan',
        'harga_sparepart',
        'jumlah_sparepart',
        'tanggal_transaksi',
        'subtotal',
        'metode_pembayaran',
        'status_pembayaran',
        // Kolom Midtrans dari branch create_transaction
        'snap_token',
        'midtrans_order_id',
        'midtrans_payment_type',
        'midtrans_transaction_status',
        'payment_expired_at',
        'detail_pembayaran',
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'id_servis', 'id_servis');
    }

    // 1. Fungsi versi create_transaction (Temanmu)
    public function layanan()
    {
        $ids = is_string($this->id_layanan) ? json_decode($this->id_layanan, true) : $this->id_layanan;
        return Layanan::whereIn('id_layanan', $ids ?? [])->get();
    }

    public function sparepart()
    {
        $ids = is_string($this->id_sparepart) ? json_decode($this->id_sparepart, true) : $this->id_sparepart;
        $jumlah = is_string($this->jumlah_sparepart) ? json_decode($this->jumlah_sparepart, true) : $this->jumlah_sparepart;
        $spareparts = Sparepart::whereIn('id_sparepart', $ids ?? [])->get();

        foreach ($spareparts as $sp) {
            $sp->jumlah = $jumlah[$sp->id_sparepart] ?? 0;
            $sp->jumlah_beli = $jumlah[$sp->id_sparepart] ?? 0;
        }

        return $spareparts;
    }

    // 2. Fungsi versi kevin_transaksi (Milikmu) - tetap dipertahankan agar blade tidak error
    public function getLayananData()
    {
        return $this->layanan();
    }

    public function getSparepartData()
    {
        return $this->sparepart();
    }

    public static function generateTransaksiId()
    {
        $lastTransaksi = self::orderBy('id_transaksi', 'desc')->first();
        if (!$lastTransaksi) {
            return 'TRMKG001';
        }
        $lastNumber = (int) preg_replace('/\D/', '', $lastTransaksi->id_transaksi);
        $newNumber = $lastNumber + 1;
        return 'TRMKG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}