<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('konsultans', function (Blueprint $table) {
        if (! Schema::hasColumn('konsultans', 'status_updated_at')) {
            $table->timestamp('status_updated_at')->nullable()->after('status');
        }
    });
}

public function down()
{
    Schema::table('konsultans', function (Blueprint $table) {
        if (Schema::hasColumn('konsultans', 'status_updated_at')) {
            $table->dropColumn('status_updated_at');
        }
    });
}

};
