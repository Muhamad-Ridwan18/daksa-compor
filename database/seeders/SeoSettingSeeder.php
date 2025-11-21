<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SEO Settings for Homepage
        SeoSetting::updateOrCreate(
            ['route_name' => 'home'],
            [
                'page_type' => 'page',
                'meta_title' => 'Konsultan Pajak Bandung - Konsultan Murah Bandung | Daksa',
                'meta_description' => 'Jasa konsultan pajak Bandung terpercaya dengan harga murah. Layanan konsultasi pajak profesional di Bandung untuk individu dan perusahaan. Hubungi kami sekarang!',
                'meta_keywords' => 'konsultan pajak bandung, konsultan murah bandung, jasa konsultan pajak bandung, konsultan pajak murah bandung, konsultan pajak terbaik bandung, layanan konsultan pajak bandung',
                'meta_robots' => 'index,follow',
                'og_title' => 'Konsultan Pajak Bandung - Konsultan Murah Bandung | Daksa',
                'og_description' => 'Jasa konsultan pajak Bandung terpercaya dengan harga murah. Layanan konsultasi pajak profesional di Bandung untuk individu dan perusahaan.',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Konsultan Pajak Bandung - Konsultan Murah Bandung | Daksa',
                'twitter_description' => 'Jasa konsultan pajak Bandung terpercaya dengan harga murah. Layanan konsultasi pajak profesional di Bandung untuk individu dan perusahaan.',
            ]
        );
    }
}

