<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'position' => 'CEO, PT. Teknologi Maju',
                'message' => 'Pelayanan yang sangat memuaskan! Tim Daksa berhasil mengembangkan website perusahaan kami dengan hasil yang luar biasa. Sangat direkomendasikan!',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sarah Wijaya',
                'position' => 'Marketing Director, CV. Digital Solutions',
                'message' => 'Strategi digital marketing yang diberikan sangat efektif. Traffic website kami meningkat drastis dalam waktu singkat. Terima kasih Daksa!',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Ahmad Rizki',
                'position' => 'Founder, StartupTech Indonesia',
                'message' => 'Aplikasi mobile yang dikembangkan sangat user-friendly dan performanya luar biasa. Tim development sangat profesional dan responsif.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Lisa Permata',
                'position' => 'CTO, PT. Inovasi Digital',
                'message' => 'Konsultasi IT yang diberikan sangat membantu dalam transformasi digital perusahaan kami. Tim Daksa sangat berpengalaman dan knowledgeable.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Rudi Hartono',
                'position' => 'Owner, PT. Kreatif Digital',
                'message' => 'E-commerce website yang dikembangkan sangat lengkap dan mudah digunakan. Penjualan online kami meningkat signifikan setelah menggunakan website ini.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Maya Sari',
                'position' => 'Project Manager, TechCorp Solutions',
                'message' => 'Proyek yang dikerjakan sesuai dengan timeline dan budget yang telah disepakati. Kualitas hasil kerja sangat memuaskan dan sesuai ekspektasi.',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
