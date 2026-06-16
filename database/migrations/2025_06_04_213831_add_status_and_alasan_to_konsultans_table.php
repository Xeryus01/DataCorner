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
            if (! Schema::hasColumn('konsultans', 'status')) {
                $table->string('status')->nullable()->after('nama');
            }
            if (! Schema::hasColumn('konsultans', 'alasan')) {
                $table->text('alasan')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultans', function (Blueprint $table) {
            if (Schema::hasColumn('konsultans', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('konsultans', 'alasan')) {
                $table->dropColumn('alasan');
            }
        });
    }
};
