<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'chapter_id', 'body'];

    // Relasi ke User (Siapa yang komen)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Chapter (Komen di chapter mana)
    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }
}