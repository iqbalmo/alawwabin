<?php

// app/Models/Keuangan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Izinkan mass assignment

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_transaksi' => 'date', // Otomatis ubah ke objek Carbon
        'jumlah' => 'decimal:2',       // Pastikan format desimal benar
    ];

    // Opsional: Relasi jika Anda menambahkan guru_id
    // public function guru()
    // {
    //     return $this->belongsTo(Guru::class);
    // }
}
