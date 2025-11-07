<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = ['nama', 'nip', 'mapel_id', 'telepon'];

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
        return $this->hasMany(Mapel::class, 'guru_id');
    }
}
