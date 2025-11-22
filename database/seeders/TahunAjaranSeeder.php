<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the current academic year (2024/2025) as active
        TahunAjaran::create([
            'nama' => '2024/2025',
            'tanggal_mulai' => '2024-07-01',
            'tanggal_selesai' => '2025-06-30',
            'is_active' => true,
        ]);

        // You can add more academic years here if needed
        // TahunAjaran::create([
        //     'nama' => '2025/2026',
        //     'tanggal_mulai' => '2025-07-01',
        //     'tanggal_selesai' => '2026-06-30',
        //     'is_active' => false,
        // ]);
    }
}
