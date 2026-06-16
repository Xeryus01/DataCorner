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
        Schema::create('soal_kuis_regulers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kuis_reguler');
            $table->string('gambar')->nullable();
            $table->text('soal');
            $table->enum('tipe_soal', ['Pilihan Ganda', 'Isian Singkat']);
            $table->text('jawaban');
            $table->timestamps();
            $table->foreign('id_kuis_reguler')->references('id')->on('kuis_regulers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_kuis_regulers');
    }
};
