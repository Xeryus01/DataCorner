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
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $table->enum('posisi', [
                'asn',
                'karyawan_swasta',
                'wiraswasta',
                'peneliti',
                'pelajar_mahasiswa',
                'lainnya',
            ])->after('data_diminta'); // Posisi setelah kolom data_diminta

            // 2. Hapus kolom-kolom yang tidak diperlukan lagi
            $table->dropColumn(['nama', 'jenis_kelamin', 'email', 'keperluan', 'lainnya']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            //
        });
    }
};
