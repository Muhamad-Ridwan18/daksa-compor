<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Ayu Pratiwi',
                'role' => 'CEO',
                'bio' => 'Memimpin strategi dan pertumbuhan perusahaan.',
                'email' => 'ayu@company.com',
                'linkedin' => null,
                'twitter' => null,
                'sort_order' => 0,
            ],
            [
                'name' => 'Bima Saputra',
                'role' => 'CTO',
                'bio' => 'Mengawasi teknologi dan inovasi produk.',
                'email' => 'bima@company.com',
                'linkedin' => null,
                'twitter' => null,
                'sort_order' => 1,
            ],
            [
                'name' => 'Citra Lestari',
                'role' => 'Head of Operations',
                'bio' => 'Mengoptimalkan proses operasional dan kualitas layanan.',
                'email' => 'citra@company.com',
                'linkedin' => null,
                'twitter' => null,
                'sort_order' => 2,
            ],
        ];

        foreach ($members as $data) {
            TeamMember::create($data);
        }
    }
}


