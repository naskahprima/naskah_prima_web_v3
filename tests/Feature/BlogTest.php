<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected BlogCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        
        $this->category = BlogCategory::create([
            'name' => 'Tips Publikasi',
            'slug' => 'tips-publikasi',
            'is_active' => true,
            'order' => 1,
        ]);

        // Create default settings
        Setting::create([
            'key' => 'site_name',
            'value' => 'Naskah Prima',
            'group' => 'general',
            'type' => 'text',
        ]);

        Setting::create([
            'key' => 'whatsapp_number',
            'value' => '6281234567890',
            'group' => 'contact',
            'type' => 'text',
        ]);
    }

    /** @test */
    public function blog_index_page_returns_200()
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
    }

    /** @test */
    public function blog_index_shows_published_posts()
    {
        $post = BlogPost::create([
            'title' => 'Test Published Post',
            'slug' => 'test-published-post',
            'content' => 'This is test content.',
            'user_id' => $this->user->id,
            'blog_category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Test Published Post');
    }

    /** @test */
    public function blog_index_does_not_show_draft_posts()
    {
        $post = BlogPost::create([
            'title' => 'Draft Post Should Not Show',
            'slug' => 'draft-post',
            'content' => 'This is draft content.',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertDontSee('Draft Post Should Not Show');
    }

    /** @test */
    public function blog_single_post_page_returns_200()
    {
        $post = BlogPost::create([
            'title' => 'Single Post Test',
            'slug' => 'single-post-test',
            'content' => 'This is the content of single post.',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/blog/single-post-test');

        $response->assertStatus(200);
        $response->assertSee('Single Post Test');
        $response->assertSee('This is the content of single post.');
    }

    /** @test */
    public function blog_single_post_returns_404_for_draft()
    {
        $post = BlogPost::create([
            'title' => 'Draft Not Accessible',
            'slug' => 'draft-not-accessible',
            'content' => 'Draft content.',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $response = $this->get('/blog/draft-not-accessible');

        $response->assertStatus(404);
    }

    /** @test */
    public function blog_category_page_returns_200()
    {
        $post = BlogPost::create([
            'title' => 'Category Post',
            'slug' => 'category-post',
            'content' => 'Category content.',
            'user_id' => $this->user->id,
            'blog_category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/blog/category/tips-publikasi');

        $response->assertStatus(200);
        $response->assertSee('Category Post');
    }

    /** @test */
    public function blog_tag_page_returns_200()
    {
        $tag = BlogTag::create([
            'name' => 'SINTA',
            'slug' => 'sinta',
        ]);

        $post = BlogPost::create([
            'title' => 'Tagged Post',
            'slug' => 'tagged-post',
            'content' => 'Tagged content.',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $post->tags()->attach($tag->id);

        $response = $this->get('/blog/tag/sinta');

        $response->assertStatus(200);
        $response->assertSee('Tagged Post');
    }

    /** @test */
    public function blog_search_returns_matching_posts()
    {
        BlogPost::create([
            'title' => 'Machine Learning Article',
            'slug' => 'machine-learning-article',
            'content' => 'This article is about machine learning.',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        BlogPost::create([
            'title' => 'IoT Article',
            'slug' => 'iot-article',
            'content' => 'This article is about IoT.',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/blog?q=machine');

        $response->assertStatus(200);
        $response->assertSee('Machine Learning Article');
        $response->assertDontSee('IoT Article');
    }

    /** @test */
    public function blog_search_searches_in_content()
    {
        BlogPost::create([
            'title' => 'Generic Title',
            'slug' => 'generic-title',
            'content' => 'This content contains the keyword SINTA publication.',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/blog?q=SINTA');

        $response->assertStatus(200);
        $response->assertSee('Generic Title');
    }

    /** @test */
    public function blog_single_post_increments_view_count()
    {
        $post = BlogPost::create([
            'title' => 'View Count Test',
            'slug' => 'view-count-test',
            'content' => 'Content for view count test.',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
            'view_count' => 0,
        ]);

        $this->assertEquals(0, $post->view_count);

        $this->get('/blog/view-count-test');

        $this->assertEquals(1, $post->fresh()->view_count);
    }

    /** @test */
    public function blog_pagination_works()
    {
        // Create 12 posts (more than 9 per page)
        for ($i = 1; $i <= 12; $i++) {
            BlogPost::create([
                'title' => "Post Number $i",
                'slug' => "post-number-$i",
                'content' => "Content for post $i.",
                'user_id' => $this->user->id,
                'status' => 'published',
                'published_at' => now()->subDays($i),
            ]);
        }

        $response = $this->get('/blog');
        $response->assertStatus(200);

        $response2 = $this->get('/blog?page=2');
        $response2->assertStatus(200);
    }
}
