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
        Schema::table('mapels', function (Blueprint $table) {
            // 🚨 Mengubah kolom agar bisa bernilai NULL (opsional)
            $table->foreignId('guru_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            // Mengembalikan kolom menjadi tidak nullable jika migrasi di-rollback
            $table->foreignId('guru_id')->nullable(false)->change();
        });
    }
};