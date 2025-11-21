<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Services\SeoService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->with('products')->orderBy('sort_order')->get();
        $testimonials = Testimonial::active()->orderBy('sort_order')->get();
        $clients = Client::active()->orderBy('sort_order')->get();
        $teamMembers = TeamMember::active()->orderBy('sort_order')->get();
        $settings = Setting::getAllAsArray();

        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'home', [
            'meta_title' => 'Konsultan Pajak Bandung - Konsultan Murah Bandung | ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Jasa konsultan pajak Bandung terpercaya dengan harga murah. Layanan konsultasi pajak profesional di Bandung untuk individu dan perusahaan. Hubungi kami sekarang!',
            'meta_keywords' => 'konsultan pajak bandung, konsultan murah bandung, jasa konsultan pajak bandung, konsultan pajak murah bandung, konsultan pajak terbaik bandung, layanan konsultan pajak bandung',
            'og_image' => $settings['logo'] ?? null,
        ]);

        // Add Website schema
        $seoData['schema_json'] = SeoService::getWebsiteSchema($settings);

        return view('frontend.home', compact('services', 'testimonials', 'clients', 'teamMembers', 'settings', 'seoData'));
    }
}
