<?php

// database/migrations/..._create_keuangans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['Operasional', 'Gaji']); // Jenis pengeluaran
            $table->string('deskripsi');                     // Keterangan (e.g., "Bayar Listrik", "Gaji Budi")
            $table->decimal('jumlah', 15, 2);                // Jumlah pengeluaran (angka besar)
            $table->date('tanggal_transaksi');               // Tanggal pengeluaran
            // $table->foreignId('guru_id')->nullable()->constrained('gurus'); // Opsional: jika ingin link ke guru
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};