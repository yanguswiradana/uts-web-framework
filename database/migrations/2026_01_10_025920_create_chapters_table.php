<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comic_id')->constrained('comics')->onDelete('cascade');
            $table->string('title'); // contoh: Chapter 1
            $table->string('slug');  // contoh: chapter-1
            $table->integer('number'); // untuk sorting (1, 2, 3)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};