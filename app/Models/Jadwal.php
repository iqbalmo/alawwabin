<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Relasi ke mata pelajaran
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Jadwal punya banyak rekap
    public function rekaps()
    {
        return $this->hasMany(Rekap::class);
    }
}
