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
        'id_transaksi', 'no_nota', 'id_servis', 'id_layanan',
        'id_sparepart', 'harga_layanan', 'harga_sparepart',
        'jumlah_sparepart', 'tanggal_transaksi', 'subtotal',
        'metode_pembayaran', 'status_pembayaran',
    ];

    // Otomatis ubah JSON di DB menjadi Array PHP
    protected $casts = [
        'id_layanan' => 'array',
        'id_sparepart' => 'array',
        'jumlah_sparepart' => 'array',
        'tanggal_transaksi' => 'datetime',
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'id_servis', 'id_servis');
    }

    // Mengambil data Layanan berdasarkan ID yang tersimpan di array
    public function getLayananData()
    {
        return Layanan::whereIn('id_layanan', $this->id_layanan ?? [])->get();
    }

    // Mengambil data Sparepart dan menggabungkan jumlahnya
    public function getSparepartData()
    {
        $ids = $this->id_sparepart ?? [];
        $jumlahMap = $this->jumlah_sparepart ?? [];
        $spareparts = Sparepart::whereIn('id_sparepart', $ids)->get();

        foreach ($spareparts as $sp) {
            $sp->jumlah_beli = $jumlahMap[$sp->id_sparepart] ?? 0;
        }

        return $spareparts;
    }

    public static function generateTransaksiId()
    {
        $lastTransaksi = self::orderBy('id_transaksi', 'desc')->first();
        if (!$lastTransaksi) {
            return 'TRMKG001';
        }
        
        // Mengambil angka saja dari ID terakhir
        $lastNumber = (int) preg_replace('/[^0-9]/', '', $lastTransaksi->id_transaksi);
        $newNumber = $lastNumber + 1;
        
        return 'TRMKG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}