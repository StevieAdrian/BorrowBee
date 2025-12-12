<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'rating',
        'book_id',
        'user_id'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function dislikes()
    {
        return $this->hasMany(ReviewDislike::class);
    }

    public function dislikedBy(User $user)
    {
        return $this->dislikes()->where('user_id', $user->id)->exists();
    }

}
