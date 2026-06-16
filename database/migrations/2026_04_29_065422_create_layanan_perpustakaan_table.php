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
        Schema::create('layanan_perpustakaan', function (Blueprint $table) {
            $table->id();

            $table->string('periode');

            $table->integer('pengunjung_unik')->default(0);

            $table->integer('kunjungan')->default(0);

            $table->integer('rata_harian')->default(0);

            $table->integer('layanan_tercetak')->default(0);

            $table->integer('digilib_online')->default(0);

            $table->integer('jumlah')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_perpustakaan');
    }
};
