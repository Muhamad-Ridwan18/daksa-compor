<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@daksa.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'admin'
        ]);
        $this->call([
            SettingSeeder::class,
            SeoSettingSeeder::class,
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
