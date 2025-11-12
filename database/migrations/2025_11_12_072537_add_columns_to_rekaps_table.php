<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekaps', function (Blueprint $table) {
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwals')->onDelete('cascade');
            $table->foreignId('siswa_id')->nullable()->constrained('siswas')->onDelete('cascade');
            $table->enum('status', ['Hadir','Izin','Sakit','Alpa'])->default('Hadir');
            $table->date('tanggal')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rekaps', function (Blueprint $table) {
            $table->dropForeign(['jadwal_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['jadwal_id', 'siswa_id', 'status', 'tanggal']);
        });
    }
};
