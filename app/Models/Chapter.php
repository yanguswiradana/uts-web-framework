<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'content_images' => 'array', 
    ];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * ACCESSOR PENTING:
     * Ini yang membuat Admin bisa menghitung jumlah halaman dengan benar
     * meskipun datanya campur-campur (JSON string / Array).
     */
    public function getTotalPagesAttribute()
    {
        $images = $this->content_images;

        if (is_null($images)) return 0;

        // Jika sudah array, hitung langsung
        if (is_array($images)) return count($images);

        // Jika string JSON, decode dulu baru hitung
        if (is_string($images)) {
            $decoded = json_decode($images, true);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            return is_array($decoded) ? count($decoded) : 0;
        }

        return 0;
    }
}