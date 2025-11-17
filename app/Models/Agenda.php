<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'user_id',
        'tanggal',
        'materi_diajarkan',
        'absensi_siswa',
    ];

    /**
     * Atribut yang harus di-cast.
     *
     * @var array
     */
    protected $casts = [
        'absensi_siswa' => 'array', // Otomatis konversi JSON ke Array & sebaliknya
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke Jadwal.
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    /**
     * Relasi ke User (Guru yang mengisi).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}