<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share common data to all views
        View::composer('*', function ($view) {
            // Get all settings (cached)
            $settings = Setting::getAllCached();
            
            // Generate WhatsApp URL
            $whatsappNumber = $settings['whatsapp_number'] ?? '6281234567890';
            $whatsappMessage = 'Halo Naskah Prima, saya ingin konsultasi tentang publikasi jurnal';
            $whatsappUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNumber) . '?text=' . urlencode($whatsappMessage);
            
            // Share to view (only if not already set)
            if (!$view->offsetExists('settings')) {
                $view->with('settings', $settings);
            }
            if (!$view->offsetExists('whatsappUrl')) {
                $view->with('whatsappUrl', $whatsappUrl);
            }
        });
    }
}
