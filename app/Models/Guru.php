<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Tambahkan semua kolom baru ke $fillable
    protected $fillable = [
        'nama',
        'nip',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pend_terakhir_tahun',
        'pend_terakhir_univ',
        'pend_terakhir_jurusan',
        'tahun_mulai_bekerja',
        'jabatan',
        'status_kepegawaian',
        'mapel_id',
        'alamat',
        'telepon',
    ];

    // Tambahkan casting untuk 'tanggal_lahir'
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke mata pelajaran yang diampu.
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    /**
     * Relasi ke kelas (jika dia adalah wali kelas).
     */
    public function wali()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas');
    }
}