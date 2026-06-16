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

        Schema::create('layanan_produk_statistik', function (Blueprint $table) {

            $table->id();

            $table->string('periode')->unique();

            $table->integer('pemohon_nol_rupiah')->default(0);

            $table->integer('penjualan_data_mikro')->default(0);

            $table->integer('penjualan_peta')->default(0);

            $table->integer('publikasi_elektronik')->default(0);

            $table->integer('jumlah')->default(0);

            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('layanan_produk_statistik');

    }

};