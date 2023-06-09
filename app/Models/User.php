<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $deleted = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'profile_image',
        'is_private',
        'type',
        'external_id',
        'external_auth',
        'remenber_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_private' => 'boolean',
    ];

       /**
     * Determine si el usuario es un administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type === 'admin';
    }
    /**
     * Get the posts of the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    
    protected static function boot()
{
    parent::boot();

    static::deleting(function ($user) {
        $user->posts()->delete();
    });
}

    /**
     * Get the followers of the user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    /**
     * Get the users the user follows.
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    /**
     * Check if the user follows another user.
     */
    public function follows(User $user)
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

    /**
     * Follow a user.
     */
    public function follow(User $user)
    {
        $this->followings()->attach($user->id);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user)
    {
        $this->followings()->detach($user->id);
    }

     /**
     * Get the posts that the user has liked.
     */
    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }

    /**
     * Check if the user has liked a post.
     */
    public function hasLiked(Post $post): bool
    {
        return $this->likedPosts()->where('post_id', $post->id)->exists();
    }

    /**
     * Like a post.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    
}
