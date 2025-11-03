<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            ServiceSeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
            TestimonialSeeder::class,
            ArticleSeeder::class,
            TeamMemberSeeder::class,
            JobSeeder::class,
            JobApplicationSeeder::class,
        ]);
    }
}
