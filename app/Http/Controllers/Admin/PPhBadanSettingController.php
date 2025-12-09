<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PPhBadanSetting;
use Illuminate\Http\Request;

class PPhBadanSettingController extends Controller
{
    public function index()
    {
        $settings = PPhBadanSetting::getByCategory();
        
        return view('admin.pph-badan-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.value' => 'required|numeric|min:0',
        ]);

        foreach ($request->settings as $key => $settingData) {
            $setting = PPhBadanSetting::where('key', $key)->first();
            
            if ($setting) {
                $setting->update([
                    'value' => $settingData['value'],
                ]);
            }
        }

        return back()->with('success', 'Pengaturan PPh Badan berhasil diperbarui.');
    }

    public function reset()
    {
        // Reset to default values
        $defaults = [
            'batas_fasilitas_min' => 4800000000,
            'batas_fasilitas_max' => 50000000000,
            'tarif_pph_badan' => 0.22,
            'persentase_fasilitas' => 0.50,
        ];

        foreach ($defaults as $key => $value) {
            $setting = PPhBadanSetting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        return back()->with('success', 'Pengaturan PPh Badan berhasil direset ke nilai default.');
    }
}
