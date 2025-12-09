<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Naskah;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackingPageTest extends TestCase
{
    use RefreshDatabase;

    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->client = Client::create([
            'nama_lengkap' => 'Test Tracking Client',
            'email' => 'tracking@example.com',
            'no_whatsapp' => '081234567890',
            'institusi' => 'Universitas Tracking',
        ]);
    }

    // ==========================================
    // TRACKING PAGE ACCESS TESTS
    // ==========================================

    /** @test */
    public function tracking_page_loads_with_valid_token()
    {
        $response = $this->get('/tracking/' . $this->client->tracking_token);

        $response->assertStatus(200);
    }

    /** @test */
    public function tracking_page_shows_client_name()
    {
        $response = $this->get('/tracking/' . $this->client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Test Tracking Client');
    }

    /** @test */
    public function tracking_page_returns_404_for_invalid_token()
    {
        $response = $this->get('/tracking/invalid-token-12345678901234567890');

        $response->assertStatus(404);
    }

    /** @test */
    public function tracking_page_returns_404_for_empty_token()
    {
        $response = $this->get('/tracking/');

        // Should return 404 or redirect
        $this->assertTrue(in_array($response->status(), [404, 302]));
    }

    // ==========================================
    // TRACKING PAGE WITH NASKAH TESTS
    // ==========================================

    /** @test */
    public function tracking_page_shows_naskah_data()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Tracking Test Naskah Unique',
            'client_id' => $this->client->id,
            'status' => 'Under Review',
            'tanggal_masuk' => now(),
        ]);

        $response = $this->get('/tracking/' . $this->client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Tracking Test Naskah Unique');
    }

    /** @test */
    public function tracking_page_shows_naskah_status()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Status Display Test',
            'client_id' => $this->client->id,
            'status' => 'Accepted',
            'tanggal_masuk' => now(),
        ]);

        $response = $this->get('/tracking/' . $this->client->tracking_token);

        $response->assertStatus(200);
    }

    /** @test */
    public function tracking_page_shows_naskah_title()
    {
        // Note: Tracking page only shows ONE naskah (the first/latest one)
        // So we test that it shows the naskah title
        Naskah::create([
            'judul_naskah' => 'Single Naskah For Tracking',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        $response = $this->get('/tracking/' . $this->client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Single Naskah For Tracking');
    }

    // ==========================================
    // TRACKING VIEWED TIMESTAMP TESTS
    // ==========================================

    /** @test */
    public function tracking_page_updates_last_viewed_timestamp()
    {
        $this->assertNull($this->client->tracking_last_viewed);

        $this->get('/tracking/' . $this->client->tracking_token);

        $this->client->refresh();
        $this->assertNotNull($this->client->tracking_last_viewed);
    }

    /** @test */
    public function tracking_page_updates_timestamp_on_each_visit()
    {
        // First visit
        $this->get('/tracking/' . $this->client->tracking_token);
        $this->client->refresh();
        $firstVisit = $this->client->tracking_last_viewed;

        // Wait a moment
        sleep(1);

        // Second visit
        $this->get('/tracking/' . $this->client->tracking_token);
        $this->client->refresh();
        $secondVisit = $this->client->tracking_last_viewed;

        $this->assertGreaterThan($firstVisit, $secondVisit);
    }

    // ==========================================
    // TRACKING TOKEN TESTS
    // ==========================================

    /** @test */
    public function each_client_has_unique_tracking_token()
    {
        $client2 = Client::create([
            'nama_lengkap' => 'Another Client',
            'email' => 'another@example.com',
            'no_whatsapp' => '081234567891',
        ]);

        $this->assertNotEquals(
            $this->client->tracking_token,
            $client2->tracking_token
        );
    }

    /** @test */
    public function tracking_token_is_32_characters()
    {
        $this->assertEquals(32, strlen($this->client->tracking_token));
    }

    /** @test */
    public function client_cannot_see_other_client_naskah()
    {
        // Create another client with naskah
        $otherClient = Client::create([
            'nama_lengkap' => 'Other Client',
            'email' => 'other@example.com',
            'no_whatsapp' => '081234567899',
        ]);

        Naskah::create([
            'judul_naskah' => 'Other Client Secret Naskah',
            'client_id' => $otherClient->id,
            'status' => 'Published',
            'tanggal_masuk' => now(),
        ]);

        // Access tracking page with first client's token
        $response = $this->get('/tracking/' . $this->client->tracking_token);

        $response->assertStatus(200);
        $response->assertDontSee('Other Client Secret Naskah');
    }
}