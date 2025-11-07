<?php

// app/Models/Gaji.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['tanggal_bayar' => 'date'];

    public function guru() {
        return $this->belongsTo(Guru::class);
    }
}
