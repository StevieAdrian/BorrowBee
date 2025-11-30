<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'title', 'category_id', 'author_id',
        'title',
        'is_available', 'rating', 'cover_image', 'price', 'description'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
