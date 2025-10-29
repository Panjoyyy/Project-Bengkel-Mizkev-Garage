<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id_customer';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_customer',
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

    public static function generateCustomerId()
    {
        $lastCustomer = self::orderBy('id_customer', 'desc')->first();
        if (!$lastCustomer) {
            return 'C001';
        }

        $lastNumber = (int) substr($lastCustomer->id_customer, 1);
        $newNumber = $lastNumber + 1;
        return 'C' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
