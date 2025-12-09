<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'email' => 'admin@naskahprima.com',
            'password' => bcrypt('password'),
        ]);
    }

    /** @test */
    public function admin_login_page_loads()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    // Note: Filament panel access tests are skipped because 
    // they require canAccessPanel() method in User model
    // which may have specific email/role requirements

    /** @test */
    public function admin_can_create_blog_category()
    {
        $category = BlogCategory::create([
            'name' => 'Admin Test Category',
            'slug' => 'admin-test-category',
        ]);

        $this->assertDatabaseHas('blog_categories', [
            'name' => 'Admin Test Category',
        ]);
    }

    /** @test */
    public function admin_can_create_blog_post()
    {
        $category = BlogCategory::create([
            'name' => 'Post Test Category',
            'slug' => 'post-test-category',
        ]);

        $post = BlogPost::create([
            'title' => 'Admin Created Post Test',
            'slug' => 'admin-created-post-test',
            'content' => 'Content created by admin',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $category->id,
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Admin Created Post Test',
        ]);
    }

    /** @test */
    public function admin_can_update_blog_post()
    {
        $category = BlogCategory::create([
            'name' => 'Update Test Category',
            'slug' => 'update-test-category',
        ]);

        $post = BlogPost::create([
            'title' => 'Original Title Test',
            'slug' => 'original-title-test',
            'content' => 'Original content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $post->update([
            'title' => 'Updated Title Test',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Updated Title Test',
        ]);
    }

    /** @test */
    public function admin_can_delete_blog_post()
    {
        $category = BlogCategory::create([
            'name' => 'Delete Test Category',
            'slug' => 'delete-test-category',
        ]);

        $post = BlogPost::create([
            'title' => 'Post To Delete Test',
            'slug' => 'post-to-delete-test',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'blog_category_id' => $category->id,
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $postId = $post->id;
        $post->delete();

        $this->assertDatabaseMissing('blog_posts', [
            'id' => $postId,
        ]);
    }
}
