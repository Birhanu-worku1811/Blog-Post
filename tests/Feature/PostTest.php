<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_no_blog_posts(): void
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No posts found');
        $response->assertStatus(200);
    }

    public function test_See_one_post_without_comments()
    {
        // Arrange
        $post = $this->create_dummy_blogpost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('new title');
        $response->assertSeeText('no comments yet');

    }

    public function test_See_one_post_with_comments()
    {

        $user = $this->user();

        $post = $this->create_dummy_blogpost();
        Comment::factory()->count(5)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Models\BlogPost',
            'user_id' => $user->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('5 comments');
    }

    public function test_store_post()
    {
        $params = [
            'title' => 'valid title',
            'content' => 'valid content'
        ];

        $this->actingAs($this->user())->post('/posts', $params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals('the blog post was created!', session('status'));
    }

    public function test_post_store_failure()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())->post('/posts', $params)->assertStatus(302)->assertSessionHas('errors');
        $messages = session('errors')->getMessages();

        $this->assertEquals('The title field must be at least 5 characters.', $messages['title'][0]);
        $this->assertEquals('The content field must be at least 10 characters.', $messages['content'][0]);
    }

//
    public function test_update_post()
    {
        $user = $this->user();
        $post = $this->create_dummy_blogpost($user->id);

//        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'updated title',
            'content' => 'updated content',
            'updated_at' => now(),
            'created_at' => now(),
        ];

        $this->actingAs($user)->PUT("/posts/{$post->id}",
            $params)->assertStatus(302)->assertSessionHas('status');

        $this->assertEquals('Blog post updated', session('status'));
        $this->actingAs($this->user())->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    public function test_delete()
    {
        $user = $this->user();
        $post = $this->create_dummy_blogpost($user->id);
//        $this->assertDatabaseHas('blog_posts', ['title' => "new title"]);
        $this->actingAs($user)->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals('Blog Post delete successfully!', session('status'));
//        $this->actingAs($this->user())->assertDatabaseMissing('blog_posts', $post->toArray());
//        $this->actingAs($this->user())->assertSoftDeleted('blog_posts', $post->toArray());


    }

    private function create_dummy_blogpost($userId = null): BlogPost
    {
//        $post = new BlogPost();
//        $post->title = "new title";
//        $post->content = "New content";
//        $post->save();
//        return $post;

        return BlogPost::factory()
            ->state(['title' => 'new title'])
            ->create([
                'user_id' => $userId ?? $this->user()->id
            ]);
    }
}
