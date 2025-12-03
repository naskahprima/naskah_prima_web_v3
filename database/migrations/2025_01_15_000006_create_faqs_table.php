<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FAQ (Frequently Asked Questions)
     */
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            
            // Pertanyaan
            $table->string('question');
            
            // Jawaban (bisa panjang, support HTML)
            $table->text('answer');
            
            // Kategori FAQ (Pembayaran, Proses, Garansi, dll)
            $table->string('category')->default('Umum');
            
            // Aktif/non-aktif
            $table->boolean('is_active')->default(true);
            
            // Urutan tampil
            $table->integer('order')->default(0);
            
            $table->timestamps();
            
            // Index untuk category
            $table->index('category');
        });

        // Seed default FAQs
        $this->seedDefaultFaqs();
    }

    private function seedDefaultFaqs(): void
    {
        $faqs = [
            [
                'question' => 'Apakah benar 100% bayar setelah LOA keluar?',
                'answer' => 'Ya, 100% benar. Ini adalah komitmen kami untuk zero risk payment. Anda tidak perlu membayar sepeser pun sampai LOA (Letter of Acceptance) keluar. Jika naskah tidak diterima, Anda tidak perlu bayar. Ini yang membedakan kami dengan kompetitor yang meminta DP 50%.',
                'category' => 'Pembayaran',
                'order' => 1,
            ],
            [
                'question' => 'Bagaimana cara menghindari jurnal predator?',
                'answer' => 'Kami memberikan anti-predator guarantee. Semua jurnal yang kami submit sudah dicek kredibilitasnya melalui: (1) Terindeks SINTA resmi, (2) Track record publikasi yang jelas, (3) Proses peer review yang legitimate. Kami juga memberikan full disclosure jurnal yang akan disubmit sebelum proses dimulai.',
                'category' => 'Garansi',
                'order' => 2,
            ],
            [
                'question' => 'Berapa lama rata-rata proses publikasi?',
                'answer' => 'Rata-rata 18 hari untuk paket Basic dan Premium (berdasarkan 3 klien selesai). Untuk paket VIP Fast Track, kami prioritaskan proses menjadi 2-3 minggu. Timeline bisa lebih cepat atau lambat tergantung response time dari jurnal yang bersangkutan.',
                'category' => 'Proses',
                'order' => 3,
            ],
            [
                'question' => 'Apa bedanya dengan jasa publikasi lain?',
                'answer' => 'Perbedaan utama: (1) Zero DP - bayar setelah LOA (kompetitor minta DP 50%), (2) Harga 50-90% lebih murah (mulai Rp 300rb vs Rp 500rb-7jt), (3) Editor spesialis informatika (bukan generalist), (4) Tech-enabled dengan dashboard tracking, (5) Plagiarism check gratis di Premium/VIP.',
                'category' => 'Umum',
                'order' => 4,
            ],
            [
                'question' => 'Apakah ada garansi jika naskah ditolak?',
                'answer' => 'Dengan sistem zero risk payment, jika naskah ditolak oleh jurnal, Anda tidak perlu membayar sama sekali. Untuk paket Premium dan VIP, kami akan submit ke jurnal alternatif (maksimal 2-3 jurnal sesuai paket) hingga berhasil mendapat LOA.',
                'category' => 'Garansi',
                'order' => 5,
            ],
            [
                'question' => 'Bisa konsultasi dulu sebelum order?',
                'answer' => 'Tentu saja! Konsultasi via WhatsApp 100% gratis tanpa komitmen. Kami akan diskusikan topik penelitian Anda, rekomendasi jurnal yang sesuai, estimasi timeline, dan paket yang paling cocok untuk kebutuhan Anda.',
                'category' => 'Umum',
                'order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            \DB::table('faqs')->insert(array_merge($faq, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
