<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kelas',
        'wali_kelas', // 🚨 DIPERBAIKI: Diubah dari 'guru_id' menjadi 'wali_kelas'
        'tingkat',
    ];

    /**
     * Mendefinisikan relasi "satu kelas memiliki banyak siswa".
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * 🚨 DIPERBAIKI: Mendefinisikan relasi "satu kelas memiliki satu wali kelas (guru)".
     * Nama metode diubah dari 'waliGuru' menjadi 'wali' agar cocok dengan pemanggilan
     * with('wali') di controller.
     */
    public function wali()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'id');
    }
}