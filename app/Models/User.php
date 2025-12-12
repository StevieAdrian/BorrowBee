<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'quota',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
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

    public function followedAuthors()
    {
        return $this->belongsToMany(Author::class, 'author_user')->withTimestamps();
    }

    public function isFollowing(Author $author)
    {
        return $this->followedAuthors()->where('author_id', $author->id)->exists();
    }

    public function reviewLikes()
    {
        return $this->hasMany(ReviewLike::class);
    }

    public function reviewDislikes()
    {
        return $this->hasMany(ReviewDislike::class);
    }

    public function followingUser()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'follower_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_followers', 'followed_id', 'follower_id');
    }

    public function isFollowingUser(User $user)
    {
        return $this->followingUser()->where('followed_id', $user->id)->exists();
    }

    public function followersCount()
    {
        return $this->followers()->count();
    }
}
