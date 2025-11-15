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
        // Tabel ini akan melacak siswa mana (siswa_id)
        // yang mendaftar di ekskul mana (ekstrakurikuler_id)
        Schema::create('ekstrakurikuler_siswa', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel ekstrakurikulers
            $table->foreignId('ekstrakurikuler_id')
                  ->constrained('ekstrakurikulers')
                  ->onDelete('cascade'); // Jika ekskul dihapus, data ini ikut terhapus
            
            // Foreign key ke tabel siswas
            $table->foreignId('siswa_id')
                  ->constrained('siswas')
                  ->onDelete('cascade'); // Jika siswa dihapus, data ini ikut terhapus

            // Mencegah satu siswa mendaftar di ekskul yang sama dua kali
            $table->unique(['ekstrakurikuler_id', 'siswa_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler_siswa');
    }
};