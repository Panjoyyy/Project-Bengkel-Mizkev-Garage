<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $table = 'motors'; 
    protected $primaryKey = 'id_motor';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_motor',  
        'id_customer',
        'no_plat_motor',
        'merk_motor',
        'warna_motor',
        'tahun_motor'
    ];

     public static function generateMotorId()
    {
        $lastMotor = self::orderBy('id_motor', 'desc')->first();
        if (!$lastMotor) {
            return 'M001';
        }

        $lastNumber = (int) substr($lastMotor->id_motor, 1);
        $newNumber = $lastNumber + 1;
        return 'M' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    // Relasi: satu motor bisa masuk ke banyak servis
    public function servis()
    {
        return $this->hasMany(Servis::class, 'id_motor');
    }
}
