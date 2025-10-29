<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'staff'; 
    protected $primaryKey = 'id_staff'; 
      public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = false; 

    /**
     * Kolom yang bisa diisi (fillable)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_staff',
        'nama_staff',
        'no_telp_staff',
        'foto_staff',
        'username',
        'password',
    ];

    public static function generateStaffId()
    {
        $last = self::orderBy('id_staff', 'desc')->first();
        if (!$last) {
            return 'ST001';
        }
        $num = (int) substr($last->id_staff, 2);
        return 'ST' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Kolom yang disembunyikan (hidden)
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casting atribut (misalnya untuk hash password)
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    // Relasi: satu staff bisa melayani banyak servis
    public function servis()
    {
        return $this->hasMany(Servis::class, 'id_staff');
    }
}
