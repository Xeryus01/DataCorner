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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('janjitemu_id');
            $table->unsignedBigInteger('konsultan_id');
            $table->timestamps();

            $table->foreign('janjitemu_id')->references('id')->on('janjitemu')->onDelete('cascade');
            $table->foreign('konsultan_id')->references('id')->on('konsultans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
