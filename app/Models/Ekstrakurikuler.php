<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ekskul',
        'deskripsi',
        'guru_id', // ID Pembina
    ];

    /**
     * Relasi ke Guru (Pembina).
     */
    public function pembina()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * --- TAMBAHKAN FUNGSI INI ---
     * Relasi Many-to-Many ke Siswa.
     */
    public function siswas()
    {
        // 'ekstrakurikuler_siswa' adalah nama tabel pivot yang kita buat
        return $this->belongsToMany(Siswa::class, 'ekstrakurikuler_siswa');
    }
}