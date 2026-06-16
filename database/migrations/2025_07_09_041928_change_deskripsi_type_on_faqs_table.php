<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('faqs', function (Blueprint $table) {
        $table->text('deskripsi')->change(); // atau longText() jika kontennya sangat panjang
    });
}

public function down()
{
    Schema::table('faqs', function (Blueprint $table) {
        $table->string('deskripsi')->change(); // rollback ke string jika dibutuhkan
    });
}

};
