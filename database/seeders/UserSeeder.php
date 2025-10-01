<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'brian',
            'password' => bcrypt('123admin456')

        ]);

        User::create([
            'username' => 'mahen',
            'password' => bcrypt('mahen21')
            ]);
    }
}
