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
        Schema::create('hasil_kuis_tantangan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kuis_tantangan_bulanan');
            $table->integer('skor')->default(0);
            $table->integer('jawaban_benar');
            $table->integer('jawaban_salah');
            $table->integer('durasi_pengerjaan')->nullable();
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kuis_tantangan_bulanan')->references('id')->on('kuis_tantangan_bulanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_kuis_tantangan_bulanans');
    }
};
