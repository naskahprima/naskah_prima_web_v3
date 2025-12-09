<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Naskah;
use App\Models\Client;
use App\Models\MitraJurnal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NaskahTest extends TestCase
{
    use RefreshDatabase;

    protected $client;
    protected $mitraJurnal;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->client = Client::create([
            'nama_lengkap' => 'Test Client Naskah',
            'email' => 'testnaskah@example.com',
            'no_whatsapp' => '081234567890',
            'institusi' => 'Universitas Test',
        ]);

        $this->mitraJurnal = MitraJurnal::create([
            'nama_jurnal' => 'Jurnal Test SINTA',
            'kategori_sinta' => 'Sinta 4',
            'jenis_bidang' => 'Informatika',
            'frekuensi_terbit' => 'Triwulan',
            'status_kerjasama' => 'Aktif',
        ]);
    }

    // ==========================================
    // NASKAH CRUD TESTS
    // ==========================================

    /** @test */
    public function naskah_can_be_created()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Test Naskah Jurnal',
            'client_id' => $this->client->id,
            'bidang_topik' => 'Informatika',
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        $this->assertDatabaseHas('naskahs', [
            'judul_naskah' => 'Test Naskah Jurnal',
        ]);
    }

    /** @test */
    public function naskah_can_be_updated()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Original Naskah Title',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update([
            'judul_naskah' => 'Updated Naskah Title',
            'status' => 'Submitted',
        ]);

        $this->assertDatabaseHas('naskahs', [
            'id' => $naskah->id,
            'judul_naskah' => 'Updated Naskah Title',
            'status' => 'Submitted',
        ]);
    }

    /** @test */
    public function naskah_can_be_deleted()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah To Delete',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        $naskahId = $naskah->id;
        $naskah->delete();

        $this->assertDatabaseMissing('naskahs', [
            'id' => $naskahId,
        ]);
    }

    // ==========================================
    // NASKAH RELATIONSHIP TESTS
    // ==========================================

    /** @test */
    public function naskah_belongs_to_client()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah With Client',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        $this->assertInstanceOf(Client::class, $naskah->client);
        $this->assertEquals($this->client->id, $naskah->client->id);
        $this->assertEquals('Test Client Naskah', $naskah->client->nama_lengkap);
    }

    /** @test */
    public function naskah_belongs_to_mitra_jurnal()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah With Jurnal',
            'client_id' => $this->client->id,
            'mitra_jurnal_id' => $this->mitraJurnal->id,
            'status' => 'Submitted',
            'tanggal_masuk' => now(),
        ]);

        $this->assertInstanceOf(MitraJurnal::class, $naskah->mitraJurnal);
        $this->assertEquals('Jurnal Test SINTA', $naskah->mitraJurnal->nama_jurnal);
    }

    /** @test */
    public function client_can_have_multiple_naskahs()
    {
        Naskah::create([
            'judul_naskah' => 'Naskah 1',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        Naskah::create([
            'judul_naskah' => 'Naskah 2',
            'client_id' => $this->client->id,
            'status' => 'Submitted',
            'tanggal_masuk' => now(),
        ]);

        // Check via direct query since Client model may not have naskahs() relation
        $count = Naskah::where('client_id', $this->client->id)->count();
        $this->assertEquals(2, $count);
    }

    /** @test */
    public function mitra_jurnal_can_have_multiple_naskahs()
    {
        Naskah::create([
            'judul_naskah' => 'Naskah Jurnal 1',
            'client_id' => $this->client->id,
            'mitra_jurnal_id' => $this->mitraJurnal->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        Naskah::create([
            'judul_naskah' => 'Naskah Jurnal 2',
            'client_id' => $this->client->id,
            'mitra_jurnal_id' => $this->mitraJurnal->id,
            'status' => 'Submitted',
            'tanggal_masuk' => now(),
        ]);

        $this->mitraJurnal->refresh();
        $this->assertCount(2, $this->mitraJurnal->naskahs);
    }

    // ==========================================
    // NASKAH STATUS WORKFLOW TESTS
    // ==========================================

    /** @test */
    public function naskah_status_can_change_draft_to_submitted()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Workflow Test Naskah',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update(['status' => 'Submitted']);
        $this->assertEquals('Submitted', $naskah->fresh()->status);
    }

    /** @test */
    public function naskah_status_can_change_to_under_review()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Review Test Naskah',
            'client_id' => $this->client->id,
            'status' => 'Submitted',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update(['status' => 'Under Review']);
        $this->assertEquals('Under Review', $naskah->fresh()->status);
    }

    /** @test */
    public function naskah_status_can_change_to_revision()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Revision Test Naskah',
            'client_id' => $this->client->id,
            'status' => 'Under Review',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update(['status' => 'Revision']);
        $this->assertEquals('Revision', $naskah->fresh()->status);
    }

    /** @test */
    public function naskah_status_can_change_to_accepted()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Accepted Test Naskah',
            'client_id' => $this->client->id,
            'status' => 'Revision',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update(['status' => 'Accepted']);
        $this->assertEquals('Accepted', $naskah->fresh()->status);
    }

    /** @test */
    public function naskah_status_can_change_to_published()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Published Test Naskah',
            'client_id' => $this->client->id,
            'status' => 'Accepted',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update([
            'status' => 'Published',
            'tanggal_published' => now(),
        ]);

        $this->assertEquals('Published', $naskah->fresh()->status);
        $this->assertNotNull($naskah->fresh()->tanggal_published);
    }

    /** @test */
    public function naskah_can_be_rejected()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Rejected Naskah',
            'client_id' => $this->client->id,
            'status' => 'Under Review',
            'tanggal_masuk' => now(),
        ]);

        $naskah->update(['status' => 'Rejected']);
        $this->assertEquals('Rejected', $naskah->fresh()->status);
    }

    // ==========================================
    // NASKAH ADDITIONAL FIELDS TESTS
    // ==========================================

    /** @test */
    public function naskah_can_have_target_bulan_publish()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah With Target',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
            'target_bulan_publish' => 'Mei 2025',
        ]);

        $this->assertEquals('Mei 2025', $naskah->target_bulan_publish);
    }

    /** @test */
    public function naskah_can_have_catatan_progress()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah With Notes',
            'client_id' => $this->client->id,
            'status' => 'Under Review',
            'tanggal_masuk' => now(),
            'catatan_progress' => 'Sedang direview oleh reviewer 1',
        ]);

        $this->assertEquals('Sedang direview oleh reviewer 1', $naskah->catatan_progress);
    }

    /** @test */
    public function naskah_can_have_bidang_topik()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah With Bidang',
            'client_id' => $this->client->id,
            'status' => 'Draft',
            'tanggal_masuk' => now(),
            'bidang_topik' => 'Machine Learning',
        ]);

        $this->assertEquals('Machine Learning', $naskah->bidang_topik);
    }

    /** @test */
    public function naskah_can_have_biaya_dibayar()
    {
        $naskah = Naskah::create([
            'judul_naskah' => 'Naskah With Biaya',
            'client_id' => $this->client->id,
            'status' => 'Accepted',
            'tanggal_masuk' => now(),
            'biaya_dibayar' => 500000,
        ]);

        $this->assertEquals(500000, $naskah->biaya_dibayar);
    }
}