<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; // Baris ini boleh dihapus, sudah tidak dipakai

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Buat data guru contoh
        $guru = Guru::create([
            'nama' => 'Budi Santoso',
            'nip' => '1987654321',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-05-10',
            'jenis_kelamin' => 'L',
            'pend_terakhir_tahun' => '2005',
            'pend_terakhir_univ' => 'Universitas Contoh',
            'pend_terakhir_jurusan' => 'Pendidikan',
            'tahun_mulai_bekerja' => '2006',
            'jabatan' => 'Guru Kelas',
            'status_kepegawaian' => 'PNS',
            'mapel_id' => null,
            'alamat' => 'Jl. Contoh No.1',
            'telepon' => '081234567890',
        ]);

        // Siapkan data user untuk login guru
        $userData = [
            'name' => $guru->nama,
            'email' => 'guru@example.com',
            'password' => Hash::make('password'), // password: password
            'guru_id' => $guru->id, // <-- Ini sudah benar, menghubungkan User ke Guru
        ];

        // -----------------------------------------------------------------
        // HAPUS BLOK IF DI BAWAH INI (LOGIKA LAMA)
        // -----------------------------------------------------------------
        // if (Schema::hasColumn('users', 'role')) {
        //     $userData['role'] = 'guru';
        // }

        // Buat User
        $user = User::create($userData);

        // -----------------------------------------------------------------
        // TAMBAHKAN BARIS INI (LOGIKA BARU RBAC)
        // -----------------------------------------------------------------
        // Berikan peran 'guru' ke user yang baru dibuat
        $user->assignRole('guru');
    }
}