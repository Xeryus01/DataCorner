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
        if (Schema::hasTable('pengaturan_presensi') && !Schema::hasColumn('pengaturan_presensi', 'wilayah_bps_id')) {
            Schema::table('pengaturan_presensi', function (Blueprint $table) {
                $table->unsignedBigInteger('wilayah_bps_id')->nullable()->index()->after('id');
            });

            if (Schema::hasTable('wilayah_bps')) {
                Schema::table('pengaturan_presensi', function (Blueprint $table) {
                    $table->foreign('wilayah_bps_id')
                          ->references('id')
                          ->on('wilayah_bps')
                          ->nullOnDelete();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pengaturan_presensi') && Schema::hasColumn('pengaturan_presensi', 'wilayah_bps_id')) {
            Schema::table('pengaturan_presensi', function (Blueprint $table) {
                $table->dropForeign(['wilayah_bps_id']);
                $table->dropColumn('wilayah_bps_id');
            });
        }
    }
};
