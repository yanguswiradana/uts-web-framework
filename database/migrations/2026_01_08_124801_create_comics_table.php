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
        Schema::create('comics', function (Blueprint $table) {
        $table->id();
        $table->string('title');          // Judul Komik
        $table->string('slug')->unique(); // Untuk URL (contoh: one-piece)
        $table->string('author')->nullable();
        $table->string('image_path');     // Lokasi file gambar
        $table->text('description')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
