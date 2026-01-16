<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeEpisode extends Model
{
    protected $guarded = ['id'];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    // Accessor: Mengambil ID Video dari Link Youtube
    // Contoh Link: https://www.youtube.com/watch?v=dQw4w9WgXcQ
    // Hasil: dQw4w9WgXcQ
    public function getYoutubeIdAttribute()
    {
        $link = $this->youtube_link;
        
        // Pola Regex untuk menangkap ID Youtube
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        
        if (preg_match($pattern, $link, $match)) {
            return $match[1];
        }
        return null; // Jika link invalid
    }
}