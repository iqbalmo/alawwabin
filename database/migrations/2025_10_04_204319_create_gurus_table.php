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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable()->unique();
            
            // Atribut baru: Data Pribadi
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            
            // Atribut baru: Pendidikan
            $table->string('pend_terakhir_tahun', 4)->nullable();
            $table->string('pend_terakhir_univ')->nullable();
            $table->string('pend_terakhir_jurusan')->nullable();
            
            // Atribut baru: Kepegawaian
            $table->string('tahun_mulai_bekerja', 4)->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('status_kepegawaian', ['PNS', 'Swasta'])->nullable();

            // Atribut lama yang dipertahankan
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('set null');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable(); // Saya tambahkan 'telepon' karena ini penting

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};