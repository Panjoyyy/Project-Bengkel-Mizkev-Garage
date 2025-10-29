<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'spareparts'; 
    protected $primaryKey = 'id_sparepart';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_sparepart',
        'nama_sparepart',
        'stok_sparepart',
        'harga_sparepart'
    ];

    public static function generateSparepartId()
    {
        $lastSparepart = self::orderBy('id_sparepart', 'desc')->first();
        if (!$lastSparepart) {
            return 'SPR001';
        }
        $lastNumber = (int) preg_replace('/\D/', '', $lastSparepart->id_sparepart);
        $newNumber = $lastNumber + 1;
        return 'SPR' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // public function motors()
    //{
        //return $this->hasMany(Motor::class, 'id_customer', 'id_customer');
    //}
}
