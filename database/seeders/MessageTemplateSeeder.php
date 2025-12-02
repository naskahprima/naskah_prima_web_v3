<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageTemplate;

class MessageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Tanya Info Lengkap',
                'category' => 'jurnal',
                'template_text' => "Selamat pagi/siang,

Saya Zaky dari NaskahPrima, ingin menanyakan informasi terkait publikasi [nama_jurnal]

Mohon informasi mengenai:
- Apakah masih tersedia slot publikasi untuk edisi dekat ini?
- Kapan deadline submission untuk edisi tersebut?
- Tanggal berapa kira-kira jurnal akan terbit?
- Apakah ada opsi fast track? Jika ada, berapa biayanya?
- Apakah memungkinkan untuk terbit bulan ini atau bulan depan?
- Berapa biaya publikasi reguler?
- Berapa estimasi waktu proses review?

Terima kasih atas waktu dan perhatiannya.

Hormat saya,
Zaky
NaskahPrima",
                'variables' => ['nama_jurnal', 'nama_contact'],
                'is_default' => true,
                'description' => 'Template lengkap untuk tanya info pertama kali'
            ],
            [
                'name' => 'Tanya Jadwal Terbit',
                'category' => 'jurnal',
                'template_text' => "Selamat pagi/siang [nama_contact],

Saya Zaky dari NaskahPrima.

Saya ingin menanyakan jadwal terbit [nama_jurnal] untuk tahun ini:
- Bulan apa saja edisi terbitnya?
- Apakah ada edisi khusus?

Terima kasih.

Salam,
Zaky - NaskahPrima",
                'variables' => ['nama_jurnal', 'nama_contact'],
                'is_default' => false,
                'description' => 'Template khusus tanya jadwal'
            ],
            [
                'name' => 'Submit Naskah Baru',
                'category' => 'jurnal',
                'template_text' => "Selamat pagi/siang [nama_contact],

Saya Zaky dari NaskahPrima.

Saya ingin submit naskah untuk publikasi di [nama_jurnal].

File naskah akan saya kirim terpisah. Mohon informasi untuk langkah selanjutnya.

Terima kasih.

Hormat saya,
Zaky - NaskahPrima",
                'variables' => ['nama_jurnal', 'nama_contact'],
                'is_default' => false,
                'description' => 'Template untuk submit naskah baru'
            ],
            [
                'name' => 'Follow-up Review',
                'category' => 'jurnal',
                'template_text' => "Selamat pagi/siang [nama_contact],

Saya Zaky dari NaskahPrima.

Saya ingin follow-up untuk naskah yang sudah kami submit.

Bagaimana progress review-nya? 

Terima kasih atas perhatiannya.

Salam,
Zaky - NaskahPrima",
                'variables' => ['nama_jurnal', 'nama_contact'],
                'is_default' => false,
                'description' => 'Template untuk follow-up'
            ],
        ];

        foreach ($templates as $template) {
            MessageTemplate::create($template);
        }

        echo "✅ " . count($templates) . " Message Templates berhasil dibuat!\n";
    }
}