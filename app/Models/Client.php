<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_whatsapp',
        'institusi',
        'catatan_khusus',
        'tracking_token',
        'tracking_last_viewed',
    ];

    protected $casts = [
        'tracking_last_viewed' => 'datetime',
    ];

    /**
     * Auto generate tracking token saat create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            if (empty($client->tracking_token)) {
                $client->tracking_token = Str::random(32);
            }
        });
    }

    /**
     * Relasi ke naskah
     */
    public function naskah()
    {
        return $this->hasOne(Naskah::class);
    }

    /**
     * Get tracking URL
     */
    public function getTrackingUrlAttribute(): string
    {
        return url('/tracking/' . $this->tracking_token);
    }

    /**
     * Get WhatsApp URL dengan pesan tracking
     */
    public function getWhatsappTrackingUrlAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->no_whatsapp);
        
        // Pastikan format internasional
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        $message = "Halo {$this->nama_lengkap},\n\n";
        $message .= "Berikut link untuk memantau status artikel Anda di Naskah Prima:\n\n";
        $message .= "{$this->tracking_url}\n\n";
        $message .= "Silakan klik link di atas untuk melihat progress terbaru.\n\n";
        $message .= "Terima kasih! 🙏";
        
        return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
    }

    /**
     * Update last viewed timestamp
     */
    public function markTrackingViewed(): void
    {
        $this->update(['tracking_last_viewed' => now()]);
    }
}