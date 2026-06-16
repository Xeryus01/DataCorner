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
        if (!Schema::hasTable('pengaturan_presensi')) {
            Schema::create('pengaturan_presensi', function (Blueprint $table) {
                $table->id(); // bigint unsigned auto increment (Primary Key)

                $table->unsignedBigInteger('wilayah_bps_id')->nullable()->index();
                $table->decimal('lat_kantor', 10, 8)->nullable();
                $table->decimal('long_kantor', 11, 8)->nullable();

                $table->integer('radius_kantor')->default(100);

                $table->time('jam_masuk_mulai');
                $table->time('jam_masuk_selesai')->nullable();
                $table->time('jam_pulang_mulai')->nullable();

                $table->integer('toleransi_telat')->default(0);

                $table->boolean('is_active')->default(1);

                $table->timestamps(); // created_at & updated_at

                $table->foreign('wilayah_bps_id')
                      ->references('id')
                      ->on('wilayah_bps')
                      ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_presensi');
    }
};
