<?php

namespace App\Observers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruObserver
{
    /**
     * Dijalankan SETELAH Guru berhasil dibuat.
     */
    public function created(Guru $guru): void
    {
        // Hanya buat user jika NIP diisi
        if (!empty($guru->nip)) {
            $user = User::create([
                'name' => $guru->nama,
                'email' => $guru->nip, // Menggunakan NIP sebagai 'email' untuk login
                'password' => Hash::make($guru->nip), // Menggunakan NIP sebagai password default
                'guru_id' => $guru->id, // Tautkan User ke Guru
            ]);

            // Berikan peran dasar 'guru'
            $user->assignRole('guru');

            // Jika guru ini juga ditugaskan sebagai Wali Kelas, tambahkan peran
            if ($guru->wali()->exists()) {
                $user->assignRole('wali_kelas');
            }
        }
    }

    /**
     * Dijalankan SETELAH Guru berhasil diperbarui.
     */
    public function updated(Guru $guru): void
    {
        // Temukan User yang tertaut
        $user = User::where('guru_id', $guru->id)->first();

        if ($user) {
            // Update data User agar sinkron dengan data Guru
            $user->name = $guru->nama;
            $user->email = $guru->nip; // Update NIP/email login

            // Cek jika NIP diubah, reset passwordnya ke NIP yang baru
            if ($guru->isDirty('nip')) {
                $user->password = Hash::make($guru->nip);
            }

            // Cek status Wali Kelas
            if ($guru->wali()->exists()) {
                $user->assignRole('wali_kelas');
            } else {
                $user->removeRole('wali_kelas');
            }

            $user->save();
        } 
        // Jika user-nya tidak ada (misal NIP baru ditambahkan), buat baru
        elseif (!empty($guru->nip)) {
             $this->created($guru);
        }
    }

    /**
     * Dijalankan SEBELUM Guru dihapus.
     */
    public function deleting(Guru $guru): void
    {
        // Hapus juga akun User yang tertaut
        $user = User::where('guru_id', $guru->id)->first();
        if ($user) {
            $user->delete();
        }
    }
}