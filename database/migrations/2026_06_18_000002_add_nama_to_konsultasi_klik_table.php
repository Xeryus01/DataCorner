<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            if (! Schema::hasColumn('konsultasi_klik', 'nama')) {
                $table->string('nama')->nullable()->after('users_id');
            }
            if (! Schema::hasColumn('konsultasi_klik', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('jenis_kelamin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi_klik', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('konsultasi_klik', 'nama')) {
                $columns[] = 'nama';
            }
            if (Schema::hasColumn('konsultasi_klik', 'no_hp')) {
                $columns[] = 'no_hp';
            }
            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};