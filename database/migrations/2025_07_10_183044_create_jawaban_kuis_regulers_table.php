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
        Schema::create('jawaban_kuis_regulers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hasil_kuis_reguler');
            $table->unsignedBigInteger('id_soal_kuis_reguler');
            $table->text('jawaban_user');
            $table->boolean('benar');
            $table->foreign('id_hasil_kuis_reguler')->references('id')->on('hasil_kuis_regulers')->onDelete('cascade');
            $table->foreign('id_soal_kuis_reguler')->references('id')->on('soal_kuis_regulers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_kuis_regulers');
    }
};
