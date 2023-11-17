<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function blog_posts(): HasMany
    {
        return $this->hasMany('App\Models\BlogPost');
    }

    public function comments(): HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function commentsOn(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }


    public function image(): morphOne
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeWithMostBlogPosts(Builder $query): Builder
    {
        return $query->withCount('blog_posts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeWithMostBlogPostInTheLastMonth(Builder $query): Builder
    {
        return $query->withCount([
            'blog_posts' => function (Builder $query) {
                $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
            }
        ])->has('blog_posts', '>=', 2)
            ->orderBy('blog_posts_count', 'desc');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post)
    {
        $query->whereHas('comments', function ($query) use ($post) {
            return $query->where('commentable_id', '=', $post->id)
                ->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeThatIsAdmin(Builder $query)
    {
        return $query->where('is_admin', '=', true);
    }
}
