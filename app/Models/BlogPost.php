<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];
    use HasFactory;

    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function image(): morphOne
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query): Builder
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query): Builder
    {
        return $query->latest()->withCount('comments')->with('user')->with('tags');
    }

    //to enable deleting related models
    public static function boot(): void
    {
        static::addGlobalScope(new DeletedAdminScope());
        parent::boot();

//        static::addGlobalScope(new LatestScope());

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
            $blogPost->image()->delete();
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });

        static::updating(function (BlogPost $blogPost) {
            Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        });
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }

}
