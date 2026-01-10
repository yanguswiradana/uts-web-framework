<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comic;
use App\Models\Chapter;

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Solo Leveling (Manhwa)
        $sl = Comic::create([
            'title' => 'Solo Leveling',
            'slug' => 'solo-leveling',
            'type' => 'Manhwa',
            'status' => 'Finished',
            'cover' => 'https://via.placeholder.com/150x200/581c87/ffffff?text=Solo+Leveling',
        ]);
        // Buat 3 chapter
        Chapter::create(['comic_id' => $sl->id, 'title' => 'Chapter 179', 'slug' => 'ch-179', 'number' => 179]);
        Chapter::create(['comic_id' => $sl->id, 'title' => 'Chapter 180', 'slug' => 'ch-180', 'number' => 180]);

        // 2. One Piece (Manga)
        $op = Comic::create([
            'title' => 'One Piece',
            'slug' => 'one-piece',
            'type' => 'Manga',
            'status' => 'Ongoing',
            'cover' => 'https://via.placeholder.com/150x200/1e40af/ffffff?text=One+Piece',
        ]);
        Chapter::create(['comic_id' => $op->id, 'title' => 'Chapter 1100', 'slug' => 'ch-1100', 'number' => 1100]);
        Chapter::create(['comic_id' => $op->id, 'title' => 'Chapter 1101', 'slug' => 'ch-1101', 'number' => 1101]);

        // 3. Magic Emperor (Manhua)
        $me = Comic::create([
            'title' => 'Magic Emperor',
            'slug' => 'magic-emperor',
            'type' => 'Manhua',
            'status' => 'Ongoing',
            'cover' => 'https://via.placeholder.com/150x200/be185d/ffffff?text=Magic+Emp',
        ]);
        Chapter::create(['comic_id' => $me->id, 'title' => 'Chapter 500', 'slug' => 'ch-500', 'number' => 500]);
    }
}