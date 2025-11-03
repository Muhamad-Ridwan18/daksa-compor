<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'logo' => 'https://teknologimaju.com/logo.png',
                'name' => 'PT. Teknologi Maju',
                'website' => 'https://teknologimaju.com',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'logo' => 'https://teknologimaju.com/logo.png',
                'name' => 'CV. Digital Solutions',
                'website' => 'https://digitalsolutions.id',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'logo' => 'https://digitalsolutions.id/logo.png',
                'name' => 'PT. Inovasi Digital',
                'website' => 'https://inovasidigital.co.id',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'logo' => 'https://startuptech.id/logo.png',
                'name' => 'StartupTech Indonesia',
                'website' => 'https://startuptech.id',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'logo' => 'https://kreatifdigital.com/logo.png',
                'name' => 'PT. Kreatif Digital',
                'website' => 'https://kreatifdigital.com',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'logo' => 'https://techcorp.solutions/logo.png',
                'name' => 'TechCorp Solutions',
                'website' => 'https://techcorp.solutions',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
