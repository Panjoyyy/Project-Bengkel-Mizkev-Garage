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
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'id_servis', 'id_servis');
    }

    // Ambil layanan dari JSON
    public function layanan()
    {
        $ids = json_decode($this->id_layanan ?? '[]');
        return Layanan::whereIn('id_layanan', $ids)->get();
    }

    // Ambil sparepart dari JSON dan gabungkan jumlah
    public function sparepart()
    {
        $ids = json_decode($this->id_sparepart ?? '[]');
        $jumlah = json_decode($this->jumlah_sparepart ?? '{}', true);
        $spareparts = Sparepart::whereIn('id_sparepart', $ids)->get();

        foreach($spareparts as $sp){
            $sp->jumlah = $jumlah[$sp->id_sparepart] ?? 0;
        }

        return $spareparts;
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
