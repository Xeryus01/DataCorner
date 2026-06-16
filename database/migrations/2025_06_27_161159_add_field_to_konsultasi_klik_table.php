<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $table->string('nama')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('email')->nullable();
            $table->string('instansi')->nullable();
            $table->string('keperluan')->nullable();
            $table->text('data_diminta')->nullable();
            $table->text('lainnya')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $table->dropColumn([
                'nama', 'jenis_kelamin', 'email', 'instansi',
                'keperluan', 'data_diminta', 'lainnya'
            ]);
        });
    }
};
