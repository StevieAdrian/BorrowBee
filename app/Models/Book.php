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
        'is_available', 'rating', 'cover_image', 'price', 'description', 'pdf_file'
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

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getCoverUrlAttribute()
    {
        $assetPath = public_path('assets/books/' . $this->cover_image);

        if (file_exists($assetPath)) {
            return asset('assets/books/' . $this->cover_image);
        }

        return asset('storage/' . $this->cover_image);
    }

}
