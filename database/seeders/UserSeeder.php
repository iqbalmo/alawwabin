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
        // Hapus factory default jika ada
        // \App\Models\User::factory(10)->create();

        // Buat satu user admin yang spesifik
        User::create([
            'name' => 'Admin Al-Awwabin',
            'email' => 'admin@alawwabin.com',
            'password' => Hash::make('password'), // Ganti 'password' dengan password aman Anda jika mau
        ]);

        // Anda bisa tambahkan user lain di sini jika perlu
        // User::create([
        //     'name' => 'User Biasa',
        //     'email' => 'user@alawwabin.com',
        //     'password' => Hash::make('password'),
        // ]);
    }
}