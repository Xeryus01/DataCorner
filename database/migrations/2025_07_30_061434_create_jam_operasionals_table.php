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
        Schema::create('jam_operasionals', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan_hari'); // Contoh: "Senin - Kamis", "Jumat"
            $table->time('jam_mulai');       // Contoh: 08:00:00
            $table->time('jam_selesai');     // Contoh: 16:00:00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_operasionals');
    }
};
