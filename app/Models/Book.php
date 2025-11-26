<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = [
        'title', 'category_id', 'author_id',
        'is_available', 'rating', 'cover_image', 'price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
