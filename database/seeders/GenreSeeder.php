<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan firstOrCreate agar aman dijalankan berulang
        Genre::firstOrCreate(['slug' => 'action'], ['name' => 'Action']);
        Genre::firstOrCreate(['slug' => 'fantasy'], ['name' => 'Fantasy']);
        Genre::firstOrCreate(['slug' => 'adventure'], ['name' => 'Adventure']);
        Genre::firstOrCreate(['slug' => 'drama'], ['name' => 'Drama']);
        Genre::firstOrCreate(['slug' => 'supernatural'], ['name' => 'Supernatural']);
        Genre::firstOrCreate(['slug' => 'martial-arts'], ['name' => 'Martial Arts']);
    }
}