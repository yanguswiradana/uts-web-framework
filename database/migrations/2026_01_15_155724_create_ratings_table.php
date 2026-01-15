<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comic_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('stars'); // 1 sampai 5
            $table->timestamps();

            // Satu user hanya boleh rate satu komik (kalau rate lagi, update yg lama)
            $table->unique(['user_id', 'comic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};