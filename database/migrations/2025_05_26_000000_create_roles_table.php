<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Catatan Integrasi
|--------------------------------------------------------------------------
| Student Corner memakai Spatie Permission yang juga membuat tabel `roles`.
| Migration ini dipertahankan untuk kompatibilitas Datapedia lama, tetapi
| tidak membuat tabel ulang jika tabel `roles` sudah dibuat oleh Spatie.
*/
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('guard_name')->default('web');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Tidak drop tabel roles karena dipakai bersama oleh Datapedia dan Spatie Permission.
    }
};
