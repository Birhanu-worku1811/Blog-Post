<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'blog_post_id'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function url(): string
    {
        $url = Storage::disk('public')->url($this->path);
        return $url;
    }
}
