<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Information
            ['key' => 'site_title', 'value' => 'Daksa Company Profile', 'type' => 'text', 'description' => 'Judul website'],
            ['key' => 'site_description', 'value' => 'Website Company Profile Daksa - Solusi Terbaik untuk Bisnis Anda', 'type' => 'text', 'description' => 'Deskripsi website'],
            
            // Company Information
            ['key' => 'company_name', 'value' => 'Daksa', 'type' => 'text', 'description' => 'Nama perusahaan'],
            ['key' => 'company_description', 'value' => 'Perusahaan terpercaya untuk solusi bisnis Anda dengan pengalaman bertahun-tahun di industri ini.', 'type' => 'text', 'description' => 'Deskripsi perusahaan'],
            ['key' => 'company_phone', 'value' => '+62 123 456 789', 'type' => 'text', 'description' => 'Nomor telepon perusahaan'],
            ['key' => 'company_email', 'value' => 'info@daksa.com', 'type' => 'email', 'description' => 'Email perusahaan'],
            ['key' => 'company_address', 'value' => 'Jl. Contoh No. 123, Jakarta', 'type' => 'text', 'description' => 'Alamat perusahaan'],
            
            // Theme Colors
            ['key' => 'primary_color', 'value' => '#D89B30', 'type' => 'color', 'description' => 'Warna utama'],
            ['key' => 'secondary_color', 'value' => '#4B2E1A', 'type' => 'color', 'description' => 'Warna sekunder'],
            ['key' => 'background_color', 'value' => '#F5F7FA', 'type' => 'color', 'description' => 'Warna background'],
            
            // Hero Section
            ['key' => 'hero_title', 'value' => 'Solusi Terbaik untuk Bisnis Anda', 'type' => 'text', 'description' => 'Judul hero section'],
            ['key' => 'hero_description', 'value' => 'Kami menyediakan layanan berkualitas tinggi yang dapat membantu mengembangkan bisnis Anda ke level yang lebih tinggi.', 'type' => 'text', 'description' => 'Deskripsi hero section'],
            ['key' => 'hero_image', 'value' => '', 'type' => 'image', 'description' => 'Gambar hero section'],
            
            // About Section
            ['key' => 'about_title', 'value' => 'Mengapa Memilih Kami?', 'type' => 'text', 'description' => 'Judul section tentang'],
            ['key' => 'about_description', 'value' => 'Kami adalah perusahaan yang berkomitmen untuk memberikan solusi terbaik bagi klien kami dengan pengalaman bertahun-tahun di industri ini.', 'type' => 'text', 'description' => 'Deskripsi section tentang'],
            ['key' => 'about_content', 'value' => 'Dengan pengalaman lebih dari 10 tahun di industri, kami telah membantu ratusan klien mencapai tujuan bisnis mereka. Tim profesional kami berkomitmen untuk memberikan solusi terbaik yang disesuaikan dengan kebutuhan unik setiap klien.', 'type' => 'textarea', 'description' => 'Konten detail section tentang'],
            ['key' => 'about_image', 'value' => '', 'type' => 'image', 'description' => 'Gambar section tentang'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => '', 'type' => 'url', 'description' => 'URL Facebook'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'url', 'description' => 'URL Instagram'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'url', 'description' => 'URL LinkedIn'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'url', 'description' => 'URL Twitter'],
            
            // Product Settings
            ['key' => 'show_price', 'value' => '1', 'type' => 'boolean', 'description' => 'Tampilkan harga produk di halaman depan'],
            
            // Logo
            ['key' => 'logo', 'value' => '', 'type' => 'image', 'description' => 'Logo perusahaan'],
            ['key' => 'favicon', 'value' => '', 'type' => 'image', 'description' => 'Favicon website'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'description' => $setting['description']
                ]
            );
        }
    }
}
