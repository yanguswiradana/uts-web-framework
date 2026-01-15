<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder-seeder Anda di sini.
        // Urutan eksekusi: Atas -> Bawah
        
        $this->call([
            // 1. Buat User Admin dulu
            AdminSeeder::class, 

            // 2. Buat Data Genre (Master Data biasanya didahulukan)
            GenreSeeder::class,

            // 3. Buat Data Komik (Karena biasanya Komik butuh ID Genre)
            ComicSeeder::class,
        ]);
    }
}