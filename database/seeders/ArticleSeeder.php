<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }

        $articles = [
            [
                'title' => 'Panduan Lengkap Digital Marketing untuk UMKM',
                'slug' => 'panduan-lengkap-digital-marketing-untuk-umkm',
                'excerpt' => 'Pelajari strategi digital marketing yang efektif untuk mengembangkan bisnis UMKM Anda di era digital.',
                'content' => '<h2>Mengapa Digital Marketing Penting untuk UMKM?</h2><p>Di era digital seperti sekarang, kehadiran online bukan lagi pilihan, melainkan keharusan bagi setiap bisnis, termasuk UMKM. Digital marketing memberikan peluang yang setara bagi bisnis kecil untuk bersaing dengan perusahaan besar.</p><h3>Manfaat Digital Marketing</h3><ul><li>Jangkauan pasar yang lebih luas</li><li>Biaya promosi yang lebih efisien</li><li>Targeting audience yang lebih tepat</li><li>Hasil yang terukur dan dapat dianalisis</li></ul><h3>Strategi Digital Marketing yang Efektif</h3><p>Berikut adalah beberapa strategi digital marketing yang dapat diterapkan oleh UMKM:</p><ol><li><strong>Social Media Marketing</strong> - Manfaatkan platform seperti Instagram, Facebook, dan TikTok untuk membangun brand awareness.</li><li><strong>Content Marketing</strong> - Buat konten yang berkualitas dan relevan untuk menarik perhatian target audience.</li><li><strong>SEO (Search Engine Optimization)</strong> - Optimalkan website agar mudah ditemukan di mesin pencari.</li><li><strong>Email Marketing</strong> - Bangun database pelanggan dan kirimkan newsletter secara berkala.</li></ol><p>Dengan menerapkan strategi-strategi di atas secara konsisten, UMKM dapat meningkatkan visibilitas online dan mengembangkan bisnis dengan lebih cepat.</p>',
                'author_id' => $user->id,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'views' => 145,
            ],
            [
                'title' => '10 Tips Membangun Website yang User-Friendly',
                'slug' => '10-tips-membangun-website-yang-user-friendly',
                'excerpt' => 'Website yang user-friendly adalah kunci kesuksesan bisnis online. Simak tips-tips berikut untuk menciptakan website yang nyaman bagi pengunjung.',
                'content' => '<h2>Pentingnya User Experience dalam Website</h2><p>User experience (UX) yang baik dapat meningkatkan konversi, mengurangi bounce rate, dan membangun kepercayaan pengunjung terhadap brand Anda.</p><h3>10 Tips Praktis</h3><ol><li><strong>Desain yang Responsif</strong> - Pastikan website dapat diakses dengan baik di semua device, baik desktop, tablet, maupun smartphone.</li><li><strong>Navigasi yang Intuitif</strong> - Buat struktur menu yang jelas dan mudah dipahami.</li><li><strong>Kecepatan Loading</strong> - Optimalkan performa website agar loading time tidak lebih dari 3 detik.</li><li><strong>Konten yang Berkualitas</strong> - Sajikan informasi yang relevan, akurat, dan mudah dipahami.</li><li><strong>Call-to-Action yang Jelas</strong> - Buat tombol CTA yang menarik perhatian dan mudah ditemukan.</li><li><strong>Konsistensi Visual</strong> - Gunakan skema warna dan typography yang konsisten di seluruh halaman.</li><li><strong>Formulir yang Sederhana</strong> - Minimalkan jumlah field yang harus diisi pengguna.</li><li><strong>Search Functionality</strong> - Sediakan fitur pencarian untuk memudahkan pengguna menemukan informasi.</li><li><strong>Aksesibilitas</strong> - Pastikan website dapat diakses oleh semua orang, termasuk penyandang disabilitas.</li><li><strong>Trust Signals</strong> - Tampilkan testimonial, sertifikat, atau badge untuk membangun kepercayaan.</li></ol><p>Dengan menerapkan tips-tips di atas, Anda dapat menciptakan website yang tidak hanya menarik secara visual, tetapi juga nyaman dan efektif dalam mencapai tujuan bisnis.</p>',
                'author_id' => $user->id,
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'views' => 98,
            ],
            [
                'title' => 'Tren Desain Web 2024 yang Wajib Anda Ketahui',
                'slug' => 'tren-desain-web-2024-yang-wajib-anda-ketahui',
                'excerpt' => 'Industri web design terus berkembang. Ikuti tren terkini agar website Anda tetap relevan dan menarik di mata pengunjung.',
                'content' => '<h2>Tren Desain Web di Tahun 2024</h2><p>Dunia desain web terus berkembang mengikuti perubahan teknologi dan preferensi pengguna. Berikut adalah beberapa tren yang mendominasi tahun 2024.</p><h3>1. Dark Mode</h3><p>Dark mode semakin populer karena memberikan kenyamanan mata, terutama saat browsing di malam hari. Banyak website kini menyediakan opsi untuk beralih antara light dan dark mode.</p><h3>2. Minimalist Design</h3><p>Less is more. Desain minimalis dengan banyak white space memberikan fokus yang lebih baik pada konten utama dan meningkatkan user experience.</p><h3>3. Micro-Interactions</h3><p>Animasi kecil yang responsif terhadap aksi pengguna membuat website terasa lebih hidup dan interaktif.</p><h3>4. 3D Elements</h3><p>Penggunaan elemen 3D dan ilustrasi yang immersive memberikan pengalaman visual yang lebih menarik.</p><h3>5. Sustainability</h3><p>Green web design yang fokus pada efisiensi energi dan performa optimal menjadi pertimbangan penting.</p><p>Menggabungkan tren-tren ini dengan cara yang bijak dapat membuat website Anda stand out dari kompetitor dan memberikan pengalaman yang memorable bagi pengunjung.</p>',
                'author_id' => $user->id,
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'views' => 67,
            ],
            [
                'title' => 'Strategi SEO untuk Meningkatkan Ranking Website Anda',
                'slug' => 'strategi-seo-untuk-meningkatkan-ranking-website-anda',
                'excerpt' => 'SEO adalah investasi jangka panjang untuk bisnis online. Pelajari strategi SEO yang terbukti efektif meningkatkan ranking di Google.',
                'content' => '<h2>Memahami SEO di Era Modern</h2><p>Search Engine Optimization (SEO) adalah proses mengoptimalkan website agar mendapat peringkat tinggi di hasil pencarian organik. SEO yang baik dapat meningkatkan traffic berkualitas ke website Anda.</p><h3>On-Page SEO</h3><ul><li>Riset keyword yang tepat</li><li>Optimasi title tag dan meta description</li><li>Struktur heading yang baik (H1, H2, H3)</li><li>Internal linking yang strategis</li><li>URL yang SEO-friendly</li><li>Optimasi gambar dengan alt text</li></ul><h3>Technical SEO</h3><ul><li>Kecepatan loading website</li><li>Mobile-friendliness</li><li>SSL certificate (HTTPS)</li><li>Sitemap XML</li><li>Robots.txt yang tepat</li><li>Structured data markup</li></ul><h3>Off-Page SEO</h3><ul><li>Backlink building dari website berkualitas</li><li>Social media signals</li><li>Guest posting</li><li>Brand mentions</li></ul><h3>Content Marketing</h3><p>Konten berkualitas adalah raja dalam SEO. Buat konten yang:</p><ul><li>Relevan dengan target audience</li><li>Informatif dan mendalam</li><li>Fresh dan up-to-date</li><li>Original dan unik</li></ul><p>Ingat, SEO adalah marathon bukan sprint. Konsistensi dan kesabaran adalah kunci kesuksesan dalam SEO.</p>',
                'author_id' => $user->id,
                'is_published' => true,
                'published_at' => now()->subDays(1),
                'views' => 32,
            ],
            [
                'title' => 'Cara Memilih Platform E-Commerce yang Tepat untuk Bisnis Anda',
                'slug' => 'cara-memilih-platform-ecommerce-yang-tepat',
                'excerpt' => 'Memilih platform e-commerce yang tepat adalah keputusan penting. Panduan ini akan membantu Anda membuat pilihan yang bijak.',
                'content' => '<h2>Pentingnya Memilih Platform E-Commerce yang Tepat</h2><p>Platform e-commerce adalah fondasi dari toko online Anda. Pilihan yang salah dapat menghambat pertumbuhan bisnis dan menyebabkan biaya tambahan di masa depan.</p><h3>Faktor yang Perlu Dipertimbangkan</h3><ol><li><strong>Budget</strong> - Pertimbangkan biaya setup, biaya bulanan, dan biaya transaksi.</li><li><strong>Kemudahan Penggunaan</strong> - Platform harus user-friendly baik untuk admin maupun pelanggan.</li><li><strong>Skalabilitas</strong> - Pastikan platform dapat berkembang seiring pertumbuhan bisnis.</li><li><strong>Fitur</strong> - Inventori management, payment gateway, shipping integration, dll.</li><li><strong>Customization</strong> - Seberapa fleksibel platform untuk disesuaikan dengan kebutuhan.</li><li><strong>SEO Friendly</strong> - Platform harus mendukung optimasi SEO.</li><li><strong>Support & Security</strong> - Customer support yang responsif dan keamanan yang terjamin.</li></ol><h3>Platform Populer</h3><ul><li><strong>Shopify</strong> - Mudah digunakan, banyak template, cocok untuk pemula hingga menengah.</li><li><strong>WooCommerce</strong> - Open source, fleksibel, cocok untuk pengguna WordPress.</li><li><strong>Magento</strong> - Powerful, scalable, cocok untuk enterprise.</li><li><strong>BigCommerce</strong> - Fitur lengkap, no transaction fees.</li></ul><p>Pilihlah platform yang sesuai dengan kebutuhan bisnis, technical capability, dan budget Anda. Jangan ragu untuk mencoba trial version sebelum membuat keputusan final.</p>',
                'author_id' => $user->id,
                'is_published' => false,
                'published_at' => null,
                'views' => 0,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        $this->command->info('Articles seeded successfully!');
    }
}

