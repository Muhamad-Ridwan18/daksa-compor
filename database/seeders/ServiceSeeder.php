<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Web Development',
                'description' => 'Kami menyediakan layanan pengembangan website profesional dengan teknologi terbaru untuk membantu bisnis Anda berkembang di era digital.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Layanan pengembangan aplikasi mobile untuk iOS dan Android dengan performa optimal dan user experience yang memukau.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Strategi digital marketing yang komprehensif untuk meningkatkan brand awareness dan konversi bisnis Anda.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'IT Consulting',
                'description' => 'Konsultasi teknologi informasi untuk membantu Anda membuat keputusan yang tepat dalam transformasi digital bisnis.',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
