<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;
    protected $table = 'servis';
    protected $primaryKey = 'id_servis';
    protected $fillable = [
        'id_motor',
        'id_mekanik',
        'id_staff',
        'keluhan',
        'tanggal_servis'
    ];

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
