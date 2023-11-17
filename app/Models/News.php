<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Variabel agar column-column dari table bisa diinput
    protected $fillable = ['title', 'author', 'description', 'content', 'url', 'url_image', 'published_at', 'category'];

    // Relasi dari tables News kepada table User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}