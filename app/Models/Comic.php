<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Jangan lupa import Auth

class Comic extends Model
{
    use HasFactory;

    // Biarkan kosong agar semua kolom bisa diisi
    protected $guarded = ['id'];

    // 1. Relasi ke Genre (Many-to-Many)
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }

    // 2. Relasi ke Chapter (One-to-Many)
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    
    // 3. Relasi ke Semua Rating (untuk menghitung rata-rata)
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // 4. Relasi Spesifik: Rating milik User yang sedang Login (PENTING)
    // Ini yang menyebabkan error "undefined relationship user_rating"
    public function user_rating()
    {
        return $this->hasOne(Rating::class)->where('user_id', Auth::id());
    }
}