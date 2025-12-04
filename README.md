# 📚 DOKUMENTASI NASKAH PRIMA WEB V3

## Daftar Isi

1. [Overview](#overview)
2. [Fitur Admin Dashboard](#fitur-admin-dashboard)
3. [Fitur Landing Page](#fitur-landing-page)
4. [Fitur Blog](#fitur-blog)
5. [Fitur Tracking Client](#fitur-tracking-client)
6. [Panduan Penggunaan](#panduan-penggunaan)

---

## Overview

**Naskah Prima** adalah sistem manajemen publikasi jurnal ilmiah untuk mahasiswa informatika dengan fitur:

-   Dashboard Admin (Filament)
-   Landing Page
-   Blog System
-   Client Tracking
-   WhatsApp Integration

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
| **CTA**         | Call to action          | Settings                               |

### Statistik Dinamis

| Stat             | Kalkulasi                                                  |
| ---------------- | ---------------------------------------------------------- |
| **Total Klien**  | `Client::count() + 20` (20 = legacy clients)               |
| **Success Rate** | `(Naskah Published / Total Naskah) * 100`                  |
| **Avg Days**     | Default 18 hari                                            |
| **Mitra Jurnal** | `MitraJurnal::where('status_kerjasama', 'aktif')->count()` |

---

## Fitur Blog

### URL Akses

```
https://[domain]/blog                    # List semua artikel
https://[domain]/blog/{slug}             # Detail artikel
https://[domain]/blog/category/{slug}    # Artikel per kategori
https://[domain]/blog/tag/{slug}         # Artikel per tag
```

### Fitur Blog

| Fitur             | Deskripsi                             |
| ----------------- | ------------------------------------- |
| **Search**        | Cari artikel berdasarkan judul/konten |
| **Kategori**      | Filter artikel per kategori           |
| **Tags**          | Filter artikel per tag                |
| **Pagination**    | 9 artikel per halaman                 |
| **Related Posts** | Artikel terkait (kategori sama)       |
| **Reading Time**  | Estimasi waktu baca (auto-calculate)  |
| **View Count**    | Hitung jumlah view                    |
| **SEO**           | Meta title, description, OG image     |

### Auto-Generate Sitemap

Sitemap otomatis di-generate saat:

-   Blog post dibuat/diedit dengan status `published`
-   Blog post dihapus

**URL Sitemap:**

```
https://[domain]/sitemap.xml
```

### Manual Generate Sitemap

```bash
php artisan sitemap:generate
```

---

## Fitur Tracking Client

### Konsep

Client dapat memantau status artikel mereka melalui link unik yang dikirim via WhatsApp.

### URL Akses

```
https://[domain]/tracking/{token}
```

Token adalah string random 32 karakter, unique per client.

### Flow Penggunaan

```
1. Admin buka menu Client di dashboard
2. Klik "Kirim WA" → WhatsApp terbuka dengan template pesan + link tracking
3. Atau klik kolom "Link Tracking" → link tercopy
4. Client terima link → klik → lihat status artikel
```

### Data yang Ditampilkan ke Client

| Data              | Deskripsi                                                                      |
| ----------------- | ------------------------------------------------------------------------------ |
| Judul Artikel     | Judul naskah                                                                   |
| Jurnal Tujuan     | Nama jurnal target                                                             |
| Tanggal Masuk     | Kapan naskah diterima                                                          |
| Target Publish    | Target bulan publikasi                                                         |
| Tanggal Published | Tanggal terbit (jika sudah)                                                    |
| Status Timeline   | Visual progress (Draft → Submitted → Review → Revision → Accepted → Published) |
| Catatan Progress  | Notes dari admin                                                               |

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

### Tracking Analytics

Admin dapat melihat:

-   Kapan terakhir client membuka link tracking
-   Di kolom "Tracking Dibuka" pada tabel Client

---

## Panduan Penggunaan

### 1. Menambah Client Baru

```
Dashboard → Client → New Client
```

Isi form:

-   Nama Lengkap (required)
-   Email (required)
-   No. WhatsApp (required)
-   Institusi
-   Catatan Khusus

**Tracking token otomatis di-generate saat client dibuat.**

### 2. Menambah Naskah

```
Dashboard → Naskah → New Naskah
```

Isi form:

-   Judul Naskah (required)
-   Pilih Client (required)
-   Bidang/Topik
-   Jurnal Target
-   Target Bulan Publish
-   Tanggal Masuk (required)
-   Status
-   Upload File Naskah
-   Catatan Progress

### 3. Update Status Naskah

```
Dashboard → Naskah → Edit → Ubah Status → Save
```

Status akan otomatis terlihat di halaman tracking client.

### 4. Kirim Link Tracking ke Client

**Cara 1: Via WhatsApp (Recommended)**

```
Dashboard → Client → Klik "Kirim WA"
```

WhatsApp akan terbuka dengan template pesan berisi link tracking.

**Cara 2: Copy Link Manual**

```
Dashboard → Client → Klik kolom "Link Tracking"
```

Link akan tercopy, bisa di-paste ke mana saja.

### 5. Menambah Blog Post

```
Dashboard → Blog Posts → New Blog Post
```

Isi form:

-   Judul (required)
-   Kategori
-   Content (required)
-   Excerpt
-   Featured Image
-   Tags
-   Status (Draft/Published)
-   SEO fields (optional)

**Catatan:** Sitemap otomatis di-update saat publish.

### 6. Mengelola Pricing

```
Dashboard → Paket Harga → Edit
```

Setiap package punya:

-   Items (harga per SINTA level)
-   Features (fitur yang termasuk)

### 7. Mengelola FAQ

```
Dashboard → FAQ → Edit/Create
```

FAQ otomatis tampil di landing page.

### 8. Mengelola Settings

```
Dashboard → Pengaturan Website
```

Settings yang bisa diubah:

-   WhatsApp Number
-   Email
-   Hero Section Text
-   Meta Description
-   dll

---

## Environment Variables

```env
APP_URL=https://naskahprima.com
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

---

## Artisan Commands

| Command                        | Fungsi                     |
| ------------------------------ | -------------------------- |
| `php artisan sitemap:generate` | Generate sitemap manual    |
| `php artisan optimize:clear`   | Clear semua cache          |
| `php artisan migrate`          | Jalankan migrations        |
| `php artisan storage:link`     | Link storage untuk uploads |

---

## Troubleshooting

### Gambar tidak muncul

```bash
php artisan storage:link
```

### Cache tidak update

```bash
php artisan optimize:clear
```

### Sitemap tidak update

```bash
php artisan sitemap:generate
```

### Class not found

```bash
composer dump-autoload
```

---

## Contact Support

Untuk bantuan teknis, hubungi developer.

---

_Dokumentasi ini dibuat untuk Naskah Prima Web V3_
_Last updated: December 2024_
