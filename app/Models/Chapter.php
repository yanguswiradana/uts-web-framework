<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    // Kita pakai guarded id saja biar tidak perlu tulis satu-satu kolomnya
    protected $guarded = ['id'];

    protected $casts = [
        // MAGIC: Mengubah kolom JSON di database menjadi Array PHP otomatis
        'content_images' => 'array', 
    ];

    // Relasi: Chapter milik 1 Komik
    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class)->latest(); // Komen terbaru di atas
}
}