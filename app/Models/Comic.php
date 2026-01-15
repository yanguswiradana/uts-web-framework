<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Chapter
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Relasi ke Genre
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }

    // --- TAMBAHAN BARU: RELASI RATING ---
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    
    // Relasi untuk mengecek rating user tertentu (User login)
    public function user_rating()
    {
        return $this->hasOne(Rating::class)->where('user_id', auth()->id());
    }
}