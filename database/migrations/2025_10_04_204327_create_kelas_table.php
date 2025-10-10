<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->unsignedBigInteger('wali_kelas')->nullable(); // guru yg jadi wali
            $table->timestamps();

            $table->foreign('wali_kelas')->references('id')->on('guru')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
