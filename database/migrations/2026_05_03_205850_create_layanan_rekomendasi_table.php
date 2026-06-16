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
        Schema::create('layanan_rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->string('periode')->unique();
            $table->integer('survei')->default(0);
            $table->integer('kompromin')->default(0);
            $table->integer('opd')->default(0);
            $table->integer('instansi')->default(0);
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_rekomendasi');
    }
};
