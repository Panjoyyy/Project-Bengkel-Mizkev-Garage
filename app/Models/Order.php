<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id_customer',
        'id_motor',
        'id_service',
        'id_mechanic',
        'transaction_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, 'id_mechanic');
    }
}
