<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'chapter_id', 'body', 'parent_id']; // Tambah parent_id

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }

    // Relasi ke Balasan (Anak)
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc'); // Balasan lama di atas
    }
}