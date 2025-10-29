<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $table = 'mechanics'; 
    protected $primaryKey = 'id_mechanic';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_mechanic',
        'mechanic_name',
        'mechanic_phone',
        'mechanic_image'
    ];

    public function servis()
    {
        return $this->hasMany(Servis::class, 'id_mechanic');
    }
    
    public static function generateMechanicId()
{
    $lastMechanic = self::orderBy('id_mechanic', 'desc')->first();

    if (!$lastMechanic) {
        return 'MK001';
    }
    $lastNumber = (int) preg_replace('/\D/', '', $lastMechanic->id_mechanic);
    $newNumber = $lastNumber + 1;
    return 'MK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}


   
}
