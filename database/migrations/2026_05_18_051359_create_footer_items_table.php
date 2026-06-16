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
        Schema::create('footer_items', function (Blueprint $table) {
            $table->id();            
            $table->string('section');            
            $table->string('title');            
            $table->enum('type', ['link', 'pdf', 'image'])->default('link');            
            $table->text('url')->nullable();            
            $table->string('file_path')->nullable();            
            $table->integer('sort_order')->default(0);            
            $table->boolean('is_active')->default(true);            
            $table->boolean('open_new_tab')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_items');
    }
};
