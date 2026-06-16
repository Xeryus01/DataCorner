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
    Schema::table('konsultasi_klik', function (Blueprint $table) {
        $table->string('nama')->nullable(false)->change();
        $table->string('jenis_kelamin')->nullable(false)->change();
        $table->string('email')->nullable(false)->change();
        $table->string('instansi')->nullable(false)->change();
        $table->string('keperluan')->nullable(false)->change();
        $table->text('data_diminta')->nullable(false)->change();
        $table->text('lainnya')->nullable()->change(); // tetap boleh null
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            //
        });
    }
};
