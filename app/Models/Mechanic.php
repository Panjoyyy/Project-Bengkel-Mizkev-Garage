<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $table = 'mechanics'; 
    protected $primaryKey = 'id_mechanic';
    public $timestamps = false;

    protected $fillable = [
        'mechanic_name',
        'mechanic_phone',
        'mechanic_image'
    ];

    public function servis()
    {
        return $this->hasMany(Servis::class, 'id_mechanic');
    }
}
