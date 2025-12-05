<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PPhBadanCalculatorService;
use App\Services\SeoService;
use App\Models\Setting;
use Illuminate\Http\Request;

class PPhBadanCalculatorController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'pph-badan-calculator', [
            'meta_title' => 'Kalkulator PPh Badan (2024) - Hitung Pajak Penghasilan Badan | ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Kalkulator PPh Badan online gratis. Hitung Pajak Penghasilan Badan dengan mudah dan akurat sesuai peraturan terbaru 2024. Perhitungan fasilitas UMKM dan tarif pajak badan.',
            'meta_keywords' => 'kalkulator pph badan, kalkulator pph badan 2024, kalkulator pajak badan, hitung pph badan, kalkulator pph badan online, perhitungan pph badan, pajak badan',
        ]);

        return view('frontend.pph-badan-calculator.index', compact('settings', 'seoData'));
    }

    public function calculate(Request $request)
    {
        try {
            $request->validate([
                'jenis' => 'required|in:umum,umkm',
                'omzet' => 'required|numeric|min:0',
                'laba_komersial' => 'required_if:jenis,umum|nullable|numeric',
                'koreksi_positif' => 'nullable|numeric|min:0',
                'koreksi_negatif' => 'nullable|numeric|min:0',
                'beban' => 'nullable|numeric|min:0',
                'biaya_operasional' => 'nullable|numeric|min:0',
                'pendapatan_lain' => 'nullable|numeric|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal. Silakan periksa kembali input Anda.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $jenis = $request->input('jenis');
        $omzet = (float) $request->input('omzet');
        
        // Jika UMKM, perhitungan sederhana: omzet × 0,50%
        if ($jenis === 'umkm') {
            $pphTerutang = $omzet * 0.005; // 0.50% = 0.005
            
            $result = [
                'jenis' => 'umkm',
                'input' => [
                    'omzet' => $omzet,
                    'jenis' => 'umkm',
                    'laba_komersial' => 0,
                    'koreksi_positif' => 0,
                    'koreksi_negatif' => 0,
                    'tarif_pph' => 0.005,
                    'kredit_pph22' => 0,
                    'kredit_pph23' => 0,
                    'kredit_pph25' => 0,
                    'kredit_pph_lainnya' => 0,
                    'tahun_pajak' => date('Y'),
                ],
                'laba_fiskal' => 0,
                'zona' => null,
                'lkp_fasilitas' => 0,
                'lkp_non_fasilitas' => 0,
                'pajak_terutang' => $pphTerutang,
                'pajak_fasilitas' => 0,
                'pajak_non_fasilitas' => 0,
                'pph_pasal_29' => $pphTerutang,
                'total_kredit' => 0,
                'formula' => 'Omzet × 0,50%',
                'detail' => [
                    'pajak' => [
                        'lkp_fasilitas' => 0,
                        'tarif_fasilitas' => 0,
                        'pajak_fasilitas' => 0,
                        'lkp_non_fasilitas' => 0,
                        'tarif_non_fasilitas' => 0.005,
                        'pajak_non_fasilitas' => $pphTerutang,
                    ],
                    'kredit' => [
                        'pph22' => 0,
                        'pph23' => 0,
                        'pph25' => 0,
                        'pph_lainnya' => 0,
                    ],
                ],
            ];
            
            $settings = Setting::getAllAsArray();
            
            if ($request->ajax()) {
                $html = view('frontend.pph-badan-calculator._result', [
                    'input' => ['omzet' => $omzet, 'jenis' => 'umkm'],
                    'result' => $result,
                    'settings' => $settings,
                ])->render();

                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'result' => $result,
                ]);
            }

            return view('frontend.pph-badan-calculator.index', [
                'input' => ['omzet' => $omzet, 'jenis' => 'umkm'],
                'result' => $result,
                'settings' => $settings,
                'seoData' => SeoService::getSeoData(null, 'pph-badan-calculator', [
                    'meta_title' => 'Kalkulator PPh Badan (2024) - Hitung Pajak Penghasilan Badan | ' . ($settings['company_name'] ?? 'Daksa'),
                    'meta_description' => 'Kalkulator PPh Badan online gratis. Hitung Pajak Penghasilan Badan dengan mudah dan akurat sesuai peraturan terbaru 2024.',
                ]),
            ]);
        }
        
        // Jika Umum, gunakan perhitungan zona fasilitas
        $labaKomersial = (float) $request->input('laba_komersial');
        $koreksiPositif = (float) ($request->input('koreksi_positif') ?? 0);
        $koreksiNegatif = (float) ($request->input('koreksi_negatif') ?? 0);
        
        // Detail koreksi
        $beban = (float) ($request->input('beban') ?? 0);
        $biayaOperasional = (float) ($request->input('biaya_operasional') ?? 0);
        $pendapatanLain = (float) ($request->input('pendapatan_lain') ?? 0);
        
        // Jika koreksi positif tidak diisi, hitung dari detail
        if ($koreksiPositif == 0) {
            $koreksiPositif = $beban + $biayaOperasional;
        }
        
        // Jika koreksi negatif tidak diisi, ambil dari pendapatan lain
        if ($koreksiNegatif == 0) {
            $koreksiNegatif = $pendapatanLain;
        }
        
        $data = [
            'omzet' => $omzet,
            'laba_komersial' => $labaKomersial,
            'koreksi_positif' => $koreksiPositif,
            'koreksi_negatif' => $koreksiNegatif,
            'tarif_pph' => null, // Default 22%
            'kredit_pph22' => 0,
            'kredit_pph23' => 0,
            'kredit_pph25' => 0,
            'kredit_pph_lainnya' => 0,
            'tahun_pajak' => date('Y'),
        ];

        try {
            $result = PPhBadanCalculatorService::calculate($data);
            $result['jenis'] = 'umum'; // Tandai sebagai perhitungan umum
            $result['input']['beban'] = $beban;
            $result['input']['biaya_operasional'] = $biayaOperasional;
            $result['input']['pendapatan_lain'] = $pendapatanLain;
            $settings = Setting::getAllAsArray();

            // If AJAX request, return JSON with result data
            if ($request->ajax()) {
                $html = view('frontend.pph-badan-calculator._result', [
                    'input' => $data,
                    'result' => $result,
                    'settings' => $settings,
                ])->render();

                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'result' => $result,
                ]);
            }

            // If regular request, return view with result
            return view('frontend.pph-badan-calculator.index', [
                'input' => $data,
                'result' => $result,
                'settings' => $settings,
                'seoData' => SeoService::getSeoData(null, 'pph-badan-calculator', [
                    'meta_title' => 'Kalkulator PPh Badan (2024) - Hitung Pajak Penghasilan Badan | ' . ($settings['company_name'] ?? 'Daksa'),
                    'meta_description' => 'Kalkulator PPh Badan online gratis. Hitung Pajak Penghasilan Badan dengan mudah dan akurat sesuai peraturan terbaru 2024.',
                ]),
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghitung: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghitung: ' . $e->getMessage()]);
        }
    }
}

