<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::limit(3)->get();

        if ($jobs->isEmpty()) {
            return;
        }

        $samples = [
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'phone' => '081234567890',
                'portfolio_url' => 'https://portfolio.example.com/andi',
                'cover_letter' => 'Saya tertarik bergabung dan punya pengalaman sesuai kualifikasi.',
                'status' => 'received',
            ],
            [
                'name' => 'Bunga Sari',
                'email' => 'bunga@example.com',
                'phone' => '082233445566',
                'portfolio_url' => null,
                'cover_letter' => 'Berpengalaman 3 tahun, siap berkontribusi.',
                'status' => 'reviewed',
            ],
            [
                'name' => 'Chandra Putra',
                'email' => 'chandra@example.com',
                'phone' => '081987654321',
                'portfolio_url' => 'https://dribbble.com/chandrap',
                'cover_letter' => 'Tertarik di posisi terkait desain dan UX.',
                'status' => 'interviewed',
            ],
        ];

        foreach ($jobs as $index => $job) {
            $data = $samples[$index % count($samples)];
            $data['job_id'] = $job->id;
            JobApplication::create($data);
        }
    }
}


