<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            if (!Schema::hasColumn('janjitemu', 'instansi_lembaga')) {
                $table->string('instansi_lembaga')->nullable()->after('users_id');
            }

            if (!Schema::hasColumn('janjitemu', 'keperluan_data')) {
                $table->string('keperluan_data')->nullable()->after('instansi_lembaga');
            }

            if (!Schema::hasColumn('janjitemu', 'data_diminta')) {
                $table->text('data_diminta')->nullable()->after('keperluan_data');
            }

            if (!Schema::hasColumn('janjitemu', 'jumlah_orang')) {
                $table->integer('jumlah_orang')->nullable()->default(1)->after('jam');
            }
        });

        // Agar kolom lama tidak menyebabkan error saat tidak dikirim dari form baru
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `janjitemu` MODIFY `alamat` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `janjitemu` MODIFY `keperluan` VARCHAR(255) NULL");
        }
    }

    public function down(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            if (Schema::hasColumn('janjitemu', 'instansi_lembaga')) {
                $table->dropColumn('instansi_lembaga');
            }

            if (Schema::hasColumn('janjitemu', 'keperluan_data')) {
                $table->dropColumn('keperluan_data');
            }

            if (Schema::hasColumn('janjitemu', 'data_diminta')) {
                $table->dropColumn('data_diminta');
            }

            if (Schema::hasColumn('janjitemu', 'jumlah_orang')) {
                $table->dropColumn('jumlah_orang');
            }
        });
    }
};