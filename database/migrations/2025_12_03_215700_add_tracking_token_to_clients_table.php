<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('tracking_token', 32)->unique()->nullable()->after('catatan_khusus');
            $table->timestamp('tracking_last_viewed')->nullable()->after('tracking_token');
        });

        // Generate token untuk client yang sudah ada
        $clients = \App\Models\Client::whereNull('tracking_token')->get();
        foreach ($clients as $client) {
            $client->update([
                'tracking_token' => Str::random(32)
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['tracking_token', 'tracking_last_viewed']);
        });
    }
};