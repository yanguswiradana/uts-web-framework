<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\Comic;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     // 1. Buat Genre
        $action = Genre::create(['name' => 'Action', 'slug' => 'action']);
        $fantasy = Genre::create(['name' => 'Fantasy', 'slug' => 'fantasy']);
        $drama = Genre::create(['name' => 'Drama', 'slug' => 'drama']);

        // 2. Hubungkan ke Komik (Attach)
        $soloLeveling = Comic::where('slug', 'solo-leveling')->first();
        if($soloLeveling) {
            // Solo leveling genrenya Action & Fantasy
            $soloLeveling->genres()->attach([$action->id, $fantasy->id]);
        }

        $onePiece = Comic::where('slug', 'one-piece')->first();
        if($onePiece) {
            // One Piece genrenya Action, Fantasy, Drama
            $onePiece->genres()->attach([$action->id, $fantasy->id, $drama->id]);
        }
    }
}
