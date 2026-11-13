# Let's Ride Belitung

Landing page untuk jasa rental mobil & transportasi di Belitung. Dibangun dengan Laravel 12 + Vite + Tailwind CSS, tanpa panel admin — konten kendaraan dikelola lewat database seeder.

## Fitur

- **Dwibahasa (ID/EN)** — routing berbasis prefix locale (`/id`, `/en`), default Bahasa Indonesia, dengan cek kelengkapan terjemahan di test suite.
- **Form permintaan booking** — validasi di server (`RentalInquiryRequest`), tanpa penyimpanan database. Form membangun pesan WhatsApp terformat dan mengembalikan URL `wa.me` untuk dikirim oleh pengunjung.
- **Layanan** — sewa mobil lepas kunci, sewa + driver (dengan rute), dan transfer bandara (nomor & jadwal penerbangan).
- **Fleet dinamis** — kendaraan dikelompokkan per kategori, hanya yang `is_published` tampil.
- **SEO** — `sitemap.xml` dinamis (`App\Support\Seo`), `robots.txt`, meta tag per-halaman, hreflang untuk kedua locale.
- **Tombol WhatsApp mengambang** untuk kontak langsung.

## Struktur Halaman

Hero → Layanan → Fleet → Keunggulan → Cara Pemesanan → Area Layanan → Form Booking → FAQ → CTA Akhir.

## Teknologi

| Komponen | Pilihan |
|---|---|
| Backend | Laravel 12, PHP ≥ 8.2 |
| Frontend | Vite 7, Tailwind CSS 4, vanilla JS (modul `app.js` + `motion.js`) |
| Database | MySQL (via Docker) |
| Server | Nginx + PHP-FPM (Docker Compose) |

## Menjalankan Proyek

### Lokal (tanpa Docker)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate

# set nomor WhatsApp bisnis (wajib agar form booking aktif)
# BUSINESS_WHATSAPP_NUMBER=628xxxxxxxxxx

php artisan migrate --seed
npm run dev
php artisan serve
```

### Docker

```bash
docker compose up -d
```

Aplikasi berjalan di `http://localhost:8088`. Compose bergantung pada jaringan eksternal `mysql_net` (container MySQL `mysql`) — sesuaikan `docker-compose.yml` bila setup database Anda berbeda.

## Testing

```bash
php artisan test
```

Coverage meliputi: routing locale, validasi & alur rental inquiry, SEO guardrail, kelengkapan terjemahan, dan model Vehicle.

## Konfigurasi Bisnis

Semua nilai bisnis ada di `config/business.php`, diisi via `.env`:

| Key | Keterangan |
|---|---|
| `BUSINESS_NAME` | Nama bisnis (default: Let's Ride Belitung) |
| `BUSINESS_WHATSAPP_NUMBER` | Nomor WA tujuan, format digit saja (`62...`). Kosong/tidak valid → form mengembalikan 503. |
