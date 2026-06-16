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
        Schema::create('jawaban_tantangan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hasil_tantangan_bulanan');
            $table->unsignedBigInteger('id_soal_tantangan_bulanan');
            $table->text('jawaban_user');
            $table->boolean('benar');
            $table->foreign('id_hasil_tantangan_bulanan')->references('id')->on('hasil_kuis_tantangan_bulanans')->onDelete('cascade');
            $table->foreign('id_soal_tantangan_bulanan')->references('id')->on('soal_kuis_tantangan_bulanans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_tantangan_bulanans');
    }
};
