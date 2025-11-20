<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Setting;
use App\Services\SeoService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::active()->orderBy('sort_order')->orderBy('created_at', 'desc');
        
        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $galleries = $query->get();
        $categories = Gallery::active()->distinct()->pluck('category')->filter();
        
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'gallery.index', [
            'meta_title' => 'Gallery - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Lihat galeri foto dan dokumentasi dari ' . ($settings['company_name'] ?? 'Daksa'),
        ]);
        
        return view('frontend.gallery.index', compact('galleries', 'categories', 'settings', 'seoData'));
    }
}
