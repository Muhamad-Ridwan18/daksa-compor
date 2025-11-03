<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.settings.index', compact('settings'));
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
                Setting::setValue(
                    $key,
                    $setting['value'],
                    $setting['type'] ?? 'text'
                );
            }
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
}
