<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    // Relasi: 1 Komik punya BANYAK Chapter
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Relasi: 1 Komik punya BANYAK Genre
    public function genres()
    {
        // 'comic_genre' adalah nama tabel pivot (penghubung)
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }
}