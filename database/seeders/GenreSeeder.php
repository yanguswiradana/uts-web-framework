<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            // --- DEMOGRAFI ---
            'Shounen',      // Remaja Laki-laki
            'Shoujo',       // Remaja Perempuan
            'Seinen',       // Dewasa Laki-laki
            'Josei',        // Dewasa Perempuan
            'Kids',         // Anak-anak

            // --- GENRE UTAMA ---
            'Action',
            'Adventure',
            'Comedy',
            'Drama',
            'Fantasy',
            'Slice of Life', // Kehidupan Sehari-hari
            'Horror',
            'Mystery',
            'Psychological',
            'Romance',
            'Sci-Fi',       // Science Fiction

            // --- TEMA & SUB-GENRE POPULER ---
            'Isekai',       // Dunia Lain (Sangat Populer)
            'School Life',  // Kehidupan Sekolah
            'Supernatural', // Supranatural
            'Magic',        // Sihir
            'Martial Arts', // Bela Diri (Silat/Kungfu)
            'Sports',       // Olahraga
            'Mecha',        // Robot
            'Music',        // Musik
            'Military',     // Militer
            'Police',       // Kepolisian
            'Historical',   // Sejarah / Kerajaan masa lalu
            'Harem',        // 1 Cowok banyak Cewek
            'Reverse Harem',// 1 Cewek banyak Cowok
            'Ecchi',        // Dewasa ringan (Fan service)
            
            // --- TEMA SPESIFIK MANHWA/MANHUA ---
            'Murim',        // Dunia Persilatan (Khas Manhwa)
            'Cultivation',  // Kultivasi Dewa (Khas Manhua)
            'System',       // Sistem Game di Dunia Nyata
            'Reincarnation',// Reinkarnasi
            'Time Travel',  // Perjalanan Waktu
            'Revenge',      // Balas Dendam
            'Royalty',      // Kerajaan / Bangsawan
            'Office Workers',// Pekerja Kantoran

            // --- LAINNYA ---
            'Post-Apocalyptic',
            'Game',
            'Demons',
            'Vampire',
            'Ghosts',
            'Monster',
            'Thriller',
            'Tragedy',
            'Survival',
            'Cyberpunk',
            'Space',
            'Gore',         // Aksi Brutal
            'Webtoon',      // Format Webtoon
            '4-Koma',       // Komik 4 Panel
        ];

        foreach ($genres as $name) {
            // Gunakan firstOrCreate untuk mencegah duplikat saat seeding ulang
            Genre::firstOrCreate(
                ['slug' => Str::slug($name)], // Cek berdasarkan slug
                ['name' => $name]             // Jika tidak ada, buat baru dengan nama ini
            );
        }
    }
}