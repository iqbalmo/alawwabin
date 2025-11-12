<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('rekaps', function (Blueprint $table) {
            $table->string('catatan')->nullable()->after('status');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('rekaps', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
