<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
