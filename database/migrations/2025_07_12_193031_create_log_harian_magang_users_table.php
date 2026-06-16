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
        Schema::create('log_harian_magang_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pendaftaran_magang');
            $table->date('tanggal');
            $table->text('uraian_kegiatan');
            $table->enum('status_kehadiran', ['hadir', 'sakit', 'izin']);
            $table->text('catatan')->nullable();
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
            $table->foreign('id_pendaftaran_magang')->references('id')->on('pendaftaran_magangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_harian_magang_users');
    }
};
