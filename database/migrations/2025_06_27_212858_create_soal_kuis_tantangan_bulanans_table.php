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
        Schema::create('soal_kuis_tantangan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kuis_tantangan_bulanan');
            $table->string('gambar')->nullable();
            $table->text('soal');
            $table->enum('tipe_soal', ['Pilihan Ganda', 'Isian Singkat']);
            $table->text('jawaban');
            $table->timestamps();
            $table->foreign('id_kuis_tantangan_bulanan')->references('id')->on('kuis_tantangan_bulanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_kuis_tantangan_bulanans');
    }
};
