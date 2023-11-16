<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = BlogPost::all();
        $users = User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->info('There are no Blog posts or users so no comments');
            return;
        }

        $commentsCount = (int) $this->command->ask('how many comments do you want?', 150);


        Comment::factory()->count($commentsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\Models\BlogPost';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        Comment::factory()->count($commentsCount)->make()->each(function ($comment) use ($users) {
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\Models\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
