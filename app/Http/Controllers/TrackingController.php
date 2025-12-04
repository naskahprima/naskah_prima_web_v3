<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Setting;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function show(string $token)
    {
        // Cari client berdasarkan token
        $client = Client::where('tracking_token', $token)
            ->with(['naskah.mitraJurnal'])
            ->firstOrFail();
        
        // Update last viewed
        $client->markTrackingViewed();
        
        // Get settings
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        return view('tracking.show', compact('client', 'settings', 'whatsappUrl'));
    }

    private function generateWhatsAppUrl(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        $message = 'Halo Naskah Prima, saya ingin bertanya tentang status artikel saya';
        
        return 'https://wa.me/' . $number . '?text=' . urlencode($message);
    }
}