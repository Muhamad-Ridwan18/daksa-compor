<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Setting;
use App\Services\SeoService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::active()->orderBy('sort_order')->get();
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'branches.index', [
            'meta_title' => 'Cabang Kami - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Lihat lokasi cabang kami di berbagai kota. Hubungi cabang terdekat untuk konsultasi dan layanan.',
            'meta_keywords' => 'cabang, lokasi, kantor, ' . ($settings['company_name'] ?? 'Daksa'),
        ]);
        
        return view('frontend.branches.index', compact('branches', 'settings', 'seoData'));
    }
}

