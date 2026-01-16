<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Support\Str; // Pastikan import Str ada

class ComicSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Ambil dulu data Genre
        $action = Genre::where('slug', 'action')->first();
        $fantasy = Genre::where('slug', 'fantasy')->first();
        $adventure = Genre::where('slug', 'adventure')->first();
        $martial = Genre::where('slug', 'martial-arts')->first();
        $isekai = Genre::where('slug', 'isekai')->first();

        // Dummy Images JSON
        $dummyImages = json_encode([
            'https://via.placeholder.com/800x1200/171717/ffffff?text=Page+1',
            'https://via.placeholder.com/800x1200/171717/ffffff?text=Page+2',
            'https://via.placeholder.com/800x1200/171717/ffffff?text=Page+3',
        ]);

        // ==========================================
        // 1. Solo Leveling (Manhwa)
        // ==========================================
        $sl = Comic::create([
            'title'        => 'Solo Leveling',
            'slug'         => 'solo-leveling',
            'author'       => 'Chugong',
            'release_year' => 2018,
            'description'  => '10 tahun yang lalu, setelah "Gerbang" yang menghubungkan dunia nyata dengan dunia monster terbuka, beberapa orang biasa menerima kekuatan untuk berburu monster. Sung Jin-Woo memburu monster di Gerbang tingkat rendah untuk membayar tagihan rumah sakit ibunya.',
            'type'         => 'Manhwa',
            'status'       => 'Completed',
            'cover'        => 'https://upload.wikimedia.org/wikipedia/en/9/9c/Solo_Leveling_Webtoon.png',
        ]);

        if ($sl) {
            $genres = collect([$action, $fantasy])->filter()->pluck('id');
            $sl->genres()->attach($genres);
        }

        // FIX: Tambahkan 'slug' di sini
        Chapter::create([
            'comic_id' => $sl->id, 
            'title' => 'Epilog Akhir', 
            'slug' => Str::slug('Epilog Akhir'), // <-- WAJIB ADA
            'number' => 179, 
            'content_images' => $dummyImages
        ]);
        
        Chapter::create([
            'comic_id' => $sl->id, 
            'title' => 'Side Story 1', 
            'slug' => Str::slug('Side Story 1'), // <-- WAJIB ADA
            'number' => 180, 
            'content_images' => $dummyImages
        ]);


        // ==========================================
        // 2. One Piece (Manga)
        // ==========================================
        $op = Comic::create([
            'title'        => 'One Piece',
            'slug'         => 'one-piece',
            'author'       => 'Eiichiro Oda',
            'release_year' => 1997,
            'description'  => 'Gol D. Roger dikenal sebagai "Raja Bajak Laut". Kata-kata terakhirnya sebelum kematiannya mengungkapkan keberadaan harta karun terbesar di dunia, One Piece.',
            'type'         => 'Manga',
            'status'       => 'Ongoing',
            'cover'        => 'https://upload.wikimedia.org/wikipedia/en/9/90/One_Piece%2C_Volume_61_Cover_%28Japanese%29.jpg',
        ]);

        if ($op) {
            $genres = collect([$action, $adventure, $fantasy])->filter()->pluck('id');
            $op->genres()->attach($genres);
        }

        Chapter::create([
            'comic_id' => $op->id, 
            'title' => 'Egghead Island', 
            'slug' => Str::slug('Egghead Island'), // <-- WAJIB ADA
            'number' => 1100, 
            'content_images' => $dummyImages
        ]);
        
        Chapter::create([
            'comic_id' => $op->id, 
            'title' => 'Kuma Past', 
            'slug' => Str::slug('Kuma Past'), // <-- WAJIB ADA
            'number' => 1101, 
            'content_images' => $dummyImages
        ]);


        // ==========================================
        // 3. Magic Emperor (Manhua)
        // ==========================================
        $me = Comic::create([
            'title'        => 'Magic Emperor',
            'slug'         => 'magic-emperor',
            'author'       => 'Wuer Manhua',
            'release_year' => 2019,
            'description'  => 'Zhuo Yifan adalah Kaisar Iblis. Dia dikhianati dan dibunuh, lalu jiwanya merasuk ke tubuh pelayan keluarga Luo bernama Zhuo Fan.',
            'type'         => 'Manhua',
            'status'       => 'Ongoing',
            'cover'        => 'https://i.pinimg.com/736x/8a/a5/d6/8aa5d6174df751593c66289b724599df.jpg',
        ]);

        if ($me) {
            $genres = collect([$action, $fantasy, $martial, $isekai])->filter()->pluck('id');
            $me->genres()->attach($genres);
        }

        Chapter::create([
            'comic_id' => $me->id, 
            'title' => 'Return of Demon', 
            'slug' => Str::slug('Return of Demon'), // <-- WAJIB ADA
            'number' => 500, 
            'content_images' => $dummyImages
        ]);
    }
}