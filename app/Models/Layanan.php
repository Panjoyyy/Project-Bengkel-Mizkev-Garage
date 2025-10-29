<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_layanan',
        'nama_layanan',
        'deskripsi_layanan',
        'lokasi_layanan',
        'harga_layanan',
        'foto_layanan',
    ];

     public static function generateLayananId()
    {
        $lastLayanan = self::orderBy('id_layanan', 'desc')->first();
        if (!$lastLayanan) {
            return 'L001';
        }

        $lastNumber = (int) substr($lastLayanan->id_layanan, 1);
        $newNumber = $lastNumber + 1;
        return 'L' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
