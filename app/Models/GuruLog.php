<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruLog extends Model
{
    use HasFactory;

    protected $table = 'guru_logs';

    protected $fillable = [
        'user_id',
        'guru_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'kehadiran',
        'kegiatan',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}