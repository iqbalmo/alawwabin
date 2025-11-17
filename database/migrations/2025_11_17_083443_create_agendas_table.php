<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel ini akan menyimpan setiap entri agenda yang diisi oleh guru
        // (menggantikan fungsionalitas 'Rekap' yang lama)
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke jadwal (Mata pelajaran apa, di kelas apa)
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            
            // Relasi ke user (Guru mana yang mengisi)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->date('tanggal'); // Tanggal pertemuan
            $table->text('materi_diajarkan')->nullable(); // Materi yang dicatat guru
            $table->json('absensi_siswa')->nullable(); // JSON untuk menyimpan { "siswa_id": "status", ... }
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};