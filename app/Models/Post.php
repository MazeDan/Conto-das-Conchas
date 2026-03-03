<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

protected $fillable = [
    'user_id',
    'title',
    'slug',
    'content',
    'cover_image',
    'published',
    'published_at',
];
}
