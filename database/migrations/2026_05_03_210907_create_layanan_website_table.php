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
        Schema::create('layanan_website', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->integer('active_users')->default(0);
            $table->integer('new_users')->default(0);
            $table->integer('returning_users')->default(0);
            $table->integer('total_users')->default(0);
            $table->integer('sessions')->default(0);
            $table->decimal('bounce_rate', 10, 6)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_website');
    }
};
