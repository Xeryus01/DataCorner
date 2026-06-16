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
        Schema::create('survei_layanan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->text('link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_layanan');
    }
};
