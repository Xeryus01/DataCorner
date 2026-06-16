<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('layanan_konsultasi', function (Blueprint $table) {
            $table->id();
            $table->string('periode'); // format: YYYY-MM
            $table->integer('konsultasi_online')->default(0);
            $table->integer('kunjungan_langsung')->default(0);
            $table->integer('datapedia')->default(0);
            $table->integer('surat')->default(0);
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_konsultasis');
    }
};
