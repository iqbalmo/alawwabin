<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_tingkat_to_kelas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Tambahkan kolom tingkat (misal: tipe string atau integer)
            // 'nama_kelas' diasumsikan sudah ada dari migrasi sebelumnya
            $table->string('tingkat', 5)->after('id'); // Menyimpan '10', '11', '12'
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('tingkat');
        });
    }
};
