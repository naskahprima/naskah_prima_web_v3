<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogPostTest extends TestCase
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
        ]);
    }

    /** @test */
    public function blog_post_can_be_created()
    {
        $post = BlogPost::create([
            'title' => 'Cara Publikasi Jurnal SINTA',
            'slug' => 'cara-publikasi-jurnal-sinta',
            'content' => 'Ini adalah konten artikel tentang cara publikasi jurnal SINTA.',
            'user_id' => $this->user->id,
            'blog_category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Cara Publikasi Jurnal SINTA',
            'status' => 'published',
        ]);
    }

    /** @test */
    public function blog_post_slug_is_auto_generated()
    {
        $post = BlogPost::create([
            'title' => 'Auto Generated Slug Test',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $this->assertEquals('auto-generated-slug-test', $post->slug);
    }

    /** @test */
    public function blog_post_reading_time_is_auto_calculated()
    {
        // 400 words = 2 minutes (200 words per minute)
        $content = str_repeat('word ', 400);
        
        $post = BlogPost::create([
            'title' => 'Reading Time Test',
            'content' => $content,
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $this->assertEquals(2, $post->reading_time);
    }

    /** @test */
    public function blog_post_belongs_to_category()
    {
        $post = BlogPost::create([
            'title' => 'Category Test',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'blog_category_id' => $this->category->id,
            'status' => 'draft',
        ]);

        $this->assertEquals($this->category->id, $post->category->id);
        $this->assertEquals('Tips Publikasi', $post->category->name);
    }

    /** @test */
    public function blog_post_belongs_to_author()
    {
        $post = BlogPost::create([
            'title' => 'Author Test',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $this->assertEquals($this->user->id, $post->author->id);
    }

    /** @test */
    public function blog_post_can_have_tags()
    {
        $tag1 = BlogTag::create(['name' => 'SINTA', 'slug' => 'sinta']);
        $tag2 = BlogTag::create(['name' => 'Jurnal', 'slug' => 'jurnal']);

        $post = BlogPost::create([
            'title' => 'Tags Test',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $post->tags()->attach([$tag1->id, $tag2->id]);

        $this->assertCount(2, $post->tags);
        $this->assertTrue($post->tags->contains($tag1));
        $this->assertTrue($post->tags->contains($tag2));
    }

    /** @test */
    public function blog_post_scope_published_works()
    {
        // Create published post
        BlogPost::create([
            'title' => 'Published Post',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        // Create draft post
        BlogPost::create([
            'title' => 'Draft Post',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        // Create scheduled post (future)
        BlogPost::create([
            'title' => 'Scheduled Post',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        $publishedPosts = BlogPost::published()->get();

        $this->assertCount(1, $publishedPosts);
        $this->assertEquals('Published Post', $publishedPosts->first()->title);
    }

    /** @test */
    public function blog_post_seo_title_returns_meta_title_or_title()
    {
        $postWithMeta = BlogPost::create([
            'title' => 'Original Title',
            'meta_title' => 'SEO Optimized Title',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $postWithoutMeta = BlogPost::create([
            'title' => 'Only Title',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $this->assertEquals('SEO Optimized Title', $postWithMeta->seo_title);
        $this->assertEquals('Only Title', $postWithoutMeta->seo_title);
    }

    /** @test */
    public function blog_post_view_count_can_be_incremented()
    {
        $post = BlogPost::create([
            'title' => 'View Count Test',
            'content' => 'Test content',
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now(),
            'view_count' => 0,
        ]);

        $this->assertEquals(0, $post->view_count);

        $post->incrementViewCount();

        $this->assertEquals(1, $post->fresh()->view_count);
    }
}
