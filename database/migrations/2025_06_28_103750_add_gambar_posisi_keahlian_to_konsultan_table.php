<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('konsultans', function (Blueprint $table) {
        if (! Schema::hasColumn('konsultans', 'gambar')) {
            $table->string('gambar')->after('nama');
        }
        if (! Schema::hasColumn('konsultans', 'posisi')) {
            $table->string('posisi')->after('gambar');
        }
        if (! Schema::hasColumn('konsultans', 'keahlian')) {
            $table->string('keahlian')->after('posisi');
        }
    });
}

public function down(): void
{
    Schema::table('konsultans', function (Blueprint $table) {
        $table->dropColumn(['gambar', 'posisi', 'keahlian']);
    });
}

};
