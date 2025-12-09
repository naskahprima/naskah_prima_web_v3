<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Get admin user
        $admin = User::first();
        
        // Create Categories
        $categories = [
            ['name' => 'Tips Publikasi', 'slug' => 'tips-publikasi', 'is_active' => true, 'order' => 1],
            ['name' => 'Panduan Jurnal', 'slug' => 'panduan-jurnal', 'is_active' => true, 'order' => 2],
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'is_active' => true, 'order' => 3],
            ['name' => 'Berita', 'slug' => 'berita', 'is_active' => true, 'order' => 4],
        ];

        foreach ($categories as $cat) {
            BlogCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Create Tags
        $tags = [
            ['name' => 'SINTA', 'slug' => 'sinta'],
            ['name' => 'Jurnal Ilmiah', 'slug' => 'jurnal-ilmiah'],
            ['name' => 'Skripsi', 'slug' => 'skripsi'],
            ['name' => 'Penelitian', 'slug' => 'penelitian'],
            ['name' => 'Mahasiswa', 'slug' => 'mahasiswa'],
            ['name' => 'Informatika', 'slug' => 'informatika'],
            ['name' => 'Machine Learning', 'slug' => 'machine-learning'],
            ['name' => 'Tips', 'slug' => 'tips'],
        ];

        foreach ($tags as $tag) {
            BlogTag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }

        // Get category IDs
        $catTips = BlogCategory::where('slug', 'tips-publikasi')->first()->id;
        $catPanduan = BlogCategory::where('slug', 'panduan-jurnal')->first()->id;
        $catTutorial = BlogCategory::where('slug', 'tutorial')->first()->id;
        $catBerita = BlogCategory::where('slug', 'berita')->first()->id;

        // Blog Posts Data
        $posts = [
            [
                'title' => 'Cara Memilih Jurnal SINTA yang Tepat untuk Publikasi',
                'slug' => 'cara-memilih-jurnal-sinta-yang-tepat',
                'excerpt' => 'Panduan lengkap memilih jurnal SINTA 1-6 yang sesuai dengan topik penelitian Anda. Hindari jurnal predator dan maksimalkan peluang accepted.',
                'content' => $this->getContent1(),
                'blog_category_id' => $catPanduan,
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'is_featured' => true,
                'tags' => ['sinta', 'jurnal-ilmiah', 'tips'],
            ],
            [
                'title' => '7 Kesalahan Fatal yang Membuat Artikel Ditolak Jurnal',
                'slug' => '7-kesalahan-fatal-artikel-ditolak-jurnal',
                'excerpt' => 'Hindari kesalahan-kesalahan umum ini agar artikel Anda tidak ditolak reviewer. Pelajari dari pengalaman ratusan mahasiswa.',
                'content' => $this->getContent2(),
                'blog_category_id' => $catTips,
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'is_featured' => true,
                'tags' => ['tips', 'jurnal-ilmiah', 'mahasiswa'],
            ],
            [
                'title' => 'Perbedaan SINTA 1, 2, 3, 4, 5, dan 6: Mana yang Cocok?',
                'slug' => 'perbedaan-sinta-1-2-3-4-5-6',
                'excerpt' => 'Memahami perbedaan peringkat SINTA dan bagaimana memilih level yang sesuai dengan kualitas penelitian Anda.',
                'content' => $this->getContent3(),
                'blog_category_id' => $catPanduan,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'is_featured' => false,
                'tags' => ['sinta', 'jurnal-ilmiah'],
            ],
            [
                'title' => 'Template Artikel Jurnal Informatika yang Benar',
                'slug' => 'template-artikel-jurnal-informatika',
                'excerpt' => 'Download template dan pelajari struktur artikel jurnal informatika yang sesuai standar internasional.',
                'content' => $this->getContent4(),
                'blog_category_id' => $catTutorial,
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'is_featured' => false,
                'tags' => ['informatika', 'tutorial', 'tips'],
            ],
            [
                'title' => 'Cara Menulis Abstrak yang Menarik untuk Jurnal Ilmiah',
                'slug' => 'cara-menulis-abstrak-jurnal-ilmiah',
                'excerpt' => 'Abstrak adalah kesan pertama reviewer. Pelajari teknik menulis abstrak yang compelling dan informatif.',
                'content' => $this->getContent5(),
                'blog_category_id' => $catTips,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'is_featured' => false,
                'tags' => ['tips', 'jurnal-ilmiah', 'penelitian'],
            ],
            [
                'title' => 'Mengenal Proses Peer Review: Dari Submit Hingga Published',
                'slug' => 'proses-peer-review-jurnal',
                'excerpt' => 'Pahami alur peer review agar Anda tidak bingung dan bisa mempersiapkan diri dengan baik.',
                'content' => $this->getContent6(),
                'blog_category_id' => $catPanduan,
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'is_featured' => false,
                'tags' => ['jurnal-ilmiah', 'penelitian'],
            ],
            [
                'title' => 'Tips Lolos Plagiarism Check di Turnitin',
                'slug' => 'tips-lolos-plagiarism-check-turnitin',
                'excerpt' => 'Similarity tinggi? Jangan panik! Pelajari cara menurunkan persentase plagiarisme dengan teknik parafrase yang benar.',
                'content' => $this->getContent7(),
                'blog_category_id' => $catTips,
                'status' => 'published',
                'published_at' => now()->subDays(14),
                'is_featured' => true,
                'tags' => ['tips', 'mahasiswa', 'skripsi'],
            ],
            [
                'title' => 'Publikasi Jurnal Machine Learning: Jurnal Rekomendasi 2024',
                'slug' => 'publikasi-jurnal-machine-learning-2024',
                'excerpt' => 'Daftar jurnal SINTA terbaik untuk publikasi penelitian di bidang machine learning dan artificial intelligence.',
                'content' => $this->getContent8(),
                'blog_category_id' => $catPanduan,
                'status' => 'published',
                'published_at' => now()->subDays(16),
                'is_featured' => false,
                'tags' => ['machine-learning', 'informatika', 'sinta'],
            ],
            [
                'title' => 'Cara Merespon Reviewer Comments dengan Profesional',
                'slug' => 'cara-merespon-reviewer-comments',
                'excerpt' => 'Dapat revision? Pelajari cara merespon komentar reviewer dengan baik agar artikel Anda accepted.',
                'content' => $this->getContent9(),
                'blog_category_id' => $catTips,
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'is_featured' => false,
                'tags' => ['tips', 'jurnal-ilmiah'],
            ],
            [
                'title' => 'Berapa Lama Proses Publikasi Jurnal SINTA?',
                'slug' => 'berapa-lama-proses-publikasi-jurnal-sinta',
                'excerpt' => 'Estimasi waktu dari submit hingga published untuk setiap level SINTA. Plus tips mempercepat proses.',
                'content' => $this->getContent10(),
                'blog_category_id' => $catBerita,
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'is_featured' => false,
                'tags' => ['sinta', 'tips', 'mahasiswa'],
            ],
        ];

        // Create Posts
        foreach ($posts as $postData) {
            $tagSlugs = $postData['tags'];
            unset($postData['tags']);
            
            $postData['user_id'] = $admin->id;
            $postData['reading_time'] = ceil(str_word_count(strip_tags($postData['content'])) / 200);
            $postData['view_count'] = rand(50, 500);
            
            $post = BlogPost::firstOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );

            // Attach tags
            $tagIds = BlogTag::whereIn('slug', $tagSlugs)->pluck('id');
            $post->tags()->sync($tagIds);
        }

        $this->command->info('✅ 10 Blog posts created successfully!');
    }

    private function getContent1(): string
    {
        return <<<HTML
<h2>Mengapa Pemilihan Jurnal Sangat Penting?</h2>
<p>Memilih jurnal yang tepat adalah langkah krusial dalam proses publikasi. Jurnal yang tidak sesuai dengan topik penelitian Anda akan berujung pada penolakan (rejection), membuang waktu dan tenaga yang sudah Anda investasikan.</p>

<h2>Kriteria Memilih Jurnal SINTA</h2>
<p>Berikut adalah kriteria yang harus Anda perhatikan:</p>
<ul>
    <li><strong>Scope & Focus:</strong> Pastikan topik penelitian Anda sesuai dengan scope jurnal</li>
    <li><strong>Peringkat SINTA:</strong> Sesuaikan dengan kualitas penelitian dan kebutuhan Anda</li>
    <li><strong>Frekuensi Terbit:</strong> Jurnal yang sering terbit biasanya lebih cepat prosesnya</li>
    <li><strong>Biaya Publikasi:</strong> Perhatikan author fee yang harus dibayar</li>
    <li><strong>Review Time:</strong> Cek estimasi waktu review dari pengalaman penulis lain</li>
</ul>

<h2>Cara Mengecek Keaslian Jurnal</h2>
<p>Untuk menghindari jurnal predator, lakukan pengecekan berikut:</p>
<ol>
    <li>Cek di <a href="https://sinta.kemdikbud.go.id" target="_blank">sinta.kemdikbud.go.id</a></li>
    <li>Periksa editorial board - apakah kredibel?</li>
    <li>Cek apakah ada proses peer review yang jelas</li>
    <li>Hindari jurnal yang menjanjikan publikasi instan</li>
</ol>

<blockquote>
    <p>"Jurnal yang baik tidak akan menjanjikan accepted sebelum proses review selesai."</p>
</blockquote>

<h2>Kesimpulan</h2>
<p>Luangkan waktu untuk riset jurnal sebelum submit. Lebih baik menunggu jurnal yang tepat daripada terburu-buru dan ditolak.</p>
HTML;
    }

    private function getContent2(): string
    {
        return <<<HTML
<h2>Kesalahan #1: Tidak Membaca Author Guidelines</h2>
<p>Ini adalah kesalahan paling umum. Setiap jurnal memiliki format dan ketentuan yang berbeda. Artikel yang tidak sesuai guidelines akan langsung di-reject tanpa review.</p>

<h2>Kesalahan #2: Abstrak yang Terlalu Panjang atau Pendek</h2>
<p>Abstrak idealnya 150-250 kata. Terlalu panjang menunjukkan ketidakmampuan merangkum, terlalu pendek berarti informasi tidak lengkap.</p>

<h2>Kesalahan #3: Plagiarisme Tinggi</h2>
<p>Similarity di atas 20-25% adalah red flag. Bahkan jika bukan plagiarisme disengaja, reviewer akan menolak artikel dengan similarity tinggi.</p>

<h2>Kesalahan #4: Metodologi Tidak Jelas</h2>
<p>Bagian metodologi harus bisa direplikasi oleh peneliti lain. Jelaskan:</p>
<ul>
    <li>Dataset yang digunakan</li>
    <li>Tools dan teknologi</li>
    <li>Langkah-langkah penelitian</li>
    <li>Metrik evaluasi</li>
</ul>

<h2>Kesalahan #5: Referensi Tidak Update</h2>
<p>Minimal 50% referensi harus dari 5 tahun terakhir. Referensi usang menunjukkan penelitian Anda tidak up-to-date.</p>

<h2>Kesalahan #6: Bahasa Inggris yang Buruk</h2>
<p>Untuk jurnal internasional, grammar dan vocabulary sangat diperhatikan. Gunakan tools seperti Grammarly atau minta proofreading.</p>

<h2>Kesalahan #7: Claim Berlebihan</h2>
<p>Jangan klaim hasil penelitian Anda "terbaik" atau "pertama" tanpa bukti kuat. Reviewer tidak suka overclaim.</p>
HTML;
    }

    private function getContent3(): string
    {
        return <<<HTML
<h2>Apa itu SINTA?</h2>
<p>SINTA (Science and Technology Index) adalah sistem akreditasi jurnal ilmiah di Indonesia yang dikelola oleh Kemenristekdikti. Peringkat SINTA menunjukkan kualitas dan kredibilitas jurnal.</p>

<h2>Perbedaan Setiap Peringkat</h2>

<h3>SINTA 1 (S1)</h3>
<p>Jurnal dengan kualitas tertinggi, setara jurnal internasional bereputasi. Cocok untuk dosen dan peneliti senior. Proses sangat ketat dan lama.</p>

<h3>SINTA 2 (S2)</h3>
<p>Kualitas sangat baik, biasanya indexed Scopus atau Web of Science. Cocok untuk S3 dan dosen.</p>

<h3>SINTA 3 (S3)</h3>
<p>Kualitas baik dengan review yang cukup ketat. Cocok untuk S2 dan dosen muda.</p>

<h3>SINTA 4 (S4)</h3>
<p>Kualitas cukup baik, proses lebih cepat. <strong>Paling cocok untuk mahasiswa S1 dan S2</strong> yang butuh publikasi untuk syarat kelulusan.</p>

<h3>SINTA 5 (S5)</h3>
<p>Entry level untuk jurnal terakreditasi. Proses relatif cepat dan biaya terjangkau. Cocok untuk publikasi pertama.</p>

<h3>SINTA 6 (S6)</h3>
<p>Akreditasi dasar. Proses paling cepat dan biaya paling murah. Cocok untuk yang butuh publikasi dengan deadline ketat.</p>

<h2>Rekomendasi untuk Mahasiswa</h2>
<p>Untuk mahasiswa S1 informatika, kami merekomendasikan:</p>
<ul>
    <li><strong>Target utama:</strong> SINTA 4-5</li>
    <li><strong>Alternatif cepat:</strong> SINTA 6</li>
</ul>
HTML;
    }

    private function getContent4(): string
    {
        return <<<HTML
<h2>Struktur Artikel Jurnal Informatika</h2>
<p>Artikel jurnal informatika umumnya mengikuti format IMRAD (Introduction, Methods, Results, and Discussion) dengan beberapa penyesuaian.</p>

<h2>1. Judul (Title)</h2>
<p>Judul harus:</p>
<ul>
    <li>Informatif dan spesifik</li>
    <li>Mengandung keyword utama</li>
    <li>Tidak terlalu panjang (maksimal 15 kata)</li>
</ul>

<h2>2. Abstrak</h2>
<p>Struktur abstrak yang baik:</p>
<ul>
    <li><strong>Background:</strong> 1-2 kalimat latar belakang</li>
    <li><strong>Objective:</strong> Tujuan penelitian</li>
    <li><strong>Methods:</strong> Metode yang digunakan</li>
    <li><strong>Results:</strong> Hasil utama (dengan angka)</li>
    <li><strong>Conclusion:</strong> Kesimpulan singkat</li>
</ul>

<h2>3. Pendahuluan</h2>
<p>Isi pendahuluan:</p>
<ol>
    <li>Latar belakang masalah</li>
    <li>Gap analysis dari penelitian sebelumnya</li>
    <li>Kontribusi penelitian Anda</li>
    <li>Tujuan penelitian</li>
</ol>

<h2>4. Metodologi</h2>
<p>Untuk penelitian informatika, jelaskan:</p>
<ul>
    <li>Dataset (sumber, ukuran, preprocessing)</li>
    <li>Algoritma/model yang digunakan</li>
    <li>Tools dan environment</li>
    <li>Metrik evaluasi</li>
</ul>

<h2>5. Hasil dan Pembahasan</h2>
<p>Sajikan hasil dengan:</p>
<ul>
    <li>Tabel perbandingan</li>
    <li>Grafik/chart</li>
    <li>Analisis mendalam</li>
    <li>Perbandingan dengan penelitian lain</li>
</ul>

<h2>6. Kesimpulan</h2>
<p>Berisi:</p>
<ul>
    <li>Rangkuman temuan utama</li>
    <li>Kontribusi penelitian</li>
    <li>Saran untuk penelitian selanjutnya</li>
</ul>
HTML;
    }

    private function getContent5(): string
    {
        return <<<HTML
<h2>Pentingnya Abstrak yang Baik</h2>
<p>Abstrak adalah hal pertama yang dibaca reviewer dan pembaca. Abstrak yang buruk bisa membuat artikel Anda tidak dibaca lebih lanjut.</p>

<h2>Formula Menulis Abstrak</h2>
<p>Gunakan formula <strong>BOMRC</strong>:</p>
<ul>
    <li><strong>B</strong>ackground - Mengapa penelitian ini penting?</li>
    <li><strong>O</strong>bjective - Apa tujuan penelitian?</li>
    <li><strong>M</strong>ethods - Bagaimana cara Anda meneliti?</li>
    <li><strong>R</strong>esults - Apa hasil yang didapat?</li>
    <li><strong>C</strong>onclusion - Apa kesimpulannya?</li>
</ul>

<h2>Contoh Abstrak yang Baik</h2>
<blockquote>
<p><em>"Sentiment analysis pada media sosial menjadi penting untuk memahami opini publik. Penelitian ini bertujuan untuk mengklasifikasikan sentimen tweet berbahasa Indonesia menggunakan algoritma Support Vector Machine (SVM). Dataset terdiri dari 5000 tweet yang dilabeli manual. Hasil menunjukkan akurasi 87.5% dengan precision 85% dan recall 89%. Penelitian ini berkontribusi pada pengembangan NLP untuk bahasa Indonesia."</em></p>
</blockquote>

<h2>Tips Tambahan</h2>
<ol>
    <li>Tulis abstrak setelah artikel selesai</li>
    <li>Hindari singkatan yang tidak umum</li>
    <li>Jangan cite referensi di abstrak</li>
    <li>Sertakan angka/hasil kuantitatif</li>
    <li>Maksimal 250 kata</li>
</ol>
HTML;
    }

    private function getContent6(): string
    {
        return <<<HTML
<h2>Tahapan Peer Review</h2>
<p>Proses peer review adalah jaminan kualitas artikel ilmiah. Berikut tahapannya:</p>

<h3>1. Submission</h3>
<p>Anda submit artikel melalui sistem OJS jurnal. Pastikan format sudah sesuai guidelines.</p>

<h3>2. Editorial Screening</h3>
<p>Editor memeriksa kelengkapan dan kesesuaian topik. Jika tidak sesuai, artikel langsung ditolak (desk rejection).</p>

<h3>3. Reviewer Assignment</h3>
<p>Editor menugaskan 2-3 reviewer yang ahli di bidang terkait. Biasanya double-blind review (reviewer dan author tidak saling tahu identitas).</p>

<h3>4. Review Process</h3>
<p>Reviewer membaca dan menilai artikel. Biasanya 2-8 minggu tergantung jurnal.</p>

<h3>5. Decision</h3>
<p>Keputusan yang mungkin:</p>
<ul>
    <li><strong>Accepted:</strong> Langsung diterima (jarang terjadi)</li>
    <li><strong>Minor Revision:</strong> Revisi kecil, biasanya accepted setelah revisi</li>
    <li><strong>Major Revision:</strong> Revisi besar, akan direview ulang</li>
    <li><strong>Rejected:</strong> Ditolak</li>
</ul>

<h3>6. Revision</h3>
<p>Jika dapat revision, perbaiki sesuai komentar reviewer dan submit ulang dengan response letter.</p>

<h3>7. Final Decision</h3>
<p>Setelah revisi diperiksa, editor membuat keputusan akhir.</p>

<h3>8. Publication</h3>
<p>Artikel accepted akan masuk antrian publikasi sesuai jadwal terbit jurnal.</p>

<h2>Tips Mempercepat Proses</h2>
<ul>
    <li>Submit artikel yang sudah matang</li>
    <li>Respon revisi dengan cepat dan lengkap</li>
    <li>Pilih jurnal dengan review time yang reasonable</li>
</ul>
HTML;
    }

    private function getContent7(): string
    {
        return <<<HTML
<h2>Berapa Similarity yang Aman?</h2>
<p>Umumnya, jurnal menerima similarity maksimal:</p>
<ul>
    <li><strong>SINTA 1-2:</strong> Maksimal 15-20%</li>
    <li><strong>SINTA 3-4:</strong> Maksimal 20-25%</li>
    <li><strong>SINTA 5-6:</strong> Maksimal 25-30%</li>
</ul>

<h2>Penyebab Similarity Tinggi</h2>
<ol>
    <li>Copy-paste dari sumber tanpa parafrase</li>
    <li>Self-plagiarism dari tulisan sendiri sebelumnya</li>
    <li>Kutipan langsung yang terlalu banyak</li>
    <li>Istilah teknis yang umum</li>
    <li>Daftar pustaka terdeteksi sebagai similarity</li>
</ol>

<h2>Cara Menurunkan Similarity</h2>

<h3>1. Parafrase dengan Benar</h3>
<p>Bukan sekadar mengganti sinonim! Parafrase yang benar:</p>
<ul>
    <li>Pahami dulu maksud kalimat asli</li>
    <li>Tutup sumber</li>
    <li>Tulis ulang dengan kata-kata sendiri</li>
    <li>Bandingkan dengan aslinya</li>
</ul>

<h3>2. Gunakan Kutipan Langsung Secukupnya</h3>
<p>Kutipan langsung ("...") boleh, tapi maksimal 10% dari total artikel.</p>

<h3>3. Tambah Analisis Original</h3>
<p>Bagian analisis dan pembahasan harusnya original. Inilah kontribusi Anda.</p>

<h3>4. Exclude Daftar Pustaka</h3>
<p>Saat cek di Turnitin, exclude bibliography dan quoted text.</p>

<h2>Warning!</h2>
<blockquote>
<p>Jangan pernah pakai "spinner" atau tools parafrase otomatis. Hasilnya tidak natural dan reviewer bisa mendeteksinya.</p>
</blockquote>
HTML;
    }

    private function getContent8(): string
    {
        return <<<HTML
<h2>Jurnal SINTA untuk Machine Learning</h2>
<p>Berikut rekomendasi jurnal SINTA yang menerima artikel di bidang machine learning, deep learning, dan AI:</p>

<h2>SINTA 3-4 (Rekomendasi Utama)</h2>
<ul>
    <li><strong>Jurnal RESTI</strong> - Fokus pada teknologi informasi dan sistem cerdas</li>
    <li><strong>JITK (Jurnal Ilmu Teknologi dan Komputer)</strong> - Menerima topik AI dan ML</li>
    <li><strong>Jurnal Teknologi Informasi dan Ilmu Komputer (JTIIK)</strong> - Universitas Brawijaya</li>
    <li><strong>JATISI</strong> - Sistem informasi dan teknologi</li>
</ul>

<h2>SINTA 5-6 (Proses Lebih Cepat)</h2>
<ul>
    <li><strong>JUTIK</strong> - Jurnal Teknologi Informasi dan Komputer</li>
    <li><strong>JIPTI</strong> - Jurnal Inovasi Pendidikan dan Teknologi Informasi</li>
    <li><strong>Antivirus</strong> - Jurnal Ilmiah Teknik Informatika</li>
    <li><strong>JACIS</strong> - Journal Automation Computer Information System</li>
</ul>

<h2>Tips Submit Artikel ML</h2>
<ol>
    <li>Jelaskan dataset dengan detail (sumber, ukuran, preprocessing)</li>
    <li>Bandingkan dengan baseline methods</li>
    <li>Sertakan confusion matrix dan metrics lengkap</li>
    <li>Diskusikan limitasi model Anda</li>
    <li>Gunakan visualisasi (grafik training, ROC curve, dll)</li>
</ol>

<h2>Topik ML yang Diminati 2024</h2>
<ul>
    <li>Natural Language Processing (NLP) Bahasa Indonesia</li>
    <li>Computer Vision untuk kasus lokal</li>
    <li>Sentiment Analysis media sosial</li>
    <li>Prediksi dan forecasting</li>
    <li>Healthcare AI</li>
</ul>
HTML;
    }

    private function getContent9(): string
    {
        return <<<HTML
<h2>Dapat Revision? Selamat!</h2>
<p>Mendapat revision (minor/major) sebenarnya adalah kabar baik. Artinya artikel Anda tidak langsung ditolak dan masih ada kesempatan untuk accepted.</p>

<h2>Cara Membaca Reviewer Comments</h2>
<p>Reviewer comments biasanya terdiri dari:</p>
<ul>
    <li><strong>General comments:</strong> Penilaian umum artikel</li>
    <li><strong>Specific comments:</strong> Koreksi per bagian</li>
    <li><strong>Minor issues:</strong> Typo, format, referensi</li>
    <li><strong>Major issues:</strong> Metodologi, analisis, kontribusi</li>
</ul>

<h2>Membuat Response Letter</h2>
<p>Response letter adalah dokumen terpisah yang menjelaskan perubahan Anda. Format yang baik:</p>

<blockquote>
<p><strong>Reviewer #1, Comment #1:</strong><br>
[Copy komentar reviewer]</p>
<p><strong>Response:</strong><br>
[Jelaskan bagaimana Anda merespon]<br>
[Sebutkan halaman dan baris yang diubah]</p>
</blockquote>

<h2>Tips Merespon dengan Profesional</h2>
<ol>
    <li><strong>Jangan defensif</strong> - Terima kritik dengan lapang dada</li>
    <li><strong>Ucapkan terima kasih</strong> - Apresiasi waktu reviewer</li>
    <li><strong>Jawab semua komentar</strong> - Jangan skip satupun</li>
    <li><strong>Jelaskan dengan detail</strong> - Tunjukkan Anda serius merevisi</li>
    <li><strong>Jika tidak setuju, jelaskan alasannya</strong> - Dengan sopan dan ilmiah</li>
</ol>

<h2>Highlight Perubahan</h2>
<p>Di artikel yang direvisi, highlight atau beri warna berbeda pada bagian yang diubah. Ini memudahkan reviewer mengecek revisi Anda.</p>
HTML;
    }

    private function getContent10(): string
    {
        return <<<HTML
<h2>Estimasi Waktu per Peringkat SINTA</h2>
<p>Berikut estimasi waktu dari submit hingga published:</p>

<table>
    <tr>
        <th>Peringkat</th>
        <th>Review Time</th>
        <th>Total (hingga Published)</th>
    </tr>
    <tr>
        <td>SINTA 1</td>
        <td>3-6 bulan</td>
        <td>6-12 bulan</td>
    </tr>
    <tr>
        <td>SINTA 2</td>
        <td>2-4 bulan</td>
        <td>4-8 bulan</td>
    </tr>
    <tr>
        <td>SINTA 3</td>
        <td>1-3 bulan</td>
        <td>3-6 bulan</td>
    </tr>
    <tr>
        <td>SINTA 4</td>
        <td>2-8 minggu</td>
        <td>1-3 bulan</td>
    </tr>
    <tr>
        <td>SINTA 5</td>
        <td>2-6 minggu</td>
        <td>1-2 bulan</td>
    </tr>
    <tr>
        <td>SINTA 6</td>
        <td>1-4 minggu</td>
        <td>2-6 minggu</td>
    </tr>
</table>

<h2>Faktor yang Mempengaruhi Waktu</h2>
<ul>
    <li><strong>Kualitas artikel:</strong> Artikel bagus lebih cepat diproses</li>
    <li><strong>Kelengkapan dokumen:</strong> Dokumen tidak lengkap = delay</li>
    <li><strong>Response time Anda:</strong> Cepat respon revisi = cepat selesai</li>
    <li><strong>Jadwal terbit jurnal:</strong> Ada yang bulanan, ada yang semesteran</li>
    <li><strong>Antrian artikel:</strong> Jurnal populer biasanya lebih lama</li>
</ul>

<h2>Tips Mempercepat Proses</h2>
<ol>
    <li>Pilih jurnal dengan frekuensi terbit tinggi (bulanan)</li>
    <li>Submit artikel yang sudah matang</li>
    <li>Respon revisi dalam 1-2 hari</li>
    <li>Ikuti guidelines dengan sempurna</li>
    <li>Komunikasi aktif dengan editor</li>
</ol>

<h2>Butuh Publikasi Cepat?</h2>
<p>Di Naskah Prima, kami membantu Anda menemukan jurnal dengan proses cepat tanpa mengorbankan kualitas. Rata-rata klien kami published dalam 18 hari!</p>
HTML;
    }
}
