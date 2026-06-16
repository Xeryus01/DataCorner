<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas_berprestasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('konsultan_id');
            $table->tinyInteger('triwulan');
            $table->year('tahun');
            $table->integer('nilai')->nullable();
            $table->string('sertifikat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas_berprestasi');
    }
};