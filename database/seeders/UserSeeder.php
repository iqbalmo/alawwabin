<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan ini di-import
use Illuminate\Support\Facades\Hash; // Pastikan ini di-import

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat satu user admin yang spesifik
        $adminUser = User::create([
            'name' => 'Admin Al-Awwabin',
            'email' => 'admin@alawwabin.com',
            'password' => Hash::make('password'), // Ganti 'password' dengan password aman Anda
        ]);

        // -----------------------------------------------------------------
        // TAMBAHKAN BARIS INI
        // -----------------------------------------------------------------
        // Berikan peran 'admin' ke user yang baru dibuat.
        // Ini e-require 'RolesAndPermissionsSeeder' sudah dijalankan LEBIH DULU.
        $adminUser->assignRole('admin');
    }
}