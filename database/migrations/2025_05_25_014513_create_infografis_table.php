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
        Schema::create('infografis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subjek_materi_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->string('file_infografis');
            $table->timestamps();
            $table->foreign('subjek_materi_id')->references('id')->on('subjek_materis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infografis');
    }
};
