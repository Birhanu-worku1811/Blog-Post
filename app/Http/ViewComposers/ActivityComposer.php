<?php

namespace App\Http\ViewComposers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view): void
    {
        $most_commented = Cache::tags(['blog_post'])->remember('blog-post-most_commented', now()->addSeconds(10),
            function () {
                return BlogPost::mostCommented()->take(5)->get();
            });

        $most_active = Cache::tags(['blog_post'])->remember('users-most_active', now()->addSeconds(10), function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $most_active_last_month = Cache::tags(['blog_post'])->remember('users-most_active_last_month',
            now()->addSeconds(10), function () {
                return User::withMostBlogPostInTheLastMonth()->take(5)->get();
            });

        $view->with('most_commented', $most_commented);
        $view->with('most_active', $most_active);
        $view->with('most_active_last_month', $most_active_last_month);
    }
}
