<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/..._create_gajis_table.php
    public function up(): void
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->decimal('jumlah_dibayar', 15, 2);
            $table->date('tanggal_bayar')->nullable();
            $table->enum('status', ['Belum Dibayar', 'Sudah Dibayar'])->default('Belum Dibayar');
            $table->timestamps();

            // Agar tidak ada duplikat gaji untuk guru di bulan/tahun yang sama
            $table->unique(['guru_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
