<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'wali_kelas', 
        'tingkat',
    ];

    // Satu kelas punya banyak siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi ke wali kelas (guru)
    public function wali()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'id');
    }

    // Kelas punya banyak jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
