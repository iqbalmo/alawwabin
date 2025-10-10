<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kelas','wali_kelas'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
    public function waliGuru()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas');
    }   
}
