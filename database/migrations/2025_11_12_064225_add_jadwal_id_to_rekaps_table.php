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
        Schema::table('rekaps', function (Blueprint $table) {
        $table->unsignedBigInteger('jadwal_id'); // ini kolom baru yang tadinya nggak ada
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('rekaps', function (Blueprint $table) {
        $table->dropColumn('jadwal_id');
    });
    }
};
