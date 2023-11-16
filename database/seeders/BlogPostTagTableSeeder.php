<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagCount = Tag::all()->count();

        if (0 === $tagCount) {
            $this->command->info('No tags found, Skipping tags to blogposts');
            return;
        }

        $minimum = (int) $this->command->ask('Minimum tags on one post?', 8);
        $maximun = min((int) $this->command->ask('Maximum tags on one post?', $tagCount), $tagCount);

        BlogPost::all()->each(function (BlogPost $post) use ($maximun, $minimum) {
            $take = random_int($minimum, $maximun);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
            $post->tags()->sync($tags);
        });
    }
}
