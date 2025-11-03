-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2025 at 02:11 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daksa_compro`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `author_id`, `is_published`, `published_at`, `views`, `created_at`, `updated_at`) VALUES
('019a108c-c2f1-73de-b664-83e38fce8123', 'Panduan Lengkap Digital Marketing untuk UMKM', 'panduan-lengkap-digital-marketing-untuk-umkm', 'Pelajari strategi digital marketing yang efektif untuk mengembangkan bisnis UMKM Anda di era digital.', '<h2>Mengapa Digital Marketing Penting untuk UMKM?</h2><p>Di era digital seperti sekarang, kehadiran online bukan lagi pilihan, melainkan keharusan bagi setiap bisnis, termasuk UMKM. Digital marketing memberikan peluang yang setara bagi bisnis kecil untuk bersaing dengan perusahaan besar.</p><h3>Manfaat Digital Marketing</h3><ul><li>Jangkauan pasar yang lebih luas</li><li>Biaya promosi yang lebih efisien</li><li>Targeting audience yang lebih tepat</li><li>Hasil yang terukur dan dapat dianalisis</li></ul><h3>Strategi Digital Marketing yang Efektif</h3><p>Berikut adalah beberapa strategi digital marketing yang dapat diterapkan oleh UMKM:</p><ol><li><strong>Social Media Marketing</strong> - Manfaatkan platform seperti Instagram, Facebook, dan TikTok untuk membangun brand awareness.</li><li><strong>Content Marketing</strong> - Buat konten yang berkualitas dan relevan untuk menarik perhatian target audience.</li><li><strong>SEO (Search Engine Optimization)</strong> - Optimalkan website agar mudah ditemukan di mesin pencari.</li><li><strong>Email Marketing</strong> - Bangun database pelanggan dan kirimkan newsletter secara berkala.</li></ol><p>Dengan menerapkan strategi-strategi di atas secara konsisten, UMKM dapat meningkatkan visibilitas online dan mengembangkan bisnis dengan lebih cepat.</p>', 'articles/M99NpRCXelNF5uHNwoYpzCjClWmWm1sT8NPBDx5v.jpg', 1, 1, '2025-10-13 03:10:49', 146, '2025-10-23 03:10:51', '2025-10-29 05:09:47'),
('019a108c-c3f3-700a-8637-2e9cac2dff58', '10 Tips Membangun Website yang User-Friendly', '10-tips-membangun-website-yang-user-friendly', 'Website yang user-friendly adalah kunci kesuksesan bisnis online. Simak tips-tips berikut untuk menciptakan website yang nyaman bagi pengunjung.', '<h2>Pentingnya User Experience dalam Website</h2><p>User experience (UX) yang baik dapat meningkatkan konversi, mengurangi bounce rate, dan membangun kepercayaan pengunjung terhadap brand Anda.</p><h3>10 Tips Praktis</h3><ol><li><strong>Desain yang Responsif</strong> - Pastikan website dapat diakses dengan baik di semua device, baik desktop, tablet, maupun smartphone.</li><li><strong>Navigasi yang Intuitif</strong> - Buat struktur menu yang jelas dan mudah dipahami.</li><li><strong>Kecepatan Loading</strong> - Optimalkan performa website agar loading time tidak lebih dari 3 detik.</li><li><strong>Konten yang Berkualitas</strong> - Sajikan informasi yang relevan, akurat, dan mudah dipahami.</li><li><strong>Call-to-Action yang Jelas</strong> - Buat tombol CTA yang menarik perhatian dan mudah ditemukan.</li><li><strong>Konsistensi Visual</strong> - Gunakan skema warna dan typography yang konsisten di seluruh halaman.</li><li><strong>Formulir yang Sederhana</strong> - Minimalkan jumlah field yang harus diisi pengguna.</li><li><strong>Search Functionality</strong> - Sediakan fitur pencarian untuk memudahkan pengguna menemukan informasi.</li><li><strong>Aksesibilitas</strong> - Pastikan website dapat diakses oleh semua orang, termasuk penyandang disabilitas.</li><li><strong>Trust Signals</strong> - Tampilkan testimonial, sertifikat, atau badge untuk membangun kepercayaan.</li></ol><p>Dengan menerapkan tips-tips di atas, Anda dapat menciptakan website yang tidak hanya menarik secara visual, tetapi juga nyaman dan efektif dalam mencapai tujuan bisnis.</p>', 'articles/zAt6ztWKFS7sJqNvF9n7iCHNbiqUDWZt0a1lyo5i.jpg', 1, 1, '2025-10-16 03:10:49', 111, '2025-10-23 03:10:52', '2025-10-29 05:04:09'),
('019a108c-c3f9-70b3-ae1f-22686c042d59', 'Tren Desain Web 2024 yang Wajib Anda Ketahui', 'tren-desain-web-2024-yang-wajib-anda-ketahui', 'Industri web design terus berkembang. Ikuti tren terkini agar website Anda tetap relevan dan menarik di mata pengunjung.', '<h2>Tren Desain Web di Tahun 2024</h2><p>Dunia desain web terus berkembang mengikuti perubahan teknologi dan preferensi pengguna. Berikut adalah beberapa tren yang mendominasi tahun 2024.</p><h3>1. Dark Mode</h3><p>Dark mode semakin populer karena memberikan kenyamanan mata, terutama saat browsing di malam hari. Banyak website kini menyediakan opsi untuk beralih antara light dan dark mode.</p><h3>2. Minimalist Design</h3><p>Less is more. Desain minimalis dengan banyak white space memberikan fokus yang lebih baik pada konten utama dan meningkatkan user experience.</p><h3>3. Micro-Interactions</h3><p>Animasi kecil yang responsif terhadap aksi pengguna membuat website terasa lebih hidup dan interaktif.</p><h3>4. 3D Elements</h3><p>Penggunaan elemen 3D dan ilustrasi yang immersive memberikan pengalaman visual yang lebih menarik.</p><h3>5. Sustainability</h3><p>Green web design yang fokus pada efisiensi energi dan performa optimal menjadi pertimbangan penting.</p><p>Menggabungkan tren-tren ini dengan cara yang bijak dapat membuat website Anda stand out dari kompetitor dan memberikan pengalaman yang memorable bagi pengunjung.</p>', 'articles/Fk76eo3CnUqYDjVVQR4V8urltgYPIyGVUqYoa0dF.jpg', 1, 1, '2025-10-20 03:10:49', 68, '2025-10-23 03:10:52', '2025-10-27 17:59:43'),
('019a108c-c3fe-7126-b562-c8c41b14c6e3', 'Strategi SEO untuk Meningkatkan Ranking Website Anda', 'strategi-seo-untuk-meningkatkan-ranking-website-anda', 'SEO adalah investasi jangka panjang untuk bisnis online. Pelajari strategi SEO yang terbukti efektif meningkatkan ranking di Google.', '<h2>Memahami SEO di Era Modern</h2><p>Search Engine Optimization (SEO) adalah proses mengoptimalkan website agar mendapat peringkat tinggi di hasil pencarian organik. SEO yang baik dapat meningkatkan traffic berkualitas ke website Anda.</p><h3>On-Page SEO</h3><ul><li>Riset keyword yang tepat</li><li>Optimasi title tag dan meta description</li><li>Struktur heading yang baik (H1, H2, H3)</li><li>Internal linking yang strategis</li><li>URL yang SEO-friendly</li><li>Optimasi gambar dengan alt text</li></ul><h3>Technical SEO</h3><ul><li>Kecepatan loading website</li><li>Mobile-friendliness</li><li>SSL certificate (HTTPS)</li><li>Sitemap XML</li><li>Robots.txt yang tepat</li><li>Structured data markup</li></ul><h3>Off-Page SEO</h3><ul><li>Backlink building dari website berkualitas</li><li>Social media signals</li><li>Guest posting</li><li>Brand mentions</li></ul><h3>Content Marketing</h3><p>Konten berkualitas adalah raja dalam SEO. Buat konten yang:</p><ul><li>Relevan dengan target audience</li><li>Informatif dan mendalam</li><li>Fresh dan up-to-date</li><li>Original dan unik</li></ul><p>Ingat, SEO adalah marathon bukan sprint. Konsistensi dan kesabaran adalah kunci kesuksesan dalam SEO.</p>', 'articles/EV820mbUZnv0knTJv9K59xnbc0KgzSUfb9OwmIyM.jpg', 1, 1, '2025-10-22 03:10:49', 124, '2025-10-23 03:10:52', '2025-10-28 08:22:38'),
('019a108c-c403-7325-94b9-2659260197e4', 'Cara Memilih Platform E-Commerce yang Tepat untuk Bisnis Anda', 'cara-memilih-platform-e-commerce-yang-tepat-untuk-bisnis-anda', 'Memilih platform e-commerce yang tepat adalah keputusan penting. Panduan ini akan membantu Anda membuat pilihan yang bijak.', '<h2>Pentingnya Memilih Platform E-Commerce yang Tepat</h2><p>Platform e-commerce adalah fondasi dari toko online Anda. Pilihan yang salah dapat menghambat pertumbuhan bisnis dan menyebabkan biaya tambahan di masa depan.</p><h3>Faktor yang Perlu Dipertimbangkan</h3><ol><li><strong>Budget</strong> - Pertimbangkan biaya setup, biaya bulanan, dan biaya transaksi.</li><li><strong>Kemudahan Penggunaan</strong> - Platform harus user-friendly baik untuk admin maupun pelanggan.</li><li><strong>Skalabilitas</strong> - Pastikan platform dapat berkembang seiring pertumbuhan bisnis.</li><li><strong>Fitur</strong> - Inventori management, payment gateway, shipping integration, dll.</li><li><strong>Customization</strong> - Seberapa fleksibel platform untuk disesuaikan dengan kebutuhan.</li><li><strong>SEO Friendly</strong> - Platform harus mendukung optimasi SEO.</li><li><strong>Support & Security</strong> - Customer support yang responsif dan keamanan yang terjamin.</li></ol><h3>Platform Populer</h3><ul><li><strong>Shopify</strong> - Mudah digunakan, banyak template, cocok untuk pemula hingga menengah.</li><li><strong>WooCommerce</strong> - Open source, fleksibel, cocok untuk pengguna WordPress.</li><li><strong>Magento</strong> - Powerful, scalable, cocok untuk enterprise.</li><li><strong>BigCommerce</strong> - Fitur lengkap, no transaction fees.</li></ul><p>Pilihlah platform yang sesuai dengan kebutuhan bisnis, technical capability, dan budget Anda. Jangan ragu untuk mencoba trial version sebelum membuat keputusan final.</p>', 'articles/8AvovWEHq3r90myvfA0ZXizFor4ZkLOT4pyJXKeU.jpg', 1, 1, '2025-10-27 18:00:11', 8, '2025-10-23 03:10:52', '2025-10-29 05:54:32');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@example.com|127.0.0.1', 'i:1;', 1761553479),
('laravel-cache-admin@example.com|127.0.0.1:timer', 'i:1761553479;', 1761553479);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `logo`, `website`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('019a0ff8-dd7a-7384-b12d-00aff4c9e711', 'PT. cakra trikamulya samudra', 'clients/APhPvBhIPFh1zMqvjh7aSk4kFYixdrXUIxlrypxe.png', 'https://teknologimaju.com', 1, 1, '2025-10-23 00:29:19', '2025-10-28 05:59:15'),
('019a0ff8-dd95-73cc-bcc6-075744bd6700', 'PT mandalika gemilang distribusi', 'clients/Q5xXXU08doWBQI0jxx3QqX4Ie0ZJbEYJGVT1UpOg.png', 'https://digitalsolutions.id', 1, 2, '2025-10-23 00:29:19', '2025-10-28 05:59:41'),
('019a0ff8-dd9a-7265-a0f4-65947df53775', 'PT. Kian gemilang jaya', 'clients/PkSnGJiILGUNuXzkx8W7bvcfOo7eXtGTdmo1AOz7.png', 'https://inovasidigital.co.id', 1, 3, '2025-10-23 00:29:19', '2025-10-28 06:00:05'),
('019a0ff8-dd9e-72eb-ae2b-3a47f9969413', 'PT. Bumi swasti artha', 'clients/uEum2V0On36JTL4tGRplK3INfLeOG2ohzi8hSSt4.png', 'https://startuptech.id', 1, 4, '2025-10-23 00:29:19', '2025-10-28 06:01:13'),
('019a0ff8-dda2-71c5-a5bd-3b4bc0a1645d', 'Security satgas', 'clients/DgOAdaFTjQi4pBzaNJrxrF0mXKBQUdQCeE0FuOnq.jpg', 'https://kreatifdigital.com', 1, 5, '2025-10-23 00:29:19', '2025-10-28 06:01:43'),
('019a0ff8-dda6-7232-8650-70c0f1bc6afc', 'Bandung inten indah', 'clients/XN4CHujaKWyYsGFEr17Fwhur6Jgy8ppTeh7cqI9h.png', 'https://techcorp.solutions', 1, 6, '2025-10-23 00:29:19', '2025-10-28 06:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `name`, `email`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
('019a2b2b-c1b4-7371-9d12-085dcdc85561', '019a108c-c403-7325-94b9-2659260197e4', 'Rahma', 'rahma@gmail.com', 'kometar pedas', 1, '2025-10-28 07:14:39', '2025-10-28 08:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
('019a2b22-ff86-73d8-ae39-3ca275b3daaa', 'Test', 'testoperator@gmail.com', 'pesan nya adalah ini', 1, '2025-10-28 07:05:05', '2025-10-28 09:16:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portfolio_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_letter` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `name`, `email`, `phone`, `cv_path`, `portfolio_url`, `cover_letter`, `status`, `created_at`, `updated_at`) VALUES
('019a344c-c08d-7312-abfa-b10667fd7941', '019a344b-2330-71a6-a0f7-1e310728409d', 'Andi Wijaya', 'andi@example.com', '081234567890', NULL, 'https://portfolio.example.com/andi', 'Saya tertarik bergabung dan punya pengalaman sesuai kualifikasi.', 'received', '2025-10-30 01:47:16', '2025-10-30 01:47:16'),
('019a344c-c09e-7158-a55f-7e843360bbc3', '019a344b-234b-709d-8da5-b4eb47dc7c85', 'Bunga Sari', 'bunga@example.com', '082233445566', NULL, NULL, 'Berpengalaman 3 tahun, siap berkontribusi.', 'reviewed', '2025-10-30 01:47:16', '2025-10-30 01:47:16'),
('019a344c-c0a3-732c-9530-d912ac94837c', '019a344b-2350-7209-bbc6-5d1f2cff0d5c', 'Chandra Putra', 'chandra@example.com', '081987654321', NULL, 'https://dribbble.com/chandrap', 'Tertarik di posisi terkait desain dan UX.', 'interviewed', '2025-10-30 01:47:16', '2025-10-30 01:47:16'),
('019a3450-94a3-70b0-b47b-c08582673d29', '019a344b-2330-71a6-a0f7-1e310728409d', 'ADUL', 'aduk@gmail.com', '0881081871528', 'applications/AMbYrgLbQ2tpEwvER7R6gpEpmvesdHRLnxdaYQLg.pdf', 'https://jaksimpus.jakarta.go.id/apps/pasukanputih/users?role=operator', 'saya sangat tertarik', 'received', '2025-10-30 01:51:27', '2025-10-30 01:51:27'),
('019a346e-9875-738e-8b74-65d799aacfa8', '019a344b-2350-7209-bbc6-5d1f2cff0d5c', 'TEST OPERATOR', 'testingperawat@gmail.com', '0881081871528', 'applications/JwMfUmF9ovLn89lcPq9dvJHwzcCuNmBYgoaGPcQ6.pdf', 'https://jaksimpus.jakarta.go.id/apps/pasukanputih/users?role=operator', 'Saya tertarik', 'received', '2025-10-30 02:24:14', '2025-10-30 02:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_services_table', 1),
(5, '2024_01_01_000002_create_products_table', 1),
(6, '2024_01_01_000003_create_orders_table', 1),
(7, '2024_01_01_000004_create_clients_table', 1),
(8, '2024_01_01_000005_create_testimonials_table', 1),
(9, '2024_01_01_000006_create_contact_messages_table', 1),
(10, '2024_01_01_000007_create_settings_table', 1),
(11, '2024_01_01_000008_create_articles_table', 2),
(12, '2024_01_01_000009_create_comments_table', 2),
(13, '2025_10_28_000010_add_features_to_products_table', 3),
(14, '2025_10_30_000011_create_team_members_table', 4),
(15, '2025_10_30_000012_create_jobs_table', 5),
(16, '2025_10_30_000013_create_job_applications_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','processed','done') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `name`, `email`, `phone`, `notes`, `status`, `created_at`, `updated_at`) VALUES
('019a111f-eafd-72e5-81cf-25f579a41599', '019a0f9c-ff51-7335-8e03-18f75affe9ef', 'Ridwan', 'mrdwn1812@gmail.com', '0881081871528', 'Saya tertarik dengan paket ini', 'pending', '2025-10-23 05:51:35', '2025-10-23 05:51:35'),
('019a2515-6d70-7098-95d7-fa4907d15df1', '019a0f9c-ff51-7335-8e03-18f75affe9ef', 'Test', 'admin@gmail.com', '0881081871528', 'testing', 'done', '2025-10-27 02:52:32', '2025-10-28 08:09:04'),
('019a2fe4-0b87-7044-99d7-781d45a66a63', '019a0f9c-ff51-7335-8e03-18f75affe9ef', 'Pemesan', 'pemesan@gmail.com', '0881081871528', 'saya ingin menggunakan jasa ini', 'pending', '2025-10-29 05:14:25', '2025-10-29 05:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` json DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `service_id`, `name`, `description`, `features`, `price`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('019a0f9c-ff51-7335-8e03-18f75affe9ef', '019a0f9c-fed1-712e-9115-43ce568939d3', 'Website Company Profile', 'Website company profile profesional dengan desain modern dan responsive.', '[\"Harga terjangkau\", \"support 24/7\", \"Konsultasi dimana sana\"]', 5000000.00, NULL, 1, 1, '2025-10-22 22:48:58', '2025-10-28 07:56:20'),
('019a0f9c-ff57-71c2-a326-5d71b707217f', '019a0f9c-fed1-712e-9115-43ce568939d3', 'E-commerce Website', 'Website toko online lengkap dengan sistem pembayaran dan manajemen produk.', NULL, 15000000.00, NULL, 1, 2, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff5c-728d-af2c-0388b9e8c913', '019a0f9c-fed1-712e-9115-43ce568939d3', 'Custom Web Application', 'Aplikasi web custom sesuai kebutuhan bisnis Anda.', '[\"Harga terjangkau\", \"Support 24/7\", \"pilihan terrbaik\", \"dan lain lain\"]', 25000000.00, NULL, 1, 3, '2025-10-22 22:48:58', '2025-10-29 05:18:52'),
('019a0f9c-ff60-73a0-8caa-e692bacd2e9e', '019a0f9c-feda-727c-86e6-71ecfdbea83f', 'iOS App Development', 'Pengembangan aplikasi iOS native dengan performa optimal.', NULL, 30000000.00, NULL, 1, 1, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff63-711b-bbc6-c432fcb161b7', '019a0f9c-feda-727c-86e6-71ecfdbea83f', 'Android App Development', 'Pengembangan aplikasi Android native dengan UI/UX yang menarik.', NULL, 25000000.00, NULL, 1, 2, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff66-70e1-929e-70a618e9ab93', '019a0f9c-feda-727c-86e6-71ecfdbea83f', 'Cross-Platform App', 'Aplikasi mobile yang dapat berjalan di iOS dan Android sekaligus.', NULL, 20000000.00, NULL, 1, 3, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff6a-72f4-b208-f32108e343a2', '019a0f9c-fedd-7348-ac24-7cbc0a58e9b7', 'Social Media Management', 'Manajemen akun media sosial dengan konten berkualitas dan strategi yang tepat.', NULL, 3000000.00, NULL, 1, 1, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff6e-71fc-b7e6-e639715d61b0', '019a0f9c-fedd-7348-ac24-7cbc0a58e9b7', 'SEO Optimization', 'Optimasi SEO untuk meningkatkan ranking website di mesin pencari.', NULL, 5000000.00, NULL, 1, 2, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff71-7048-bdc2-b2069e7ae06a', '019a0f9c-fedd-7348-ac24-7cbc0a58e9b7', 'Google Ads Campaign', 'Kampanye iklan Google Ads untuk meningkatkan traffic dan konversi.', NULL, 2000000.00, NULL, 1, 3, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff75-7314-950f-218a6bdbebe3', '019a0f9c-fee1-7177-8ba7-d86670afaf6c', 'IT Strategy Consultation', 'Konsultasi strategi IT untuk transformasi digital bisnis Anda.', NULL, 10000000.00, NULL, 1, 1, '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-ff77-7054-b215-7f229317d6c7', '019a0f9c-fee1-7177-8ba7-d86670afaf6c', 'System Architecture Design', 'Desain arsitektur sistem yang scalable dan maintainable.', NULL, 15000000.00, NULL, 1, 2, '2025-10-22 22:48:58', '2025-10-22 22:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('019a0f9c-fed1-712e-9115-43ce568939d3', 'Accounting Service', 'Kami menyusun laporan Laba rugi, neraca, perubahan modal, arus Kas dan Catatan atas Laporan Keuangan sesuai dengan aturan PSAK yang berlaku, supaya laporan tersebut bisa dijadikan sebagai pengambilan keputusan yang paling tepat untuk bisnis perusahaan yang sedang dijalani', 'services/TmzWTHGq2qXk2zlGZHPhit77zRevdV0iWlegmhJQ.jpg', 1, 1, '2025-10-22 22:48:58', '2025-10-29 05:21:13'),
('019a0f9c-feda-727c-86e6-71ecfdbea83f', 'Tax Service', 'Kami menyediakan layanan perencanaan pajak berkala untuk membantu menghindari risiko lebih bayar. Perencanaan dilakukan dengan pemahaman dan keahlian sesuai peraturan perpajakan yang berlaku, untuk memastikan strategi yang aman dan tepat.', 'services/ByLiTP36DOqkN0Ip4c5JhGGR35AocLl1c5IJlhYn.png', 1, 2, '2025-10-22 22:48:58', '2025-10-23 05:49:41'),
('019a0f9c-fedd-7348-ac24-7cbc0a58e9b7', 'Pembuatan Legalitas Perusahaan', 'Kami membantu mengurus legalitas perusahaan seperti pendirian PT, CV, pembuatan izin usaha, dan dokumen resmi lainnya. Semua proses dilakukan sesuai peraturan yang berlaku, sehingga usaha Anda memiliki dasar hukum yang kuat dan aman untuk beroperasi.', 'services/6VNUxuRjcslTb7CrNyDkWYOjqUCBcnpuPx1dSJ2f.png', 1, 3, '2025-10-22 22:48:58', '2025-10-23 05:50:22'),
('019a0f9c-fee1-7177-8ba7-d86670afaf6c', 'Implementasi Sistem Keuangan', 'Kami membantu implementasi sistem keuangan menggunakan Accurate untuk mempermudah pencatatan, pelaporan, dan pengelolaan\r\nkeuangan. Proses dilakukan dari instalasi,\r\npengaturan awal, hingga pelatihan penggunaan,\r\nsehingga sistem dapat berjalan optimal dan sesuai kebutuhan bisnis Anda.', 'services/IIYSw2SP0HYSPDBFhLnP9HVKowkpjPFRTH4SmOEL.png', 1, 4, '2025-10-22 22:48:58', '2025-10-23 05:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3Rd0NLAnkOAPUDG1IO3qg0x6v16nOAJWc8AIR6Nb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib3RHbzRndVZpb2hWa3JMMGRJQVhIaHhxTGlxQWZUVWc3SGtWUk92SiI7czo2OiJzdGF0dXMiO3M6NjQ6IlNlc2kgYmVyYWtoaXIga2FyZW5hIHRpZGFrIGFkYSBha3Rpdml0YXMuIFNpbGFrYW4gbG9naW4ga2VtYmFsaS4iO3M6NjoiX2ZsYXNoIjthOjI6e3M6MzoibmV3IjthOjA6e31zOjM6Im9sZCI7YToxOntpOjA7czo2OiJzdGF0dXMiO319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO319', 1761899178),
('Gbb857Z0Pntvqqiici1iW6xM6kl6iD19zOPBHv2o', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEZmYU4wRGhaU0tZeFlnMnZBOHFubmIyTEU5cVNCamlQbDZpd0pndCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL29yZGVycyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761899729),
('UplMG5vp2pfpiENcwH0BnoZTeFrJ4B7a0zn8WLoX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFBRWW1oaUxTRlNuMlJMR0dBV1FlT0MzQ1A4M0RET29JOGUyaHFFZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761899182);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `description`, `created_at`, `updated_at`) VALUES
('019a0f9c-fe0c-7134-a79f-e6d70b434f35', 'site_title', 'Daksa Company Profile', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe24-70b8-ad02-82c8e7a63566', 'site_description', 'Website Company Profile Daksa - Solusi Terbaik untuk Bisnis Anda', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe28-7108-be1d-520b03307f69', 'company_name', 'Daksa', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe2b-70bb-9161-d143465e346c', 'company_description', 'Perusahaan terpercaya untuk solusi bisnis Anda dengan pengalaman bertahun-tahun di industri ini.', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe2f-72ba-b9d3-b7581166b2fc', 'company_phone', '+62 123 456 789', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe32-71c3-b400-9a843e464284', 'company_email', 'info@daksa.com', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe36-719a-86dd-3bab7c40fea1', 'company_address', 'Jl. Contoh No. 123, Jakarta', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe3a-71ee-ac87-2d089ad132b3', 'primary_color', '#f2be63', 'text', NULL, '2025-10-22 22:48:58', '2025-10-29 05:32:39'),
('019a0f9c-fe3d-713b-9a5a-26cb7c37c409', 'secondary_color', '#90857f', 'text', NULL, '2025-10-22 22:48:58', '2025-10-29 05:32:39'),
('019a0f9c-fe40-70ef-99ea-fb054dab7780', 'background_color', '#f5f7fa', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe43-7360-b27d-b008758fbc62', 'hero_title', 'Dari Laporan Dan Strategi, Semua Tepat Di Tangan Yang Ahli', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:37:06'),
('019a0f9c-fe47-70b8-a0f3-44c4a94f744b', 'hero_description', 'Kami menyediakan layanan berkualitas tinggi yang dapat membantu mengembangkan bisnis Anda ke level yang lebih tinggi.', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe4a-7344-b7f8-7d24a48f7e3f', 'hero_image', '', 'image', 'Gambar hero section', '2025-10-22 22:48:58', '2025-10-22 22:48:58'),
('019a0f9c-fe4d-7205-a080-474ce948e2aa', 'about_title', 'Mengapa Memilih Kami?', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 03:26:23'),
('019a0f9c-fe51-709e-bc68-744758ac4f87', 'about_description', 'Daksa Consultant adalah perusahaan yang bergerak di bidang jasa manajemen, perpajakan, akuntansi, perizinan & implementasi system akuntansi.', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 06:10:56'),
('019a0f9c-fe54-70dc-87a7-fbb1375d775a', 'facebook_url', 'https://web.facebook.com/', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 05:46:33'),
('019a0f9c-fe57-7376-8e40-5eba9782cf88', 'instagram_url', 'https://instagram.com', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 05:46:33'),
('019a0f9c-fe5a-72f7-9d73-22670fd55b32', 'linkedin_url', 'https://linkedin.com', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 05:46:33'),
('019a0f9c-fe5d-726a-be42-6da9ecbd9066', 'twitter_url', 'https://twitter.com', 'text', NULL, '2025-10-22 22:48:58', '2025-10-23 05:46:33'),
('019a0f9c-fe61-70a7-ba58-899212ce7976', 'logo', 'settings/xAFF0bcdycsxbi9KgSlaPxFmYClf01FW4jM1pAg8.png', 'image', NULL, '2025-10-22 22:48:58', '2025-10-23 05:11:32'),
('019a0f9c-fe64-72d2-9825-9735b8975f98', 'favicon', 'settings/WQWHNyJYQUxVRcqr9gDFqd8AwM9fvDFZSIhMmaDX.png', 'image', NULL, '2025-10-22 22:48:58', '2025-10-23 05:11:32'),
('019a1096-e2c8-72f5-94a6-1fdf6e71bca5', 'about_content', 'Dengan pengalamannya bekerja di bidang Perpajakan, Akuntansi dan Manajemen, selama beberapa tahun maka Daks Consultant bersedia membantu perusahaan Bapak & Ibu untuk memberikan solusi terbaik dan mengedukasi di bidang Perpajakan, Akuntansi dan Manajemen.\r\nDaks Consultant memiliki Sumber daya manuasia (SDM) yang Profesional, Kredibel dan independen siap memberikan Pelayanan yang baik, serta memberikan kepercayaan yang penuh kepada semua Masyarakat.', 'text', NULL, '2025-10-23 03:21:55', '2025-10-23 03:35:17'),
('019a1096-e2d2-73fa-8f4c-ad7194e2cd4b', 'about_image', 'settings/6pV3aFcFC1PmXCbrnQblsRyovO71nDNVwruw82dX.jpg', 'image', NULL, '2025-10-23 03:21:55', '2025-10-29 05:12:07'),
('019a115f-82d0-70ed-8f85-de628dfdcaaa', 'hero_image_1', 'settings/y90rFOxGfZ3UlYdt1mnkWpsYBj56BeDHVxRq9eR1.png', 'image', NULL, '2025-10-23 07:01:03', '2025-10-29 09:33:05'),
('019a115f-82dd-70e3-b8ae-04821d8e9e2b', 'hero_image_2', 'settings/xwzZhlsGS9chrZPnaWWa6Dy0m6Zaea9ZtAX0poCd.png', 'image', NULL, '2025-10-23 07:01:03', '2025-10-29 09:17:41'),
('019a115f-82e2-70d8-a030-6cb02eb76caf', 'hero_image_3', 'settings/QSA7XivFrqf3cDzekEiqHDMqBX7cZV0VTTkQWGyT.png', 'image', NULL, '2025-10-23 07:01:03', '2025-10-29 09:31:13'),
('019a3094-1521-73bb-9c05-34e9b5eba76c', 'hero_background_image', 'settings/is3C25z1b45hcld8ZVcH2XjuPiEKjYheKZP1bwtQ.png', 'image', NULL, '2025-10-29 08:26:42', '2025-10-29 08:36:07'),
('019a30a5-a3fc-730c-9fd8-c2e159e8d742', 'hero_slide_bg_1', 'settings/XR5BFCfJiX0UO475Zdi69FnW7TZUGzzTKlWTeqXs.png', 'image', NULL, '2025-10-29 08:45:53', '2025-10-29 08:45:53'),
('019a30a5-a3fe-73be-a6f7-16c3fb8412a2', 'hero_slide_bg_2', 'settings/Wz7DV4zBhas8CDC80WH4UKX2Hsa7jbwlv3Upihua.png', 'image', NULL, '2025-10-29 08:45:53', '2025-10-29 08:45:53'),
('019a30a5-a400-7087-b7b6-8a5e81a543b5', 'hero_slide_bg_3', 'settings/lem65o29d8yaeRA2ZRrkvPdWsao5OgOaksG2CNCP.png', 'image', NULL, '2025-10-29 08:45:53', '2025-10-29 08:45:53'),
('019a3461-c510-7176-a126-23c053a5b742', 'whatsapp_number', '0881081871528', 'text', NULL, '2025-10-30 02:10:14', '2025-10-30 02:10:14'),
('019a3461-c525-70a5-89c1-1b3d70a9aec6', 'whatsapp_template', 'Halo, Saya Tertarik dengan Daksa Consultant', 'text', NULL, '2025-10-30 02:10:14', '2025-10-30 02:10:14'),
('019a3461-c52b-7312-8502-57ad48431e3f', 'gmaps_zoom', '15', 'text', NULL, '2025-10-30 02:10:14', '2025-10-30 02:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `role`, `photo`, `bio`, `email`, `linkedin`, `twitter`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('019a342c-3a7a-7268-a1cb-8493671f09cb', 'Ayu Pratiwi', 'CEO', 'team/XZFz9H7UupyssvjnmncT7rzv6q1UWSePy44z6nTd.png', 'Memimpin strategi dan pertumbuhan perusahaan.', 'ayu@company.com', NULL, NULL, 1, 0, '2025-10-30 01:11:45', '2025-10-30 01:14:32'),
('019a342c-3ae6-7150-ba1e-ba86e9ad0fff', 'Bima Saputra', 'CTO', 'team/JMzTrj33CkNVtMtBNWaA4HkbIQiMfsmuwH6Uwwcr.png', 'Mengawasi teknologi dan inovasi produk.', 'bima@company.com', NULL, NULL, 1, 1, '2025-10-30 01:11:45', '2025-10-30 01:15:13'),
('019a342c-3aeb-721e-ad5b-3a8d3ecc8f23', 'Citra Lestari', 'Head of Operations', 'team/47vb1cogsHZaetpnxuwO9UeCSmL8VHsh1o1VoIiX.png', 'Mengoptimalkan proses operasional dan kualitas layanan.', 'citra@company.com', NULL, NULL, 1, 2, '2025-10-30 01:11:45', '2025-10-30 01:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `position`, `message`, `photo`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
('019a0ffa-68b1-7385-84ea-5baf761dbb95', 'Budi Santoso', 'CEO, PT. Teknologi Maju', 'Pelayanan yang sangat memuaskan! Tim Daksa berhasil mengembangkan website perusahaan kami dengan hasil yang luar biasa. Sangat direkomendasikan!', NULL, 1, 1, '2025-10-23 00:31:00', '2025-10-23 00:31:00'),
('019a0ffa-68ca-73df-949e-7525bd623bf9', 'Sarah Wijaya', 'Marketing Director, CV. Digital Solutions', 'Strategi digital marketing yang diberikan sangat efektif. Traffic website kami meningkat drastis dalam waktu singkat. Terima kasih Daksa!', NULL, 1, 2, '2025-10-23 00:31:00', '2025-10-23 00:31:00'),
('019a0ffa-68d0-734b-9dff-50cc6f54a317', 'Ahmad Rizki', 'Founder, StartupTech Indonesia', 'Aplikasi mobile yang dikembangkan sangat user-friendly dan performanya luar biasa. Tim development sangat profesional dan responsif.', NULL, 1, 3, '2025-10-23 00:31:00', '2025-10-23 00:31:00'),
('019a0ffa-68d4-7220-8f9a-46fc07d20bd4', 'Lisa Permata', 'CTO, PT. Inovasi Digital', 'Konsultasi IT yang diberikan sangat membantu dalam transformasi digital perusahaan kami. Tim Daksa sangat berpengalaman dan knowledgeable.', NULL, 1, 4, '2025-10-23 00:31:00', '2025-10-23 00:31:00'),
('019a0ffa-68d7-7155-b716-3871054f4db3', 'Rudi Hartono', 'Owner, PT. Kreatif Digital', 'E-commerce website yang dikembangkan sangat lengkap dan mudah digunakan. Penjualan online kami meningkat signifikan setelah menggunakan website ini.', NULL, 1, 5, '2025-10-23 00:31:00', '2025-10-23 00:31:00'),
('019a0ffa-68db-738a-9b59-5ebc2a643103', 'Maya Sari', 'Project Manager, TechCorp Solutions', 'Proyek yang dikerjakan sesuai dengan timeline dan budget yang telah disepakati. Kualitas hasil kerja sangat memuaskan dan sesuai ekspektasi.', NULL, 1, 6, '2025-10-23 00:31:00', '2025-10-23 00:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@daksa.com', NULL, '$2y$12$j/uo73ReK2XXJkSPQ8G0c.B4/WEumTCeAs7MkE7kg0MCwD4XpejHu', 'rjXTLzUzWKt2HgFzUmFJsSWDAaVrQnBX0EjjZlY2S02GuyEgMsVzaleGFjnB', '2025-10-22 22:50:11', '2025-10-22 22:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `requirements` longtext COLLATE utf8mb4_unicode_ci,
  `benefits` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vacancies`
--

INSERT INTO `vacancies` (`id`, `title`, `slug`, `department`, `location`, `employment_type`, `salary_range`, `deadline`, `is_active`, `sort_order`, `short_description`, `description`, `requirements`, `benefits`, `created_at`, `updated_at`) VALUES
('019a344b-2330-71a6-a0f7-1e310728409d', 'Frontend Engineer', 'frontend-engineer-vlk9O', 'Engineering', 'Jakarta / Remote', 'Full-time', 'Rp 10jt - Rp 18jt', '2025-12-30', 1, 0, 'Membangun UI modern dengan fokus pada performa dan UX.', 'Bertanggung jawab membangun fitur frontend menggunakan stack modern dan berkolaborasi dengan tim desain & backend.', '- 2+ tahun pengalaman\n- Menguasai JavaScript/TypeScript\n- Pengalaman dengan Vue/React', '- Asuransi kesehatan\n- Remote-friendly\n- Budget pembelajaran', '2025-10-30 01:45:30', '2025-10-30 01:45:30'),
('019a344b-234b-709d-8da5-b4eb47dc7c85', 'Backend Engineer (Laravel)', 'backend-engineer-laravel-LFfUO', 'Engineering', 'Surabaya / Hybrid', 'Full-time', 'Rp 12jt - Rp 20jt', '2025-11-30', 1, 1, 'Merancang API yang skalabel dan aman menggunakan Laravel.', 'Membangun layanan backend, integrasi database, dan best practice keamanan.', '- 3+ tahun pengalaman\n- Laravel & SQL\n- Pengalaman REST API', '- Asuransi\n- WFO/WFH fleksibel\n- Bonus kinerja', '2025-10-30 01:45:30', '2025-10-30 01:45:30'),
('019a344b-2350-7209-bbc6-5d1f2cff0d5c', 'UI/UX Designer', 'uiux-designer-TpHEf', 'Design', 'Remote', 'Contract', 'Negotiable', NULL, 1, 2, 'Mendesain pengalaman pengguna dan antarmuka yang elegan.', 'Membuat wireframe, prototipe, dan desain final yang siap diimplementasikan.', '- Portfolio kuat\n- Figma/Sketch\n- Riset pengguna', '- Jam kerja fleksibel\n- Remote', '2025-10-30 01:45:30', '2025-10-30 01:45:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_author_id_foreign` (`author_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_article_id_foreign` (`article_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_job_id_foreign` (`job_id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vacancies_slug_unique` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
