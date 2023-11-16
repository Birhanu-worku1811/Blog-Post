<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ($this->command->confirm('Do you want to refresh the db?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refresh!');
        }
        Cache::tags('blog-post')->flush();

        $this->call(UsersTableSeeder::class);
        $this->call(BlogPostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(BlogPostTagTableSeeder::class);

    }
}











