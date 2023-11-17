<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    public function blog_posts(): MorphToMany
    {
//        return $this->belongsToMany('App\Models\BlogPost')->withTimestamps();
        return $this->morphedByMany('App\Models\BlogPost', 'taggable')->withTimestamps();
    }
}
