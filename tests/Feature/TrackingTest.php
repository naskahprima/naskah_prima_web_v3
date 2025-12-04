<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Naskah;
use App\Models\MitraJurnal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tracking_page_returns_404_for_invalid_token()
    {
        $response = $this->get('/tracking/invalid-token-12345');

        $response->assertStatus(404);
    }

    /** @test */
    public function tracking_page_returns_200_for_valid_token()
    {
        $client = Client::create([
            'nama_lengkap' => 'Test Client',
            'email' => 'test@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'valid-token-1234567890123456',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
    }

    /** @test */
    public function tracking_page_shows_client_name()
    {
        $client = Client::create([
            'nama_lengkap' => 'Ahmad Rizky',
            'email' => 'ahmad@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'test-token-12345678901234567',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Ahmad Rizky');
    }

    /** @test */
    public function tracking_page_shows_naskah_info()
    {
        $client = Client::create([
            'nama_lengkap' => 'Test User',
            'email' => 'user@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'naskah-token-123456789012345',
        ]);

        $naskah = Naskah::create([
            'judul_naskah' => 'Implementasi AI untuk Prediksi Cuaca',
            'client_id' => $client->id,
            'tanggal_masuk' => now(),
            'status' => 'Under Review',
            'catatan_progress' => 'Sedang dalam proses review.',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Implementasi AI untuk Prediksi Cuaca');
        $response->assertSee('Under Review');
        $response->assertSee('Sedang dalam proses review.');
    }

    /** @test */
    public function tracking_page_shows_jurnal_info()
    {
        $client = Client::create([
            'nama_lengkap' => 'Jurnal Test',
            'email' => 'jurnal@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'jurnal-token-123456789012345',
        ]);

        $jurnal = MitraJurnal::create([
            'nama_jurnal' => 'Jurnal Teknologi Informasi',
            'peringkat_sinta' => 'SINTA 4',
            'status_kerjasama' => 'aktif',
        ]);

        $naskah = Naskah::create([
            'judul_naskah' => 'Test Jurnal Display',
            'client_id' => $client->id,
            'mitra_jurnal_id' => $jurnal->id,
            'tanggal_masuk' => now(),
            'status' => 'Submitted',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Jurnal Teknologi Informasi');
    }

    /** @test */
    public function tracking_page_updates_last_viewed_timestamp()
    {
        $client = Client::create([
            'nama_lengkap' => 'Timestamp Test',
            'email' => 'timestamp@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'timestamp-token-12345678901234',
        ]);

        $this->assertNull($client->tracking_last_viewed);

        $this->get('/tracking/' . $client->tracking_token);

        $this->assertNotNull($client->fresh()->tracking_last_viewed);
    }

    /** @test */
    public function tracking_page_shows_empty_state_when_no_naskah()
    {
        $client = Client::create([
            'nama_lengkap' => 'No Naskah Client',
            'email' => 'nonaskah@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'nonaskah-token-12345678901234',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Belum Ada Artikel');
    }

    /** @test */
    public function tracking_page_shows_published_status()
    {
        $client = Client::create([
            'nama_lengkap' => 'Published Client',
            'email' => 'published@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'published-token-1234567890123',
        ]);

        $naskah = Naskah::create([
            'judul_naskah' => 'Published Article',
            'client_id' => $client->id,
            'tanggal_masuk' => now()->subMonth(),
            'tanggal_published' => now(),
            'status' => 'Published',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('Published');
    }

    /** @test */
    public function tracking_page_shows_rejected_status()
    {
        $client = Client::create([
            'nama_lengkap' => 'Rejected Client',
            'email' => 'rejected@example.com',
            'no_whatsapp' => '081234567890',
            'tracking_token' => 'rejected-token-1234567890123',
        ]);

        $naskah = Naskah::create([
            'judul_naskah' => 'Rejected Article',
            'client_id' => $client->id,
            'tanggal_masuk' => now(),
            'status' => 'Rejected',
        ]);

        $response = $this->get('/tracking/' . $client->tracking_token);

        $response->assertStatus(200);
        $response->assertSee('tidak dapat dilanjutkan');
    }
}
