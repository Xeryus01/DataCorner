<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            // Ubah kolom tanggal dan jam menjadi nullable
            $table->date('tanggal')->nullable()->change();
            $table->time('jam')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            // Kembalikan seperti semula jika di-rollback
            $table->date('tanggal')->nullable(false)->change();
            $table->time('jam')->nullable(false)->change();
        });
    }
};
