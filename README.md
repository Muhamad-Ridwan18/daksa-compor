# Daksa Company Profile Website

Website Company Profile yang dapat dikustomisasi dengan admin panel lengkap, blog, dan halaman karier (lowongan & lamaran).

## 🚀 Fitur Utama

### Frontend (Website Publik)
- Landing Page responsif (Hero, Tentang, Layanan, Produk)
- Testimonial & Logo Klien
- Formulir Kontak dan Pemesanan
- Blog: daftar artikel, detail artikel, komentar
- Careers: daftar lowongan, detail lowongan, kirim lamaran (unggah CV)
- Tema warna dinamis dari admin panel

### Admin Panel
- Dashboard statistik
- Manajemen Layanan (CRUD) + unggah gambar
- Manajemen Produk (relasi ke Layanan)
- Manajemen Pesanan (status tracking)
- Manajemen Testimonial
- Manajemen Logo Klien
- Manajemen Artikel & Komentar (moderasi)
- Manajemen Anggota Tim
- Manajemen Lowongan & Lamaran
- Pengaturan Website (termasuk tema warna)

## 🛠️ Teknologi

- Laravel 12 (PHP ^8.2)
- Tailwind CSS + Vite
- Database: MySQL atau SQLite (local dev)
- Autentikasi: Laravel Breeze
- Storage: Laravel Filesystem

## 📋 Persyaratan Sistem

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL (opsional, untuk produksi) / SQLite (bawaan untuk dev)
- Web Server (Apache/Nginx)

## ⚡ Quick Start (SQLite, Dev)

```bash
git clone <repository-url>
cd daksa-company-profile

composer install
npm install

cp .env.example .env
php artisan key:generate

# Siapkan database SQLite (composer script sudah menyiapkan jika belum ada)
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"

php artisan migrate --graceful
php artisan db:seed
php artisan storage:link

# Jalankan semua layanan dev (server, queue, logs, vite)
composer dev
```

Jika menggunakan MySQL, sesuaikan `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=daksa_compro
DB_USERNAME=root
DB_PASSWORD=
```

## 👤 Akun Admin

Buat akun admin:
```bash
php artisan make:user
```
Atau daftar via `/register` lalu atur role sesuai kebutuhan.

## 🧭 Routes Utama

### Frontend
- `GET /` — Home
- `POST /contact` — Kirim kontak
- `POST /order` — Kirim pesanan

### Blog
- `GET /blog` — Daftar artikel
- `GET /blog/{slug}` — Detail artikel
- `POST /blog/{article}/comment` — Kirim komentar

### Careers
- `GET /careers` — Daftar lowongan
- `GET /careers/{slug}` — Detail lowongan
- `POST /careers/{job}/apply` — Kirim lamaran (unggah CV)

### Admin (auth required, prefix `admin/`)
- Dashboard, Services, Products, Orders, Settings
- Articles, Comments (moderasi), Team Members
- Jobs, Job Applications (lihat, ubah status, unduh CV)

## 🎨 Kustomisasi Tema & Konten

- Ubah warna tema di menu Pengaturan (admin)
- Kelola Layanan, Produk, Testimonial, Logo Klien, Artikel, Tim, Lowongan

## 📁 Struktur Proyek (ringkas)

```
app/
├── Http/Controllers/{Admin,Frontend}
├── Models/
└── Services/

database/
├── migrations/
└── seeders/

resources/
├── views/{admin,frontend,layouts}
├── css/
└── js/

public/
└── storage/
```

## 🔧 Konfigurasi Tambahan

### Email (SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### Upload & Permissions
Pastikan `storage` dan `bootstrap/cache` writable (di Linux/Unix):
```bash
chmod -R 775 storage bootstrap/cache
```

## 🧪 Testing

```bash
php artisan test
```

## 🚀 Deployment (ringkas)

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Server minimal: PHP 8.2+, database (MySQL/SQLite), web server (Nginx/Apache), SSL dianjurkan.

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit (`git commit -m 'Add AmazingFeature'`)
4. Push (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📄 Lisensi

MIT. Lihat `LICENSE` jika tersedia.

## 📞 Dukungan

Buat issue jika menemukan masalah/ide.

---

Dibuat dengan ❤️ menggunakan Laravel & Tailwind CSS
