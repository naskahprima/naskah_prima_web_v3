<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus FAQ lama
        Faq::truncate();

        // FAQ 1
        Faq::create([
            'question' => 'Bagaimana sistem pembayaran di Naskah Prima?',
            'answer' => 'Sistem pembayaran kami fleksibel dan disesuaikan dengan tahapan proses. KONDISI 1 (Proses Normal): Submit artikel, Review, LOA keluar, lalu Pembayaran SETELAH LOA. Keamanan TINGGI karena Anda bayar setelah pasti diterima. KONDISI 2 (Invoice Publisher Sudah Keluar): Artikel SUDAH PASTI diterima, Publisher sudah keluarkan invoice resmi, Pembayaran SEKARANG (sebelum publish). Risiko TIDAK ADA karena artikel 100% pasti publish.',
            'category' => 'Pembayaran',
            'is_active' => true,
            'order' => 1,
        ]);

        // FAQ 2
        Faq::create([
            'question' => 'Mengapa aman bayar duluan jika ada invoice?',
            'answer' => 'Invoice publisher adalah bukti resmi artikel diterima. Publisher tidak mungkin keluarkan invoice untuk artikel yang ditolak. Kami akan tunjukkan bukti invoice asli ke Anda dan Anda bisa verifikasi langsung ke publisher. Jika tidak publish, uang 100% dikembalikan dengan garansi tertulis. Analoginya seperti beli tiket pesawat - boarding pass sudah ada berarti Anda pasti terbang. Invoice publisher adalah boarding pass artikel Anda ke publikasi!',
            'category' => 'Pembayaran',
            'is_active' => true,
            'order' => 2,
        ]);

        // FAQ 3
        Faq::create([
            'question' => 'Apakah Naskah Prima pernah minta bayar di muka tanpa bukti?',
            'answer' => 'TIDAK PERNAH. Kami tidak akan pernah meminta pembayaran di muka tanpa bukti konkret. Jika kami minta pembayaran sebelum LOA/publish, pasti ada invoice resmi dari publisher yang bisa Anda verifikasi sendiri. Kepercayaan Anda adalah prioritas kami. Semua dokumen akan kami tunjukkan secara transparan sebelum Anda melakukan pembayaran.',
            'category' => 'Pembayaran',
            'is_active' => true,
            'order' => 3,
        ]);

        // FAQ 4
        Faq::create([
            'question' => 'Bagaimana cara menghindari jurnal predator?',
            'answer' => 'Kami memberikan anti-predator guarantee. Semua jurnal yang kami submit sudah dicek kredibilitasnya: (1) Terindeks SINTA resmi, (2) Track record publikasi yang jelas, (3) Proses peer review yang legitimate. Kami juga memberikan full disclosure jurnal yang akan disubmit sebelum proses dimulai.',
            'category' => 'Garansi',
            'is_active' => true,
            'order' => 4,
        ]);

        // FAQ 5
        Faq::create([
            'question' => 'Berapa lama rata-rata proses publikasi?',
            'answer' => 'Rata-rata 18 hari untuk paket Basic dan Premium. Untuk paket VIP Fast Track, kami prioritaskan proses menjadi 2-3 minggu. Timeline bisa lebih cepat atau lambat tergantung response time dari jurnal yang bersangkutan.',
            'category' => 'Proses',
            'is_active' => true,
            'order' => 5,
        ]);

        // FAQ 6
        Faq::create([
            'question' => 'Apa bedanya dengan jasa publikasi lain?',
            'answer' => 'Perbedaan utama: (1) Pembayaran fleksibel - bayar setelah ada kepastian (LOA atau invoice), (2) Harga 50-90% lebih murah (mulai Rp 300rb), (3) Editor spesialis informatika (bukan generalist), (4) Tech-enabled dengan dashboard tracking, (5) Plagiarism check gratis di Premium/VIP.',
            'category' => 'Umum',
            'is_active' => true,
            'order' => 6,
        ]);

        // FAQ 7
        Faq::create([
            'question' => 'Bisa konsultasi dulu sebelum order?',
            'answer' => 'Tentu saja! Konsultasi via WhatsApp 100% gratis tanpa komitmen. Kami akan diskusikan topik penelitian Anda, rekomendasi jurnal yang sesuai, estimasi timeline, dan paket yang paling cocok untuk kebutuhan Anda.',
            'category' => 'Umum',
            'is_active' => true,
            'order' => 7,
        ]);

        echo "FAQ berhasil di-update! Total: " . Faq::count() . " FAQ\n";
    }
}