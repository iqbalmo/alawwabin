<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'nip',
        'nama',
        'mapel_id',
        'alamat',
        'telepon',
        'gaji_pokok'
    ];

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
        return $this->hasMany(Mapel::class, 'guru_id');
    }
}
