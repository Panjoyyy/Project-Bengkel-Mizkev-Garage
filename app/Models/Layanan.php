<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    // Nama tabel (default Laravel bakal cari "layanans", jadi harus di-set)
    protected $table = 'layanan';
    // Primary key custom
    protected $primaryKey = 'id_layanan';
    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'nama_layanan',
        'deskripsi_layanan',
        'lokasi_layanan',
        'harga_layanan',
        'foto_layanan',
    ];
}
