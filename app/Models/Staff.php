<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'staff'; // Nama tabel
    protected $primaryKey = 'id_staff'; // Primary key
    public $timestamps = false; // Kalau tabel tidak pakai created_at & updated_at

    /**
     * Kolom yang bisa diisi (fillable)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_staff',
        'no_telp_staff',
        'foto_staff',
        'username',
        'password',
    ];

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
