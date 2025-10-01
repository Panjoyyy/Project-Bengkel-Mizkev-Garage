<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $table = 'motors'; 
    protected $primaryKey = 'id_motor';
    protected $fillable = [
        'id_customer',
        'no_plat_motor',
        'merk_motor',
        'warna_motor',
        'tahun_motor'
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
