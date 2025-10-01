<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_mechanic';
    public $timestamps = false;

    protected $fillable = [
        'machanic_name',
        'mechanic_phone',
        'mechanic_image'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_mechanic');
    }
}
