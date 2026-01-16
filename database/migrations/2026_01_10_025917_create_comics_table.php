<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('comics', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->string('author'); // Pastikan author ada
        
        // TAMBAHKAN INI:
        $table->year('release_year')->nullable(); 
        
        $table->text('description');
        $table->string('cover');
        $table->enum('type', ['Manga', 'Manhwa', 'Manhua']);
        $table->enum('status', ['Ongoing', 'Completed']);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};