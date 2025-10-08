<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([
            'username' => 'brian',
            'password' => bcrypt('123admin456'),
            'nama_staff' => 'Brian',
            'no_telp_staff' => '081234567890',
            'foto_staff' => 'default.png'
        ]);

        Staff::create([
            'username' => 'mahen',
            'password' => bcrypt('mahen21'),
            'nama_staff' => 'Mahen',
            'no_telp_staff' => '081234567891',
            'foto_staff' => 'default.png'
        ]);
    }
}
