<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->category = BlogCategory::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    // ==========================================
    // PUBLIC BLOG TESTS
    // ==========================================

    /** @test */
    public function blog_index_page_loads_successfully()
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
    }

    /** @test */
    public function blog_index_shows_published_posts()
    {
        $post = BlogPost::create([
            'title' => 'Unique Test Blog Post XYZ123',
            'slug' => 'unique-test-blog-post-xyz123',
            'content' => 'Test content here',
            'excerpt' => 'Test excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Unique Test Blog Post XYZ123');
    }

    /** @test */
    public function blog_detail_page_loads_successfully()
    {
        $post = BlogPost::create([
            'title' => 'Test Blog Detail Page',
            'slug' => 'test-blog-detail-page-unique',
            'content' => '<p>Full content here for testing</p>',
            'excerpt' => 'Short excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/blog/test-blog-detail-page-unique');

        $response->assertStatus(200);
        $response->assertSee('Test Blog Detail Page');
    }

    /** @test */
    public function blog_detail_increments_view_count()
    {
        $post = BlogPost::create([
            'title' => 'View Count Test Unique',
            'slug' => 'view-count-test-unique-xyz',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
            'view_count' => 0,
        ]);

        $this->get('/blog/view-count-test-unique-xyz');
        
        $post->refresh();
        $this->assertEquals(1, $post->view_count);

        $this->get('/blog/view-count-test-unique-xyz');
        
        $post->refresh();
        $this->assertEquals(2, $post->view_count);
    }

    /** @test */
    public function draft_post_returns_404()
    {
        $post = BlogPost::create([
            'title' => 'Draft Post Unique',
            'slug' => 'draft-post-unique-xyz',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
            'published_at' => null,
        ]);

        $response = $this->get('/blog/draft-post-unique-xyz');

        $response->assertStatus(404);
    }

    // ==========================================
    // BLOG MODEL TESTS
    // ==========================================

    /** @test */
    public function blog_post_auto_generates_slug()
    {
        $post = BlogPost::create([
            'title' => 'Auto Slug Test Title Unique',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals('auto-slug-test-title-unique', $post->slug);
    }

    /** @test */
    public function blog_post_calculates_reading_time()
    {
        // 400 words = 2 minutes (200 words/min)
        $content = str_repeat('word ', 400);

        $post = BlogPost::create([
            'title' => 'Reading Time Test',
            'slug' => 'reading-time-test-unique',
            'content' => $content,
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals(2, $post->reading_time);
    }

    /** @test */
    public function blog_post_minimum_reading_time_is_one()
    {
        $post = BlogPost::create([
            'title' => 'Short Post',
            'slug' => 'short-post-unique',
            'content' => 'Hello world',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertEquals(1, $post->reading_time);
    }

    /** @test */
    public function blog_post_belongs_to_category()
    {
        $post = BlogPost::create([
            'title' => 'Category Test',
            'slug' => 'category-test-unique',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->assertInstanceOf(BlogCategory::class, $post->category);
        $this->assertEquals('Test Category', $post->category->name);
    }

    /** @test */
    public function blog_post_belongs_to_author()
    {
        $post = BlogPost::create([
            'title' => 'Author Test',
            'slug' => 'author-test-unique',
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
    public function blog_post_can_have_tags()
    {
        $tag1 = BlogTag::create(['name' => 'Tag 1', 'slug' => 'tag-1-unique']);
        $tag2 = BlogTag::create(['name' => 'Tag 2', 'slug' => 'tag-2-unique']);

        $post = BlogPost::create([
            'title' => 'Tagged Post',
            'slug' => 'tagged-post-unique',
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
    public function blog_post_can_be_published()
    {
        $post = BlogPost::create([
            'title' => 'Publish Test',
            'slug' => 'publish-test-unique',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    /** @test */
    public function blog_post_scope_published_works()
    {
        // Create published post
        BlogPost::create([
            'title' => 'Published Post Scope Test',
            'slug' => 'published-post-scope-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Create draft post
        BlogPost::create([
            'title' => 'Draft Post Scope Test',
            'slug' => 'draft-post-scope-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        // Only get posts created in this test
        $publishedPosts = BlogPost::published()
            ->where('slug', 'like', '%-scope-test')
            ->get();

        $this->assertCount(1, $publishedPosts);
        $this->assertEquals('Published Post Scope Test', $publishedPosts->first()->title);
    }

    // ==========================================
    // IMAGE AUTO-DELETE TESTS
    // ==========================================

    /** @test */
    public function featured_image_is_deleted_when_post_is_deleted()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test-image.jpg');
        $path = $file->store('blog-images', 'public');

        $post = BlogPost::create([
            'title' => 'Image Delete Test',
            'slug' => 'image-delete-test-unique',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
            'featured_image' => $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $post->delete();

        Storage::disk('public')->assertMissing($path);
    }

    /** @test */
    public function old_image_is_deleted_when_featured_image_is_changed()
    {
        Storage::fake('public');

        $oldFile = UploadedFile::fake()->image('old-image.jpg');
        $oldPath = $oldFile->store('blog-images', 'public');

        $post = BlogPost::create([
            'title' => 'Image Change Test',
            'slug' => 'image-change-test-unique',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
            'featured_image' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        // Change image
        $newFile = UploadedFile::fake()->image('new-image.jpg');
        $newPath = $newFile->store('blog-images', 'public');

        $post->update(['featured_image' => $newPath]);

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
    }
}
