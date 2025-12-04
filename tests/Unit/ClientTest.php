<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Naskah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_be_created()
    {
        $client = Client::create([
            'nama_lengkap' => 'John Doe',
            'email' => 'john@example.com',
            'no_whatsapp' => '081234567890',
            'institusi' => 'Universitas Test',
        ]);

        $this->assertDatabaseHas('clients', [
            'nama_lengkap' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function client_has_tracking_token_generated_automatically()
    {
        $client = Client::create([
            'nama_lengkap' => 'Jane Doe',
            'email' => 'jane@example.com',
            'no_whatsapp' => '081234567891',
        ]);

        $this->assertNotNull($client->tracking_token);
        $this->assertEquals(32, strlen($client->tracking_token));
    }

    /** @test */
    public function client_tracking_url_is_generated_correctly()
    {
        $client = Client::create([
            'nama_lengkap' => 'Test User',
            'email' => 'test@example.com',
            'no_whatsapp' => '081234567892',
        ]);

        $expectedUrl = url('/tracking/' . $client->tracking_token);
        $this->assertEquals($expectedUrl, $client->tracking_url);
    }

    /** @test */
    public function client_whatsapp_tracking_url_is_generated_correctly()
    {
        $client = Client::create([
            'nama_lengkap' => 'WA Test',
            'email' => 'wa@example.com',
            'no_whatsapp' => '081234567893',
        ]);

        $waUrl = $client->whatsapp_tracking_url;
        
        $this->assertStringContainsString('https://wa.me/', $waUrl);
        $this->assertStringContainsString('6281234567893', $waUrl);
        $this->assertStringContainsString(urlencode($client->tracking_url), $waUrl);
    }

    /** @test */
    public function client_has_one_naskah_relationship()
    {
        $client = Client::create([
            'nama_lengkap' => 'Client With Naskah',
            'email' => 'naskah@example.com',
            'no_whatsapp' => '081234567894',
        ]);

        $naskah = Naskah::create([
            'judul_naskah' => 'Test Naskah',
            'client_id' => $client->id,
            'tanggal_masuk' => now(),
            'status' => 'Draft',
        ]);

        $this->assertEquals($naskah->id, $client->naskah->id);
    }

    /** @test */
    public function client_tracking_last_viewed_can_be_updated()
    {
        $client = Client::create([
            'nama_lengkap' => 'Tracking Test',
            'email' => 'tracking@example.com',
            'no_whatsapp' => '081234567895',
        ]);

        $this->assertNull($client->tracking_last_viewed);

        $client->markTrackingViewed();

        $this->assertNotNull($client->fresh()->tracking_last_viewed);
    }
}
