<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus factory default
        // User::factory(10)->create();

        // Panggil UserSeeder yang sudah kita buat
        $this->call([
            UserSeeder::class,
            GuruSeeder::class,
            // Anda bisa tambahkan seeder lain di sini nanti
            // Contoh: KelasSeeder::class, MapelSeeder::class,
        ]);
    }
}