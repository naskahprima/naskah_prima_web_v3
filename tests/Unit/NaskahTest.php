<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Naskah;
use App\Models\MitraJurnal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NaskahTest extends TestCase
{
    use RefreshDatabase;

    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->client = Client::create([
            'nama_lengkap' => 'Test Client',
            'email' => 'client@example.com',
            'no_whatsapp' => '081234567890',
        ]);
    }

    /** @test */
    public function naskah_can_be_created()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Implementasi Machine Learning',
            'client_id' => $this->client->id,
            'tanggal_masuk' => now(),
            'status' => 'Draft',
        ]);

        $this->assertDatabaseHas('naskahs', [
            'judul_naskah' => 'Implementasi Machine Learning',
            'status' => 'Draft',
        ]);
    }

    /** @test */
    public function naskah_belongs_to_client()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Test Relationship',
            'client_id' => $this->client->id,
            'tanggal_masuk' => now(),
            'status' => 'Draft',
        ]);

        $this->assertEquals($this->client->id, $naskah->client->id);
        $this->assertEquals('Test Client', $naskah->client->nama_lengkap);
    }

    /** @test */
    public function naskah_can_have_mitra_jurnal()
    {
        $jurnal = MitraJurnal::create([
            'nama_jurnal' => 'Jurnal Informatika',
            'peringkat_sinta' => 'SINTA 5',
            'status_kerjasama' => 'aktif',
        ]);

        $naskah = Naskah::create([
            'judul_naskah' => 'Test Jurnal',
            'client_id' => $this->client->id,
            'mitra_jurnal_id' => $jurnal->id,
            'tanggal_masuk' => now(),
            'status' => 'Submitted',
        ]);

        $this->assertEquals($jurnal->id, $naskah->mitraJurnal->id);
    }

    /** @test */
    public function naskah_status_can_be_updated()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Status Test',
            'client_id' => $this->client->id,
            'tanggal_masuk' => now(),
            'status' => 'Draft',
        ]);

        $naskah->update(['status' => 'Submitted']);
        $this->assertEquals('Submitted', $naskah->fresh()->status);

        $naskah->update(['status' => 'Under Review']);
        $this->assertEquals('Under Review', $naskah->fresh()->status);

        $naskah->update(['status' => 'Published']);
        $this->assertEquals('Published', $naskah->fresh()->status);
    }

    /** @test */
    public function naskah_can_have_catatan_progress()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Progress Test',
            'client_id' => $this->client->id,
            'tanggal_masuk' => now(),
            'status' => 'Under Review',
            'catatan_progress' => 'Sedang dalam proses review oleh editor jurnal.',
        ]);

        $this->assertEquals('Sedang dalam proses review oleh editor jurnal.', $naskah->catatan_progress);
    }

    /** @test */
    public function naskah_tanggal_masuk_is_cast_to_date()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Date Cast Test',
            'client_id' => $this->client->id,
            'tanggal_masuk' => '2024-12-01',
            'status' => 'Draft',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $naskah->tanggal_masuk);
    }
}
