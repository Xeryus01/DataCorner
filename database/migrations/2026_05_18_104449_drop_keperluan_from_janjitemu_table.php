<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            if (Schema::hasColumn('janjitemu', 'keperluan')) {
                $table->dropColumn('keperluan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('janjitemu', function (Blueprint $table) {
            if (!Schema::hasColumn('janjitemu', 'keperluan')) {
                $table->string('keperluan')->nullable()->after('alamat');
            }
        });
    }
};