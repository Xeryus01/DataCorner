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
        Schema::create('pendaftaran_risets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->string('email');
            $table->string('judul_riset');
            $table->string('no_hp');
            $table->string('cv_file');
            $table->string('surat_permohonan');
            $table->text('surat_motivasi')->nullable();
            $table->boolean('is_agreed')->default(false);
            $table->timestamp('agreed_at')->nullable();
            $table->string('laporan_riset')->nullable();
            $table->string('sertifikat_riset')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['diproses', 'diterima', 'ditolak', 'selesai'])->default('diproses');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_risets');
    }
};
