<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void {
        Schema::table('janjitemu', function (Blueprint $table) {
            if (! Schema::hasColumn('janjitemu', 'status')) {
                $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'batal'])->default('menunggu');
            }
        });
    }

    public function down(): void {
        Schema::table('janjitemu', function (Blueprint $table) {
            if (Schema::hasColumn('janjitemu', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
