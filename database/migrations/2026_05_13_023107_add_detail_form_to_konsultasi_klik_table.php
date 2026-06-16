<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable()->after('instansi');
            $table->text('keperluan_data')->nullable()->after('data_diminta');
            $table->enum('memiliki_akun', ['ya', 'tidak'])->nullable()->after('keperluan_data');
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'keperluan_data',
                'memiliki_akun',
            ]);
        });
    }
};