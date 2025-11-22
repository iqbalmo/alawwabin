<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use HasFactory, SoftDeletes;

    
     protected $fillable = [
        'nama_mapel',
        'deskripsi',
    ];

    /**
     * Relasi Many-to-Many dengan Guru
     * Satu mata pelajaran bisa diajar oleh banyak guru
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel')
                    ->withTimestamps();
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
