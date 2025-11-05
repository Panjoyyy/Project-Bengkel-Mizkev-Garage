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

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'transaction_layanan', 'id_transaksi', 'id_layanan')
                    ->withTimestamps();
    }

    public function sparepart()
    {
        return $this->belongsToMany(Sparepart::class, 'transaction_sparepart', 'id_transaksi', 'id_sparepart')
                    ->withTimestamps();
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
