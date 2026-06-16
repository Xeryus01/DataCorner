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
         Schema::create('presensi_magangs', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto increment (PK)

            $table->unsignedBigInteger('id_pendaftaran_magang')->index();
            $table->date('tanggal')->index();

            $table->time('jam_masuk')->nullable();
            $table->decimal('lat_masuk', 10, 8)->nullable();
            $table->decimal('long_masuk', 11, 8)->nullable();

            $table->time('jam_pulang')->nullable();
            $table->decimal('lat_pulang', 10, 8)->nullable();
            $table->decimal('long_pulang', 11, 8)->nullable();

            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpha'])
                  ->nullable()
                  ->default('Hadir');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_pendaftaran_magang')
                ->references('id')
                ->on('pendaftaran_magangs')
                ->onDelete('cascade');
        });
    }

     

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_magangs');
    }
};
