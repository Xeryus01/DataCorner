<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name')) $table->string('name')->nullable()->after('nama');
            if (!Schema::hasColumn('users', 'jenis_kelamin')) $table->string('jenis_kelamin')->nullable()->after('no_hp');
            if (!Schema::hasColumn('users', 'instansi')) $table->string('instansi')->nullable()->after('jenis_kelamin');
            if (!Schema::hasColumn('users', 'foto')) $table->string('foto')->nullable()->after('instansi');
            if (!Schema::hasColumn('users', 'otp_code')) $table->string('otp_code')->nullable()->after('password');
            if (!Schema::hasColumn('users', 'otp_expires_at')) $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            if (!Schema::hasColumn('users', 'is_verified')) $table->boolean('is_verified')->default(false)->after('otp_expires_at');
            if (!Schema::hasColumn('users', 'pending_email')) $table->string('pending_email')->nullable()->after('is_verified');
            if (!Schema::hasColumn('users', 'email_verified_at')) $table->timestamp('email_verified_at')->nullable()->after('email');
        });
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'username')) $table->string('username')->nullable()->unique()->after('nama');
            if (!Schema::hasColumn('admins', 'remember_token')) $table->rememberToken();
            if (!Schema::hasColumn('admins', 'wilayah_bps_id')) $table->foreignId('wilayah_bps_id')->nullable()->after('password');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['name','jenis_kelamin','instansi','foto','otp_code','otp_expires_at','is_verified','pending_email','email_verified_at'] as $column) {
                if (Schema::hasColumn('users', $column)) $table->dropColumn($column);
            }
        });
        Schema::table('admins', function (Blueprint $table) {
            foreach (['username','remember_token','wilayah_bps_id'] as $column) {
                if (Schema::hasColumn('admins', $column)) $table->dropColumn($column);
            }
        });
    }
};
