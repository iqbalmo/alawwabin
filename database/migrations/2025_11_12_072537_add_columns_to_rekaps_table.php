<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekaps', function (Blueprint $table) {
            // $table->foreignId('jadwal_id')->nullable()->constrained('jadwals')->onDelete('cascade'); // <-- Beri komentar atau hapus baris ini
            $table->foreignId('siswa_id')->nullable()->constrained('siswas')->onDelete('cascade');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa'])->default('Hadir');
            $table->date('tanggal')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rekaps', function (Blueprint $table) {
            // $table->dropForeign(['jadwal_id']); // <-- Hapus baris ini
            $table->dropForeign(['siswa_id']);
            // Ubah baris dropColumn menjadi ini:
            $table->dropColumn(['siswa_id', 'status', 'tanggal']); // <-- Hapus 'jadwal_id' dari daftar
        });
    }
};
