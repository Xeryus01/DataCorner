<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('petugas_harian', function (Blueprint $table) {
            // Hapus unique index yang ada pada kolom 'tanggal'
            // Nama index biasanya 'petugas_harian_tanggal_unique'
            $table->dropUnique('petugas_harian_tanggal_unique');

            // Tambahkan unique index pada kombinasi 'tanggal' dan 'konsultan_id'
            $table->unique(['tanggal', 'konsultan_id']);
        });
    }

    public function down(): void
    {
        Schema::table('petugas_harian', function (Blueprint $table) {
            $table->dropUnique(['tanggal', 'konsultan_id']);
            // Kembalikan unique index pada 'tanggal' jika memang diperlukan
            $table->unique('tanggal');
        });
    }
};
