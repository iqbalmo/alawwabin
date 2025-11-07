<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional, hanya jika tabelnya tidak sesuai konvensi Laravel)
     * Secara default Laravel akan memakai nama 'events'
     */
    protected $table = 'events';

    /**
     * Kolom yang boleh diisi secara mass-assignment (create / update)
     */
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
    ];

    /**
     * Jika kolom tanggal ingin di-cast otomatis menjadi objek Carbon
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];
}
