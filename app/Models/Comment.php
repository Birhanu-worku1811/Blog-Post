<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, Taggable;
    use HasFactory;

    protected $fillable = ['content', 'user_id'];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot(): void
    {
        static::addGlobalScope(new LatestScope());
        parent::boot();


//        static::creating(function (Comment $comment) {
//            if ($comment->commentable_type === BlogPost::class) {
//                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
//                Cache::tags(['blog-post'])->forget('most_commented');
//            }
//        });


    }

}
