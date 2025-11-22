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
        'tahun_ajaran_id',
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

    /**
     * Relasi ke Tahun Ajaran.
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    /**
     * Boot method to auto-assign active academic year
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agenda) {
            // If tahun_ajaran_id is not set, use the active academic year
            if (empty($agenda->tahun_ajaran_id)) {
                $activeTahunAjaran = TahunAjaran::getActive();
                if ($activeTahunAjaran) {
                    $agenda->tahun_ajaran_id = $activeTahunAjaran->id;
                }
            }
        });
    }
}