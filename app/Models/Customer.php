<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; 
    protected $primaryKey = 'id_customer';
    protected $fillable = [
        'nama_customer',
        'no_telp_customer',
        'alamat_customer',
        'email_customer'
    ];

    // Relasi ke Motor
    public function motors()
    {
        return $this->hasMany(Motor::class, 'id_customer', 'id_customer');
    }
}
