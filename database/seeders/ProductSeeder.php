<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        
        $products = [
            // Web Development Products
            [
                'service_id' => $services->where('name', 'Web Development')->first()->id,
                'name' => 'Website Company Profile',
                'description' => 'Website company profile profesional dengan desain modern dan responsive.',
                'price' => 5000000,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'service_id' => $services->where('name', 'Web Development')->first()->id,
                'name' => 'E-commerce Website',
                'description' => 'Website toko online lengkap dengan sistem pembayaran dan manajemen produk.',
                'price' => 15000000,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'service_id' => $services->where('name', 'Web Development')->first()->id,
                'name' => 'Custom Web Application',
                'description' => 'Aplikasi web custom sesuai kebutuhan bisnis Anda.',
                'price' => 25000000,
                'is_active' => true,
                'sort_order' => 3,
            ],
            
            // Mobile App Development Products
            [
                'service_id' => $services->where('name', 'Mobile App Development')->first()->id,
                'name' => 'iOS App Development',
                'description' => 'Pengembangan aplikasi iOS native dengan performa optimal.',
                'price' => 30000000,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'service_id' => $services->where('name', 'Mobile App Development')->first()->id,
                'name' => 'Android App Development',
                'description' => 'Pengembangan aplikasi Android native dengan UI/UX yang menarik.',
                'price' => 25000000,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'service_id' => $services->where('name', 'Mobile App Development')->first()->id,
                'name' => 'Cross-Platform App',
                'description' => 'Aplikasi mobile yang dapat berjalan di iOS dan Android sekaligus.',
                'price' => 20000000,
                'is_active' => true,
                'sort_order' => 3,
            ],
            
            // Digital Marketing Products
            [
                'service_id' => $services->where('name', 'Digital Marketing')->first()->id,
                'name' => 'Social Media Management',
                'description' => 'Manajemen akun media sosial dengan konten berkualitas dan strategi yang tepat.',
                'price' => 3000000,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'service_id' => $services->where('name', 'Digital Marketing')->first()->id,
                'name' => 'SEO Optimization',
                'description' => 'Optimasi SEO untuk meningkatkan ranking website di mesin pencari.',
                'price' => 5000000,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'service_id' => $services->where('name', 'Digital Marketing')->first()->id,
                'name' => 'Google Ads Campaign',
                'description' => 'Kampanye iklan Google Ads untuk meningkatkan traffic dan konversi.',
                'price' => 2000000,
                'is_active' => true,
                'sort_order' => 3,
            ],
            
            // IT Consulting Products
            [
                'service_id' => $services->where('name', 'IT Consulting')->first()->id,
                'name' => 'IT Strategy Consultation',
                'description' => 'Konsultasi strategi IT untuk transformasi digital bisnis Anda.',
                'price' => 10000000,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'service_id' => $services->where('name', 'IT Consulting')->first()->id,
                'name' => 'System Architecture Design',
                'description' => 'Desain arsitektur sistem yang scalable dan maintainable.',
                'price' => 15000000,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
