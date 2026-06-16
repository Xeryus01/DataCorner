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
        Schema::create('opsi_soal_kuis_regulers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_soal_kuis_reguler');
            $table->string('label');
            $table->text('teks_opsi');
            $table->timestamps();
            $table->foreign('id_soal_kuis_reguler')->references('id')->on('soal_kuis_regulers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_soal_kuis_regulers');
    }
};
