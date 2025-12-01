<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PPh21Setting;
use Illuminate\Http\Request;

class PPh21SettingController extends Controller
{
    public function index()
    {
        $settings = PPh21Setting::getByCategory();
        
        return view('admin.pph21-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.value' => 'required|numeric|min:0',
        ]);

        foreach ($request->settings as $key => $settingData) {
            $setting = PPh21Setting::where('key', $key)->first();
            
            if ($setting) {
                $setting->update([
                    'value' => $settingData['value'],
                ]);
            }
        }

        return back()->with('success', 'Pengaturan PPh 21 berhasil diperbarui.');
    }

    public function reset()
    {
        // Reset to default values
        $defaults = [
            'ptkp_tk_0' => 54000000,
            'ptkp_tk_1' => 58500000,
            'ptkp_tk_2' => 63000000,
            'ptkp_tk_3' => 67500000,
            'ptkp_k_0' => 58500000,
            'ptkp_k_1' => 63000000,
            'ptkp_k_2' => 67500000,
            'ptkp_k_3' => 72000000,
            'ptkp_tambahan' => 4500000,
            'tarif_5_persen' => 0.05,
            'tarif_15_persen' => 0.15,
            'tarif_25_persen' => 0.25,
            'tarif_30_persen' => 0.30,
            'batas_lapisan_1' => 60000000,
            'batas_lapisan_2' => 250000000,
            'batas_lapisan_3' => 500000000,
        ];

        foreach ($defaults as $key => $value) {
            $setting = PPh21Setting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        return back()->with('success', 'Pengaturan PPh 21 berhasil direset ke nilai default.');
    }
}
