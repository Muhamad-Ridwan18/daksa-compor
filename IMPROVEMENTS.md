# Perbaikan yang Direkomendasikan

Prioritas: High (merah), Medium (oranye), Low (hijau)

## Arsitektur & Keamanan
- High: Tambahkan rate limiting pada endpoint publik (`/contact`, `/order`, komentar, lamaran kerja) untuk mencegah spam/abuse.
- High: Validasi upload file lebih ketat (CV, gambar): ukuran maksimum, tipe MIME whitelist, simpan di storage privat bila perlu dan sajikan via signed URL.
- High: Terapkan kebijakan otorisasi granular (Policies/Gates) untuk setiap resource admin; audit aksi penting (hapus, ubah status).
- High: Tambahkan reCAPTCHA/hCaptcha pada formulir publik (kontak, komentar, lamaran) dengan fallback non-JS.
- Medium: Tambahkan HTTP security headers (CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, HSTS) di middleware / web server.
- Medium: Pastikan sesi/cookies aman: `SESSION_SECURE_COOKIE=true`, `SAME_SITE=lax/strict`, domain cookie sesuai produksi.

## Kinerja & Reliabilitas
- High: Audit N+1 query dan tambahkan index DB (slug, foreign keys, email unik) untuk kinerja.
- High: Paginasi default pada semua listing publik/admin.
- Medium: Cache konfigurasi/theme dan query yang sering diakses (homepage, daftar blog, daftar karier) dengan invalidasi jelas.
- Medium: Proses email/notifikasi via queue dan jalankan worker ter-manage (Supervisor/Systemd) di produksi.
- Low: Optimasi gambar (resize, WebP, lazy loading), batas resolusi saat upload.

## Kualitas Kode & Test
- High: Gunakan Form Request untuk semua input publik dan semua CRUD admin.
- High: Tambahkan test Feature untuk kontak, order, komentar, apply job, dan alur CRUD admin (dengan otorisasi).
- Medium: Tambahkan test Unit untuk model relationship, accessor, dan service utilitas.
- Medium: Tambahkan CI (GitHub Actions) untuk lint, build, dan `php artisan test` pada PR.

## DX (Developer Experience)
- Medium: Lengkapi `.env.example` (SMTP dummy, storage disk, queue connection) dan dokumentasi env per environment.
- Medium: Tambahkan Docker Compose (PHP-FPM, Nginx, MySQL, Mailhog) agar onboarding cepat.
- Medium: Dokumentasikan `composer dev` lintas OS (Windows/Mac/Linux) dan ketergantungan.
- Low: Tambahkan `CONTRIBUTING.md` (branching, commit message, code style, review checklist) dan `SECURITY.md` (pelaporan kerentanan).

## Fitur Produk
- Medium: Blog — moderasi komentar yang jelas (pending/approved), notifikasi admin.
- Medium: Careers — batas frekuensi apply per email/job, verifikasi email opsional, auto-reply pelamar.
- Medium: Settings — versi & audit trail perubahan (siapa/apa/kapan), opsi rollback.
- Low: SEO — meta tags dinamis, Open Graph/Twitter cards, sitemap & robots terbarui.
- Low: Aksesibilitas — kontras warna, fokus visible, label form konsisten, skip links.

## Operasional & Observabilitas
- High: Backup database dan storage terjadwal, uji restore berkala.
- Medium: Centralized logging/monitoring (Sentry/Bugsnag/Logtail), alert untuk error level tinggi.
- Medium: Health check endpoint untuk load balancer/monitoring.

## Dokumentasi
- Medium: Sinkronkan versi Laravel (saat ini Laravel 12).
- Medium: Tambahkan diagram flow (auth, order, apply job) dan ERD singkat.
- Low: Contoh `.env` MySQL/SQLite di README (sudah ditambahkan) dan panduan migration/seed.

---

Jika diinginkan, saya bisa mulai dari prioritas High (rate limit, validasi upload, policies, reCAPTCHA) lalu menambahkan CI + tests dasar sesudahnya.


