<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            // Hapus kolom lama jika bukan ENUM
            $table->dropColumn('jenis_kelamin');
        });

        Schema::table('konsultasi_klik', function (Blueprint $table) {
            // Tambahkan kolom ENUM baru
            $table->enum('jenis_kelamin', ['pria', 'wanita'])->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });

        Schema::table('konsultasi_klik', function (Blueprint $table) {
            // Kembalikan seperti sebelumnya jika perlu (misalnya string)
            $table->string('jenis_kelamin')->after('nama');
        });
    }
};
