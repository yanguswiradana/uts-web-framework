<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Anime (Induk)
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->string('studio')->nullable();
            $table->string('status')->default('Ongoing');
            $table->year('release_year');
            $table->timestamps();
        });

        // 2. Tabel Episodes (Anak - Ini yang error tadi)
        Schema::create('anime_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->integer('episode_number');
            $table->string('youtube_link');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anime_episodes');
        Schema::dropIfExists('animes');
    }
};