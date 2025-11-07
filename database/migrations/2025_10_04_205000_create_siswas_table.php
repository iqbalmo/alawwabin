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
        // Hapus tabel jika sudah ada, untuk memastikan migrate:fresh berjalan lancar
        Schema::dropIfExists('siswas');

        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            
            // Kolom Asli yang dipertahankan
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('nama'); // Dari 'Nama Lengkap'
            $table->string('nis')->unique(); // Dari 'NIS LOKAL'
            $table->date('tanggal_lahir')->nullable(); // Dari 'Tanggal Lahir'

            // Kolom Baru dari Excel
            $table->integer('no_absen')->nullable();
            $table->string('nisn')->unique()->nullable();
            $table->string('nik_siswa')->unique()->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            
            // Data Keluarga
            $table->string('no_kk')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('ttl_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('ttl_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();

            // Data Kesiswaan
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->string('status_mukim')->nullable(); // (MUKIM / NON MUKIM)

            // Data Wali (Jika ada)
            $table->string('nama_wali')->nullable();
            $table->string('ttl_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();

            // Alamat & Kontak
            $table->text('alamat_orangtua')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('hp_ayah')->nullable();
            $table->string('hp_ibu')->nullable();
            $table->string('email_ayah')->nullable();
            $table->string('email_ibu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};