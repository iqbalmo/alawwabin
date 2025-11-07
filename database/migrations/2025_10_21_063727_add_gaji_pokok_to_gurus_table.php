<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/..._add_gaji_pokok_to_gurus_table.php
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->decimal('gaji_pokok', 15, 2)->default(0)->after('telepon'); // Sesuaikan posisi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            //
        });
    }
};
