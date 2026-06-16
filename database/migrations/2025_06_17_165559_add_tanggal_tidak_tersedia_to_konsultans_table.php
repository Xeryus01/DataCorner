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
        Schema::table('konsultans', function (Blueprint $table) {
            if (! Schema::hasColumn('konsultans', 'tanggal_mulai_tidak_tersedia')) {
                $table->date('tanggal_mulai_tidak_tersedia')->nullable();
            }
            if (! Schema::hasColumn('konsultans', 'tanggal_selesai_tidak_tersedia')) {
                $table->date('tanggal_selesai_tidak_tersedia')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultans', function (Blueprint $table) {
            if (Schema::hasColumn('konsultans', 'tanggal_mulai_tidak_tersedia')) {
                $table->dropColumn('tanggal_mulai_tidak_tersedia');
            }
            if (Schema::hasColumn('konsultans', 'tanggal_selesai_tidak_tersedia')) {
                $table->dropColumn('tanggal_selesai_tidak_tersedia');
            }
        });
    }
};
