<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $settings = Setting::getAllAsArray();
        
        // Load products with ordering
        $service->load(['products' => function ($q) {
            $q->orderBy('sort_order');
        }]);
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'service', [
            'meta_title' => $service->name . ' - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $service->meta_description ?: Str::limit($service->description, 160),
            'meta_keywords' => $service->name . ', layanan, ' . ($settings['company_name'] ?? 'Daksa'),
            'og_image' => $service->image ? Storage::url($service->image) : ($settings['logo'] ?? null),
        ]);
        
        return view('frontend.services.show', compact('service', 'settings', 'seoData'));
    }
}

