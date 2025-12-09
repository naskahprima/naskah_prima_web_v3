<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cache_clear_command_works()
    {
        $exitCode = Artisan::call('cache:clear');
        $this->assertEquals(0, $exitCode);
    }

    /** @test */
    public function config_clear_command_works()
    {
        $exitCode = Artisan::call('config:clear');
        $this->assertEquals(0, $exitCode);
    }

    /** @test */
    public function view_clear_command_works()
    {
        $exitCode = Artisan::call('view:clear');
        $this->assertEquals(0, $exitCode);
    }

    /** @test */
    public function route_clear_command_works()
    {
        $exitCode = Artisan::call('route:clear');
        $this->assertEquals(0, $exitCode);
    }

    /** @test */
    public function optimize_clear_command_works()
    {
        $exitCode = Artisan::call('optimize:clear');
        $this->assertEquals(0, $exitCode);
    }
}
