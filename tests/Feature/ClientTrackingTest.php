<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_be_created()
    {
        $client = Client::create([
            'nama_lengkap' => 'Test Client Unique',
            'email' => 'testunique@example.com',
            'no_whatsapp' => '081234567890',
            'institusi' => 'Universitas Test',
        ]);

        $this->assertDatabaseHas('clients', [
            'nama_lengkap' => 'Test Client Unique',
            'email' => 'testunique@example.com',
        ]);
    }

    /** @test */
    public function client_auto_generates_tracking_token()
    {
        $client = Client::create([
            'nama_lengkap' => 'Token Test Unique',
            'email' => 'tokenunique@test.com',
            'no_whatsapp' => '081234567891',
        ]);

        $this->assertNotNull($client->tracking_token);
        $this->assertEquals(32, strlen($client->tracking_token));
    }

    /** @test */
    public function client_has_tracking_url_attribute()
    {
        $client = Client::create([
            'nama_lengkap' => 'URL Test Unique',
            'email' => 'urlunique@test.com',
            'no_whatsapp' => '081234567892',
        ]);

        $this->assertStringContainsString('/tracking/', $client->tracking_url);
        $this->assertStringContainsString($client->tracking_token, $client->tracking_url);
    }

    /** @test */
    public function client_has_whatsapp_tracking_url()
    {
        $client = Client::create([
            'nama_lengkap' => 'WA Test Unique',
            'email' => 'waunique@test.com',
            'no_whatsapp' => '081234567893',
        ]);

        $waUrl = $client->whatsapp_tracking_url;

        $this->assertStringContainsString('wa.me', $waUrl);
        $this->assertStringContainsString('6281234567893', $waUrl);
    }

    /** @test */
    public function client_can_mark_tracking_viewed()
    {
        $client = Client::create([
            'nama_lengkap' => 'View Test Unique',
            'email' => 'viewunique@test.com',
            'no_whatsapp' => '081234567894',
        ]);

        $this->assertNull($client->tracking_last_viewed);

        $client->markTrackingViewed();
        $client->refresh();

        $this->assertNotNull($client->tracking_last_viewed);
    }

    /** @test */
    public function whatsapp_number_formats_correctly()
    {
        $client = Client::create([
            'nama_lengkap' => 'Format Test Unique',
            'email' => 'formatunique@test.com',
            'no_whatsapp' => '08123456789',
        ]);

        $waUrl = $client->whatsapp_tracking_url;
        
        // Harus dikonversi ke 62xxx
        $this->assertStringContainsString('628123456789', $waUrl);
    }
}
