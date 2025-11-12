<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->nullable()->after('password');
            }

            if (! Schema::hasColumn('users', 'guru_id')) {
                $table->unsignedBigInteger('guru_id')->nullable()->after('role');

                if (Schema::hasTable('gurus')) {
                    $table->foreign('guru_id')->references('id')->on('gurus')->onDelete('set null')->onUpdate('cascade');
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'guru_id')) {
                // coba drop foreign key dengan nama standar, jika error akan di-ignore
                try {
                    $table->dropForeign(['guru_id']);
                } catch (\Throwable $e) {
                    // ignore
                }
                $table->dropColumn('guru_id');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};