<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gelar',
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

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    /**
     * Relasi Many-to-Many dengan Mapel
     * Satu guru bisa mengajar banyak mata pelajaran
     */
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel')
                    ->withTimestamps();
    }

    public function wali()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas');
    }

    // Relasi ke User
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Relasi ke GuruLog
    public function guruLogs()
    {
        return $this->hasMany(GuruLog::class);
    }
}