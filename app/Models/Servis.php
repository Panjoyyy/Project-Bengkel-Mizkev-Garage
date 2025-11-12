<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;
    protected $table = 'servis';
    protected $primaryKey = 'id_servis';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_servis',
        'id_motor',
        'id_mechanic',
        'id_staff',
        'keluhan',
        'tanggal_servis',
        'status_servis'
    ];

     public static function generateServisId()
    {
        $lastServis = self::orderBy('id_servis', 'desc')->first();
        if (!$lastServis) {
            return 'SRC001';
        }
        $lastNumber = (int) preg_replace('/\D/', '', $lastServis->id_servis);
        $newNumber = $lastNumber + 1;
        return 'SRC' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
     /**
     * Relasi ke Customer (INI YANG HILANG)
     */
    }

    // Relasi ke Motor
    public function motor()
    {
         return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }

    // Relasi ke Mekanik
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, 'id_mechanic', 'id_mechanic');
    }

    // Relasi ke Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id_staff', 'id_staff');
    }
}
