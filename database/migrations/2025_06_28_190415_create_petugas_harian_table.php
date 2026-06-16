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
    Schema::create('petugas_harian', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('konsultan_id');
        $table->date('tanggal')->unique();
        $table->timestamps();

        $table->foreign('konsultan_id')->references('id')->on('konsultans')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas_harian');
    }
};
