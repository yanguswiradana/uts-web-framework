<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;

    // Biarkan kosong agar semua kolom bisa diisi
    protected $guarded = ['id'];

    // Relasi ke Genre (PENTING)
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }

    // Relasi ke Chapter
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    
    // Relasi ke Rating
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}