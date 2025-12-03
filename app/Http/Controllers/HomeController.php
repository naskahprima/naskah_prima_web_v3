<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\PricingPackage;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\MitraJurnal;
use App\Models\Naskah;
use App\Models\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get settings
        $settings = Setting::getAllCached();
        
        // Get pricing packages with items and features
        $packages = PricingPackage::getForLandingPage();
        
        // Get testimonials
        $testimonials = Testimonial::getForLandingPage();
        
        // Get FAQs
        $faqs = Faq::getForLandingPage();
        
        // Calculate real-time stats from database
        $stats = $this->calculateStats();
        
        // Generate WhatsApp URL
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        return view('pages.home', compact(
            'settings',
            'packages',
            'testimonials',
            'faqs',
            'stats',
            'whatsappUrl'
        ));
    }

    /**
     * Calculate real-time statistics from database
     */
    private function calculateStats(): array
    {
        // Total klien = dari database + 20 klien lama
        $totalClients = 20;
        try {
            $totalClients = \App\Models\Client::count() + 20;
        } catch (\Exception $e) {}
        
        // Success rate dari database
        $successRate = 100;
        try {
            $total = \App\Models\Naskah::count();
            $published = \App\Models\Naskah::where('status', 'published')->count();
            if ($total > 0) {
                $successRate = round(($published / $total) * 100);
            }
        } catch (\Exception $e) {}
        
        // Mitra jurnal aktif dari database
        $activeJournals = 0;
        try {
            $activeJournals = \App\Models\MitraJurnal::where('status_kerjasama', 'aktif')->count();
        } catch (\Exception $e) {}
        
        return [
            'total_clients' => $totalClients,
            'success_rate' => $successRate,
            'avg_days' => 18,
            'active_journals' => $activeJournals,
        ];
    }

    /**
     * Generate WhatsApp click-to-chat URL
     */
    private function generateWhatsAppUrl(string $number, string $message = null): string
    {
        // Remove non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Default message
        if (empty($message)) {
            $message = 'Halo Naskah Prima, saya ingin konsultasi tentang publikasi jurnal';
        }
        
        return 'https://wa.me/' . $number . '?text=' . urlencode($message);
    }
}
