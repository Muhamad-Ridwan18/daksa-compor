<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        
        // Get default SEO settings for homepage
        $defaultSeo = SeoSetting::getByRoute('home');
        if (!$defaultSeo) {
            $defaultSeo = new SeoSetting();
            $defaultSeo->meta_robots = 'index,follow';
            $defaultSeo->og_type = 'website';
            $defaultSeo->twitter_card = 'summary_large_image';
        }
        
        return view('admin.settings.index', compact('settings', 'defaultSeo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'hero_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'hero_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'hero_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'hero_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'hero_slide_bg_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'hero_slide_bg_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'hero_slide_bg_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'seo_settings' => 'nullable|array',
            'seo_settings.og_image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'seo_settings.twitter_image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle image uploads
        $imageFields = ['about_image', 'logo', 'favicon', 'hero_image_1', 'hero_image_2', 'hero_image_3', 'hero_background_image', 'hero_slide_bg_1', 'hero_slide_bg_2', 'hero_slide_bg_3'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $image = $request->file($field);
                $path = $image->store('settings', 'public');
                
                // Delete old image if exists
                $oldImage = Setting::where('key', $field)->first();
                if ($oldImage && $oldImage->value && Storage::disk('public')->exists($oldImage->value)) {
                    Storage::disk('public')->delete($oldImage->value);
                }
                
                $request->merge([
                    'settings' => array_merge($request->settings, [
                        $field => [
                            'value' => $path,
                            'type' => 'image'
                        ]
                    ])
                ]);
            }
        }

        foreach ($request->settings as $key => $setting) {
            if (isset($setting['value'])) {
                // Handle boolean/checkbox values - checkbox sends '1' if checked, hidden input sends '0' if unchecked
                $value = $setting['value'];
                if (isset($setting['type']) && $setting['type'] === 'boolean') {
                    // If checkbox is checked, value will be '1', otherwise hidden input value '0' will be used
                    $value = ($value === '1' || $value === 1) ? '1' : '0';
                }
                
                Setting::setValue(
                    $key,
                    $value,
                    $setting['type'] ?? 'text'
                );
            }
        }

        // Handle SEO settings
        if ($request->has('seo_settings')) {
            $this->updateSeoSettings($request->seo_settings, $request);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'key' => 'required|string',
        ]);

        $path = $request->file('image')->store('settings', 'public');
        
        Setting::setValue($request->key, $path, 'image');

        return response()->json(['path' => $path]);
    }

    /**
     * Update SEO settings
     */
    private function updateSeoSettings($seoData, Request $request)
    {
        // Get or create default SEO setting for homepage
        $seoSetting = SeoSetting::getByRoute('home');
        
        if (!$seoSetting) {
            $seoSetting = new SeoSetting();
            $seoSetting->route_name = 'home';
            $seoSetting->page_type = 'page';
        }

        // Handle OG image upload
        if ($request->hasFile('seo_settings.og_image_upload')) {
            $image = $request->file('seo_settings.og_image_upload');
            $path = $image->store('seo', 'public');
            
            // Delete old image if exists
            if ($seoSetting->og_image && Storage::disk('public')->exists($seoSetting->og_image)) {
                Storage::disk('public')->delete($seoSetting->og_image);
            }
            
            $seoData['og_image'] = $path;
        } elseif (isset($seoData['og_image']) && empty($seoData['og_image'])) {
            // If og_image is empty string, keep existing
            unset($seoData['og_image']);
        }

        // Handle Twitter image upload
        if ($request->hasFile('seo_settings.twitter_image_upload')) {
            $image = $request->file('seo_settings.twitter_image_upload');
            $path = $image->store('seo', 'public');
            
            // Delete old image if exists
            if ($seoSetting->twitter_image && Storage::disk('public')->exists($seoSetting->twitter_image)) {
                Storage::disk('public')->delete($seoSetting->twitter_image);
            }
            
            $seoData['twitter_image'] = $path;
        } elseif (isset($seoData['twitter_image']) && empty($seoData['twitter_image'])) {
            // If twitter_image is empty string, keep existing
            unset($seoData['twitter_image']);
        }

        // Update SEO settings
        $seoSetting->fill([
            'meta_title' => $seoData['meta_title'] ?? null,
            'meta_description' => $seoData['meta_description'] ?? null,
            'meta_keywords' => $seoData['meta_keywords'] ?? null,
            'meta_robots' => $seoData['meta_robots'] ?? 'index,follow',
            'canonical_url' => $seoData['canonical_url'] ?? null,
            'og_title' => $seoData['og_title'] ?? null,
            'og_description' => $seoData['og_description'] ?? null,
            'og_image' => $seoData['og_image'] ?? $seoSetting->og_image,
            'og_type' => $seoData['og_type'] ?? 'website',
            'og_url' => $seoData['og_url'] ?? null,
            'og_site_name' => $seoData['og_site_name'] ?? null,
            'twitter_card' => $seoData['twitter_card'] ?? 'summary_large_image',
            'twitter_title' => $seoData['twitter_title'] ?? null,
            'twitter_description' => $seoData['twitter_description'] ?? null,
            'twitter_image' => $seoData['twitter_image'] ?? $seoSetting->twitter_image,
            'twitter_site' => $seoData['twitter_site'] ?? null,
            'twitter_creator' => $seoData['twitter_creator'] ?? null,
        ]);

        $seoSetting->save();
    }
}
