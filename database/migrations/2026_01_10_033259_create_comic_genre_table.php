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
    Schema::create('comic_genre', function (Blueprint $table) {
        // Kunci Tamu 1: ID Komik
        $table->foreignId('comic_id')->constrained()->onDelete('cascade');
        
        // Kunci Tamu 2: ID Genre
        $table->foreignId('genre_id')->constrained()->onDelete('cascade');
        
        // Mencegah duplikat (Komik A tidak bisa punya genre Action 2 kali)
        $table->primary(['comic_id', 'genre_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comic_genre');
    }
};
