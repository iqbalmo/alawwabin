<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas_id',
        'nama',
        'nis',
        'tanggal_lahir',
        'no_absen',
        'nisn',
        'nik_siswa',
        'tempat_lahir',
        'jenis_kelamin',
        'no_kk',
        'nama_ayah',
        'ttl_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'ttl_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'anak_ke',
        'jumlah_saudara',
        'sekolah_asal',
        'status_mukim',
        'nama_wali',
        'ttl_wali',
        'alamat_wali',
        'pekerjaan_wali',
        'alamat_orangtua',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kodepos',
        'hp_ayah',
        'hp_ibu',
        'email_ayah',
        'email_ibu',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
    ];

    public function ekstrakurikulers()
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'ekstrakurikuler_siswa');
    }

    // Siswa punya satu kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Siswa punya banyak rekap
    public function rekaps()
    {
        return $this->hasMany(Rekap::class);
    }
}
