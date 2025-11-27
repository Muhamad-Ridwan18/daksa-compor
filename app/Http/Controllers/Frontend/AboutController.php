<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Services\SeoService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        $teamMembers = TeamMember::active()->orderBy('sort_order')->get();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'about', [
            'meta_title' => 'Tentang Kami - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $settings['about_description'] ?? 'Pelajari lebih lanjut tentang ' . ($settings['company_name'] ?? 'Daksa') . ' dan tim profesional kami.',
            'meta_keywords' => 'tentang kami, profil perusahaan, tim profesional, ' . ($settings['company_name'] ?? 'Daksa'),
        ]);
        
        return view('frontend.about', compact('settings', 'teamMembers', 'seoData'));
    }
}

