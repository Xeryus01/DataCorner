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
        Schema::create('detail_sub_judul_artikels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_judul_artikel_id');
            $table->text('konten_text');
            $table->text('link_embed')->nullable();
            $table->integer('urutan');
            $table->foreign('sub_judul_artikel_id')->references('id')->on('sub_judul_artikels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_sub_judul_artikels');
    }
};
