<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- PERUBAHAN ADA DI SINI (Sekarang role bisa diisi)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: User menyimpan banyak Komik
    public function bookmarks()
    {
        return $this->belongsToMany(Comic::class, 'bookmarks', 'user_id', 'comic_id')->withTimestamps();
    }
    
    // Helper: Cek apakah user sudah bookmark komik tertentu?
    public function hasBookmarked($comicId)
    {
        return $this->bookmarks()->where('comic_id', $comicId)->exists();
    }
}