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
        Schema::create('kuis_tantangan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_periode');
            $table->string('judul');
            $table->text('deskripsi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_menit')->default(15);
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif');
            $table->string('slug');
            $table->timestamps();
            $table->foreign('id_periode')->references('id')->on('periodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis_tantangan_bulanans');
    }
};
