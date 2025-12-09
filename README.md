cat > README.md << 'EOF'

# 📚 DOKUMENTASI NASKAH PRIMA WEB V3

## Daftar Isi

1. [Overview](#overview)
2. [Fitur Admin Dashboard](#fitur-admin-dashboard)
3. [Fitur Landing Page](#fitur-landing-page)
4. [Fitur Blog](#fitur-blog)
5. [Fitur Tracking Client](#fitur-tracking-client)
6. [Panduan Penggunaan](#panduan-penggunaan)
7. [Artisan Commands](#artisan-commands)
8. [Maintenance & Scheduler](#maintenance--scheduler)
9. [Deployment ke Hosting](#deployment-ke-hosting)
10. [Troubleshooting](#troubleshooting)

---

## Overview

**Naskah Prima** adalah sistem manajemen publikasi jurnal ilmiah untuk mahasiswa informatika dengan fitur:

-   Dashboard Admin (Filament)
-   Landing Page
-   Blog System
-   Client Tracking
-   WhatsApp Integration
-   Auto Maintenance Scheduler

**Tech Stack:**

-   Laravel 10
-   Filament 3
-   MySQL
-   Tailwind CSS

---

## Fitur Admin Dashboard

### URL Akses

```
https://[domain]/admin
```

### Menu Utama

| Menu                 | Fungsi                |
| -------------------- | --------------------- |
| **Dashboard**        | Overview statistik    |
| **Client**           | Kelola data client    |
| **Naskah**           | Kelola naskah/artikel |
| **Mitra Jurnal**     | Kelola jurnal partner |
| **Message Template** | Template pesan WA     |

### Menu Landing Page

| Menu            | Fungsi                    |
| --------------- | ------------------------- |
| **Paket Harga** | Kelola pricing packages   |
| **Testimonial** | Kelola testimonial client |
| **FAQ**         | Kelola FAQ                |

### Menu Blog

| Menu           | Fungsi               |
| -------------- | -------------------- |
| **Blog Posts** | Kelola artikel blog  |
| **Kategori**   | Kelola kategori blog |
| **Tags**       | Kelola tags blog     |

### Menu Settings

| Menu                   | Fungsi                               |
| ---------------------- | ------------------------------------ |
| **Pengaturan Website** | Settings umum (WhatsApp, email, dll) |

---

## Fitur Landing Page

### URL Akses

```
https://[domain]/
```

### Sections

| Section         | Deskripsi               | Data Source                            |
| --------------- | ----------------------- | -------------------------------------- |
| **Hero**        | Banner utama            | Settings                               |
| **Problem**     | Pain points client      | Static                                 |
| **Solution**    | Keunggulan Naskah Prima | Static                                 |
| **Stats**       | Statistik real-time     | Database (Client, Naskah, MitraJurnal) |
| **Pricing**     | Paket harga             | Database (PricingPackage)              |
| **Testimonial** | Testimoni client        | Database (Testimonial)                 |
| **Process**     | Alur kerja              | Static                                 |
| **FAQ**         | Pertanyaan umum         | Database (Faq)                         |
| **Blog**        | Artikel terbaru         | Database (BlogPost)                    |
| **CTA**         | Call to action          | Settings                               |

---

## Fitur Blog

### URL Akses

```
https://[domain]/blog                    # List semua artikel
https://[domain]/blog/{slug}             # Detail artikel
https://[domain]/blog/category/{slug}    # Artikel per kategori
https://[domain]/blog/tag/{slug}         # Artikel per tag
```

### Fitur

| Fitur             | Deskripsi                                |
| ----------------- | ---------------------------------------- |
| **Search**        | Cari artikel berdasarkan judul/konten    |
| **Kategori**      | Filter artikel per kategori              |
| **Tags**          | Filter artikel per tag                   |
| **Pagination**    | 9 artikel per halaman                    |
| **Related Posts** | Artikel terkait (kategori sama)          |
| **Reading Time**  | Estimasi waktu baca (auto-calculate)     |
| **View Count**    | Hitung jumlah view                       |
| **SEO**           | Meta title, description, OG image        |
| **HTML Editor**   | Support paste HTML langsung              |
| **Auto Sitemap**  | Sitemap auto-generate saat publish       |
| **Auto Delete**   | Image otomatis dihapus saat post dihapus |

---

## Fitur Tracking Client

### URL Akses

```
https://[domain]/tracking/{token}
```

### Flow

1. Admin buka menu Client di dashboard
2. Klik "Kirim WA" → WhatsApp terbuka dengan link tracking
3. Client terima link → klik → lihat status artikel

### Status Naskah

| Status       | Warna  | Deskripsi                |
| ------------ | ------ | ------------------------ |
| Draft        | Gray   | Baru masuk               |
| Submitted    | Blue   | Sudah disubmit ke jurnal |
| Under Review | Yellow | Sedang direview          |
| Revision     | Yellow | Perlu revisi             |
| Accepted     | Green  | LOA keluar               |
| Published    | Green  | Sudah terbit             |
| Rejected     | Red    | Ditolak                  |

---

## Artisan Commands

| Command                                     | Fungsi                     |
| ------------------------------------------- | -------------------------- |
| `php artisan sitemap:generate`              | Generate sitemap manual    |
| `php artisan maintenance:cleanup`           | Jalankan maintenance       |
| `php artisan maintenance:cleanup --dry-run` | Test cleanup (tidak hapus) |
| `php artisan schedule:run`                  | Jalankan scheduler sekali  |
| `php artisan schedule:work`                 | Monitor scheduler (test)   |
| `php artisan optimize:clear`                | Clear semua cache          |
| `php artisan storage:link`                  | Link storage untuk uploads |

---

## Maintenance & Scheduler

### Apa yang Di-Maintenance?

| Task                   | Fungsi                           | Jadwal            |
| ---------------------- | -------------------------------- | ----------------- |
| **Orphan Images**      | Hapus gambar tidak terpakai      | Harian 02:00      |
| **Orphan Files**       | Hapus file naskah tidak terpakai | Harian 02:00      |
| **Old Logs**           | Hapus log > 30 hari              | Harian 02:00      |
| **Clear Cache**        | Bersihkan cache expired          | Mingguan (Senin)  |
| **Optimize Database**  | Defragment tabel MySQL           | Bulanan (tgl 1)   |
| **Regenerate Sitemap** | Update sitemap.xml               | Mingguan (Minggu) |

### Test di Localhost

```bash
# Test tanpa hapus
php artisan maintenance:cleanup --dry-run

# Jalankan beneran
php artisan maintenance:cleanup

# Monitor scheduler
php artisan schedule:work
```

---

## Deployment ke Hosting

### 🚀 STEP-BY-STEP DEPLOY KE RUMAHWEB

#### Step 1: Persiapan (di Localhost)

```bash
php artisan optimize:clear
git add .
git commit -m "Ready for deployment"
git push origin master
```

#### Step 2: Upload ke Hosting

**Via SSH:**

```bash
cd ~/public_html
git clone https://github.com/naskahprima/naskah_prima_web_v3.git .
```

**Atau via File Manager:** Upload semua file KECUALI `vendor/` dan `node_modules/`

#### Step 3: Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

#### Step 4: Setup Environment

```bash
cp .env.example .env
nano .env
```

**Edit `.env`:**

```env
APP_NAME="Naskah Prima"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://namadomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_db
DB_PASSWORD=password_db
```

#### Step 5: Generate Key & Migrate

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed
php artisan storage:link
```

#### Step 6: Set Permission

```bash
chmod -R 775 storage bootstrap/cache
```

#### Step 7: Setup Cron Job (PENTING!)

**Di cPanel → Cron Jobs → Add New:**

-   **Timing:** Once Per Minute `(* * * * *)`
-   **Command:**

```bash
cd /home/USERNAME/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

> ⚠️ Ganti `USERNAME` dengan username cPanel Anda

#### Step 8: Verifikasi

-   [ ] Buka `https://domain.com` - Landing page muncul
-   [ ] Buka `https://domain.com/admin` - Admin login muncul
-   [ ] Buka `https://domain.com/blog` - Blog muncul
-   [ ] Buka `https://domain.com/sitemap.xml` - Sitemap muncul
-   [ ] Test upload gambar di admin
-   [ ] Test maintenance: `php artisan maintenance:cleanup --dry-run`

---

### 📋 Checklist Deploy

```
[ ] .env sudah dikonfigurasi
[ ] APP_DEBUG=false
[ ] APP_URL pakai HTTPS
[ ] Database sudah di-migrate
[ ] Storage sudah di-link
[ ] Permission 775 untuk storage/
[ ] Cron job sudah di-setup
[ ] SSL aktif
[ ] Sitemap bisa diakses
[ ] Admin bisa login
```

---

### 🔧 Command Maintenance di Production

```bash
# Clear & rebuild cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Maintenance manual
php artisan maintenance:cleanup

# Regenerate sitemap
php artisan sitemap:generate
```

---

## Troubleshooting

| Masalah               | Solusi                                 |
| --------------------- | -------------------------------------- |
| Gambar tidak muncul   | `php artisan storage:link`             |
| Cache tidak update    | `php artisan optimize:clear`           |
| Sitemap tidak update  | `php artisan sitemap:generate`         |
| Class not found       | `composer dump-autoload`               |
| Permission denied     | `chmod -R 775 storage bootstrap/cache` |
| 500 Error             | Cek `storage/logs/laravel.log`         |
| Scheduler tidak jalan | Cek cron job di cPanel                 |

---

## Default Login Admin

```
URL: https://domain.com/admin
Email: admin@naskahprima.com
Password: admin123
```

> ⚠️ **SEGERA GANTI PASSWORD SETELAH DEPLOY!**

---

_Naskah Prima Web V3 - Last updated: December 2024_
EOF
