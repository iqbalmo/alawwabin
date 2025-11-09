<?php
// NAMA FILE: database/migrations/2025_11_10_010203_add_guru_id_to_mapels_table.php

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
        Schema::table('mapels', function (Blueprint $table) {
            // Tambahkan kolom guru_id (sebagai Penanggung Jawab)
            // 'after' id agar rapi.
            $table->foreignId('guru_id')
                  ->nullable()
                  ->after('id') 
                  ->constrained('gurus') // Merujuk ke tabel gurus
                  ->onDelete('set null'); // Jika guru dihapus, set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['guru_id']);
            // Hapus kolomnya
            $table->dropColumn('guru_id');
        });
    }
};