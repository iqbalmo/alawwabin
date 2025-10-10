<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    
     protected $fillable = [
        'nama_mapel',
        'deskripsi',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
