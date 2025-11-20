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
            'meta_title' => ($settings['site_title'] ?? 'Daksa Company Profile') . ' - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $settings['site_description'] ?? 'Website Company Profile Daksa',
            'og_image' => $settings['logo'] ?? null,
        ]);

        // Add Website schema
        $seoData['schema_json'] = SeoService::getWebsiteSchema($settings);

        return view('frontend.home', compact('services', 'testimonials', 'clients', 'teamMembers', 'settings', 'seoData'));
    }
}
