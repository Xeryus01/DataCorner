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
        Schema::table('janjitemu', function (Blueprint $table) {
            // Cek dulu apakah kolom 'no_hp' ada
            if (Schema::hasColumn('janjitemu', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            // Opsional: tambahkan kembali kolomnya jika di-rollback
            $table->string('no_hp')->nullable();
        });
    }
};
