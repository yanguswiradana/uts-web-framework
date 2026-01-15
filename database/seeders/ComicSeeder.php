<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre; // Jangan lupa import ini

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Ambil dulu data Genre yang sudah dibuat di GenreSeeder
        // Kita butuh ID-nya untuk ditempel ke komik
        $action = Genre::where('slug', 'action')->first();
        $fantasy = Genre::where('slug', 'fantasy')->first();
        $adventure = Genre::where('slug', 'adventure')->first();
        $martial = Genre::where('slug', 'martial-arts')->first();

        // ==========================================
        // 1. Solo Leveling (Manhwa)
        // ==========================================
        $sl = Comic::create([
            'title' => 'Solo Leveling',
            'slug' => 'solo-leveling',
            'type' => 'Manhwa',
            'status' => 'Finished',
            'cover' => 'https://via.placeholder.com/150x200/581c87/ffffff?text=Solo+Leveling',
        ]);

        // Attach Genre (Action & Fantasy)
        if ($sl && $action && $fantasy) {
            $sl->genres()->attach([$action->id, $fantasy->id]);
        }

        // Buat Chapter
        Chapter::create(['comic_id' => $sl->id, 'title' => 'Chapter 179', 'slug' => 'ch-179', 'number' => 179]);
        Chapter::create(['comic_id' => $sl->id, 'title' => 'Chapter 180', 'slug' => 'ch-180', 'number' => 180]);


        // ==========================================
        // 2. One Piece (Manga)
        // ==========================================
        $op = Comic::create([
            'title' => 'One Piece',
            'slug' => 'one-piece',
            'type' => 'Manga',
            'status' => 'Ongoing',
            'cover' => 'https://via.placeholder.com/150x200/1e40af/ffffff?text=One+Piece',
        ]);

        // Attach Genre (Action & Adventure & Fantasy)
        if ($op && $action && $adventure && $fantasy) {
            $op->genres()->attach([$action->id, $adventure->id, $fantasy->id]);
        }

        // Buat Chapter
        Chapter::create(['comic_id' => $op->id, 'title' => 'Chapter 1100', 'slug' => 'ch-1100', 'number' => 1100]);
        Chapter::create(['comic_id' => $op->id, 'title' => 'Chapter 1101', 'slug' => 'ch-1101', 'number' => 1101]);


        // ==========================================
        // 3. Magic Emperor (Manhua)
        // ==========================================
        $me = Comic::create([
            'title' => 'Magic Emperor',
            'slug' => 'magic-emperor',
            'type' => 'Manhua',
            'status' => 'Ongoing',
            'cover' => 'https://via.placeholder.com/150x200/be185d/ffffff?text=Magic+Emp',
        ]);

        // Attach Genre (Action, Fantasy, Martial Arts)
        if ($me && $action && $fantasy && $martial) {
            $me->genres()->attach([$action->id, $fantasy->id, $martial->id]);
        }

        // Buat Chapter
        Chapter::create(['comic_id' => $me->id, 'title' => 'Chapter 500', 'slug' => 'ch-500', 'number' => 500]);
    }
}