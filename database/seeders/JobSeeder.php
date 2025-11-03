<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Frontend Engineer',
                'department' => 'Engineering',
                'location' => 'Jakarta / Remote',
                'employment_type' => 'Full-time',
                'salary_range' => 'Rp 10jt - Rp 18jt',
                'short_description' => 'Membangun UI modern dengan fokus pada performa dan UX.',
                'description' => "Bertanggung jawab membangun fitur frontend menggunakan stack modern dan berkolaborasi dengan tim desain & backend.",
                'requirements' => "- 2+ tahun pengalaman\n- Menguasai JavaScript/TypeScript\n- Pengalaman dengan Vue/React", 
                'benefits' => "- Asuransi kesehatan\n- Remote-friendly\n- Budget pembelajaran",
                'deadline' => now()->addMonths(2)->toDateString(),
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'Backend Engineer (Laravel)',
                'department' => 'Engineering',
                'location' => 'Surabaya / Hybrid',
                'employment_type' => 'Full-time',
                'salary_range' => 'Rp 12jt - Rp 20jt',
                'short_description' => 'Merancang API yang skalabel dan aman menggunakan Laravel.',
                'description' => "Membangun layanan backend, integrasi database, dan best practice keamanan.",
                'requirements' => "- 3+ tahun pengalaman\n- Laravel & SQL\n- Pengalaman REST API", 
                'benefits' => "- Asuransi\n- WFO/WFH fleksibel\n- Bonus kinerja",
                'deadline' => now()->addMonth()->toDateString(),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'UI/UX Designer',
                'department' => 'Design',
                'location' => 'Remote',
                'employment_type' => 'Contract',
                'salary_range' => 'Negotiable',
                'short_description' => 'Mendesain pengalaman pengguna dan antarmuka yang elegan.',
                'description' => "Membuat wireframe, prototipe, dan desain final yang siap diimplementasikan.",
                'requirements' => "- Portfolio kuat\n- Figma/Sketch\n- Riset pengguna", 
                'benefits' => "- Jam kerja fleksibel\n- Remote",
                'deadline' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($jobs as $data) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
            Job::create($data);
        }
    }
}


