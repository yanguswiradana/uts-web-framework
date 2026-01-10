<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // contoh: solo-leveling
            $table->string('cover')->nullable(); // URL gambar
            $table->string('author')->nullable();
            $table->enum('type', ['Manga', 'Manhwa', 'Manhua'])->default('Manga');
            $table->enum('status', ['Ongoing', 'Finished', 'Hiatus'])->default('Ongoing');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};