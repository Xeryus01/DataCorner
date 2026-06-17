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
        Schema::table('informasi_risets', function (Blueprint $table) {
            $table->string('judul')->after('id')->nullable();
            $table->string('status')->default('aktif')->after('info_kontak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_risets', function (Blueprint $table) {
            $table->dropColumn('judul');
            $table->dropColumn('status');
        });
    }
};