<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username'     => 'ali',
            'password'     => Hash::make('rahasia123'),
            'nama_lengkap' => 'Ali Darmono',
        ]);

        User::create([
            'username'     => 'siti',
            'password'     => Hash::make('siti456'),
            'nama_lengkap' => 'Siti Rope\'ah',
        ]);
    }
}
