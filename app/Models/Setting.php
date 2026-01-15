<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Agar kolom 'key' dan 'value' bisa diisi
    protected $fillable = ['key', 'value'];
}