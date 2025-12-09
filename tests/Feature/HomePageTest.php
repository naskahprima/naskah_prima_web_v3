<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function homepage_contains_expected_elements()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Naskah');
        $response->assertSee('Prima');
    }

    /** @test */
    public function homepage_has_whatsapp_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('wa.me');
    }

    /** @test */
    public function homepage_has_blog_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('/blog');
    }
}
