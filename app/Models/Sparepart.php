<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'spareparts'; 
    protected $primaryKey = 'id_sparepart';
    protected $fillable = [
        'nama_sparepart',
        'stok_sparepart',
        'harga_sparepart'
    ];

    // public function motors()
    //{
        //return $this->hasMany(Motor::class, 'id_customer', 'id_customer');
    //}
}
