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
        Schema::create('konsultans', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('password');

            // Optional profile/contact fields
            $table->string('no_hp')->nullable();
            $table->string('gambar')->nullable(); // legacy name used in views
            $table->string('image')->nullable(); // alternate column used in some controllers/views
            $table->string('posisi')->nullable();
            $table->string('keahlian')->nullable();

            // Status and metadata
            $table->string('status')->nullable();
            $table->text('alasan')->nullable();
            $table->timestamp('status_updated_at')->nullable();

            // Unavailability dates
            $table->date('tanggal_mulai_tidak_tersedia')->nullable();
            $table->date('tanggal_selesai_tidak_tersedia')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultans');
    }
};
