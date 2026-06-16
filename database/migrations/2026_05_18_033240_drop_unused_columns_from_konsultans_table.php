<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultans', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('konsultans', 'keahlian')) {
                $columns[] = 'keahlian';
            }
            if (Schema::hasColumn('konsultans', 'alasan')) {
                $columns[] = 'alasan';
            }
            if (Schema::hasColumn('konsultans', 'tanggal_mulai_tidak_tersedia')) {
                $columns[] = 'tanggal_mulai_tidak_tersedia';
            }
            if (Schema::hasColumn('konsultans', 'tanggal_selesai_tidak_tersedia')) {
                $columns[] = 'tanggal_selesai_tidak_tersedia';
            }
            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }

    public function down(): void
    {
        Schema::table('konsultans', function (Blueprint $table) {
            if (! Schema::hasColumn('konsultans', 'keahlian')) {
                $table->string('keahlian')->nullable()->after('posisi');
            }
            if (! Schema::hasColumn('konsultans', 'alasan')) {
                $table->text('alasan')->nullable()->after('status_updated_at');
            }
            if (! Schema::hasColumn('konsultans', 'tanggal_mulai_tidak_tersedia')) {
                $table->date('tanggal_mulai_tidak_tersedia')->nullable()->after('updated_at');
            }
            if (! Schema::hasColumn('konsultans', 'tanggal_selesai_tidak_tersedia')) {
                $table->date('tanggal_selesai_tidak_tersedia')->nullable()->after('tanggal_mulai_tidak_tersedia');
            }
        });
    }
};