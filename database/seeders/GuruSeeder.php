<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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
        ];

        // Jika ada kolom role, isi dengan 'guru'
        if (Schema::hasColumn('users', 'role')) {
            $userData['role'] = 'guru';
        }

        // Jika ada kolom guru_id pada users, isi supaya relasi terhubung
        if (Schema::hasColumn('users', 'guru_id')) {
            $userData['guru_id'] = $guru->id;
        }

        $user = User::create($userData);

        // Jika users tidak punya guru_id tapi ingin relasi one-to-one dari Guru->user,
        // Anda bisa set lewat relasi bila tabel mendukung (contoh safe-check):
        // if (Schema::hasColumn('users', 'guru_id')) {
        //     $user->guru_id = $guru->id;
        //     $user->save();
        // }
    }
}