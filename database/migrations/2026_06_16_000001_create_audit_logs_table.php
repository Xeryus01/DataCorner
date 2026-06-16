<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('admin_nama')->nullable();
            $table->string('admin_role')->nullable();
            $table->string('aksi');           // create, update, delete, verify, reject, login, logout
            $table->string('modul');          // konsultasi, magang, riset, konten-edukasi, kuis, user, admin
            $table->string('deskripsi');
            $table->unsignedBigInteger('data_id')->nullable();
            $table->string('data_tipe')->nullable();  // Model class or table name
            $table->json('data_sebelum')->nullable();
            $table->json('data_sesudah')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['modul', 'aksi']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};