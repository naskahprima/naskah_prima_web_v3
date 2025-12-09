<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogPostTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        
        $this->category = BlogCategory::create([
            'name' => 'Unit Test Category',
            'slug' => 'unit-test-category',
        ]);
    }

    /** @test */
    public function it_can_create_a_blog_post()
    {
        $post = BlogPost::create([
            'title' => 'Unit Test Post',
            'slug' => 'unit-test-post',
            'content' => 'Test content',
            'excerpt' => 'Test excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertInstanceOf(BlogPost::class, $post);
        $this->assertEquals('Unit Test Post', $post->title);
    }

    /** @test */
    public function it_auto_generates_slug_from_title()
    {
        $post = BlogPost::create([
            'title' => 'Auto Generated Slug Title',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals('auto-generated-slug-title', $post->slug);
    }

    /** @test */
    public function it_calculates_reading_time_for_short_content()
    {
        $post = BlogPost::create([
            'title' => 'Short Content Post',
            'slug' => 'short-content-post',
            'content' => 'Very short',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals(1, $post->reading_time);
    }

    /** @test */
    public function it_calculates_reading_time_for_long_content()
    {
        // 400 words = 2 minutes (200 words/min)
        $content = str_repeat('word ', 400);
        
        $post = BlogPost::create([
            'title' => 'Long Content Post',
            'slug' => 'long-content-post',
            'content' => $content,
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals(2, $post->reading_time);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $post = BlogPost::create([
            'title' => 'Category Relation Test',
            'slug' => 'category-relation-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertInstanceOf(BlogCategory::class, $post->category);
        $this->assertEquals('Unit Test Category', $post->category->name);
    }

    /** @test */
    public function it_belongs_to_an_author()
    {
        $post = BlogPost::create([
            'title' => 'Author Relation Test',
            'slug' => 'author-relation-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertInstanceOf(User::class, $post->author);
        $this->assertEquals($this->admin->id, $post->author->id);
    }

    /** @test */
    public function it_can_attach_tags()
    {
        $tag1 = BlogTag::create(['name' => 'Unit Tag 1', 'slug' => 'unit-tag-1']);
        $tag2 = BlogTag::create(['name' => 'Unit Tag 2', 'slug' => 'unit-tag-2']);

        $post = BlogPost::create([
            'title' => 'Tagged Unit Post',
            'slug' => 'tagged-unit-post',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $post->tags()->attach([$tag1->id, $tag2->id]);

        $this->assertCount(2, $post->tags);
    }

    /** @test */
    public function it_can_change_status()
    {
        $post = BlogPost::create([
            'title' => 'Status Change Test',
            'slug' => 'status-change-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals('draft', $post->status);

        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    /** @test */
    public function it_increments_view_count()
    {
        $post = BlogPost::create([
            'title' => 'View Count Unit Test',
            'slug' => 'view-count-unit-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
            'view_count' => 0,
        ]);

        $post->incrementViewCount();
        $post->refresh();
        $this->assertEquals(1, $post->view_count);

        $post->incrementViewCount();
        $post->refresh();
        $this->assertEquals(2, $post->view_count);
    }

    /** @test */
    public function it_checks_published_status_correctly()
    {
        $publishedPost = BlogPost::create([
            'title' => 'Published Check',
            'slug' => 'published-check',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $draftPost = BlogPost::create([
            'title' => 'Draft Check',
            'slug' => 'draft-check',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertTrue($publishedPost->isPublished());
        $this->assertFalse($draftPost->isPublished());
    }

    /** @test */
    public function it_returns_seo_title()
    {
        $postWithMeta = BlogPost::create([
            'title' => 'Regular Title',
            'slug' => 'seo-title-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
            'meta_title' => 'Custom SEO Title',
        ]);

        $postWithoutMeta = BlogPost::create([
            'title' => 'Only Regular Title',
            'slug' => 'no-seo-title-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals('Custom SEO Title', $postWithMeta->seo_title);
        $this->assertEquals('Only Regular Title', $postWithoutMeta->seo_title);
    }

    /** @test */
    public function it_returns_featured_image_url()
    {
        $postWithImage = BlogPost::create([
            'title' => 'Image URL Test',
            'slug' => 'image-url-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
            'featured_image' => 'blog-images/test.jpg',
        ]);

        $postWithoutImage = BlogPost::create([
            'title' => 'No Image URL Test',
            'slug' => 'no-image-url-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertNotNull($postWithImage->featured_image_url);
        $this->assertStringContainsString('blog-images/test.jpg', $postWithImage->featured_image_url);
        $this->assertNull($postWithoutImage->featured_image_url);
    }
}
