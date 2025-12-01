<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PPh21CalculatorService;
use App\Services\SeoService;
use App\Models\Setting;
use Illuminate\Http\Request;

class PPh21CalculatorController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'pph21-calculator', [
            'meta_title' => 'Kalkulator PPh 21 Masa (2024) - Hitung Pajak Penghasilan Pasal 21 | ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Kalkulator PPh 21 Masa mulai tahun 2024 online gratis. Hitung Pajak Penghasilan Pasal 21 bulanan dengan mudah dan akurat sesuai peraturan terbaru 2024. PTKP dan tarif progresif terupdate.',
            'meta_keywords' => 'kalkulator pph 21 masa 2024, kalkulator pph 21 tahun 2024, kalkulator pajak penghasilan 2024, hitung pph 21 2024, kalkulator pph 21 online, perhitungan pph 21 masa, kalkulator pajak 2024',
        ]);

        return view('frontend.pph21-calculator.index', compact('settings', 'seoData'));
    }

    public function calculate(Request $request)
    {
        try {
            $request->validate([
                'status_kawin' => 'required|in:TK,K,HB',
                'tanggungan' => 'required|integer|min:0|max:10',
                'tunjangan_pajak' => 'required|in:gross,gross-up',
                'gaji_pensiun_tht_jht' => 'nullable|numeric|min:0',
                'tunjangan_pph' => 'nullable|numeric|min:0',
                'tunjangan_lainnya_lembur' => 'nullable|numeric|min:0',
                'honorarium' => 'nullable|numeric|min:0',
                'premi_asuransi' => 'nullable|numeric|min:0',
                'natura_kenikmatan' => 'nullable|numeric|min:0',
                'tantiem_bonus_gratifikasi' => 'nullable|numeric|min:0',
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

        // Map field baru ke field lama untuk kompatibilitas dengan service
        $tunjanganLainnyaLembur = (float) ($request->input('tunjangan_lainnya_lembur') ?? 0);
        $tantiemBonusGratifikasi = (float) ($request->input('tantiem_bonus_gratifikasi') ?? 0);
        
        $data = [
            'status_kawin' => $request->input('status_kawin'),
            'tanggungan' => $request->input('tanggungan'),
            'tunjangan_pajak' => $request->input('tunjangan_pajak'),
            'gaji_pensiun_tht_jht' => (float) ($request->input('gaji_pensiun_tht_jht') ?? 0),
            'tunjangan_pph' => (float) ($request->input('tunjangan_pph') ?? 0),
            // Map tunjangan_lainnya_lembur ke tunjangan_lainnya (uang_lembur sudah termasuk)
            'tunjangan_lainnya' => $tunjanganLainnyaLembur,
            'uang_lembur' => 0, // Sudah termasuk dalam tunjangan_lainnya_lembur
            'honorarium' => (float) ($request->input('honorarium') ?? 0),
            'premi_asuransi' => (float) ($request->input('premi_asuransi') ?? 0),
            'natura_kenikmatan' => (float) ($request->input('natura_kenikmatan') ?? 0),
            // Map tantiem_bonus_gratifikasi: masukkan ke tantiem saja karena service akan menghitung semua
            // Atau bisa juga dibagi, tapi lebih sederhana masukkan ke tantiem saja
            'tantiem' => $tantiemBonusGratifikasi,
            'bonus' => 0, // Sudah termasuk dalam tantiem_bonus_gratifikasi (masukkan ke tantiem)
            'gratifikasi' => 0, // Sudah termasuk dalam tantiem_bonus_gratifikasi (masukkan ke tantiem)
            'jasa_produksi_thr' => 0, // Sudah termasuk dalam tantiem_bonus_gratifikasi (masukkan ke tantiem)
            'penghasilan_bruto' => 0, // Tidak digunakan lagi, dihitung otomatis
        ];

        try {
            $result = PPh21CalculatorService::calculate($data);
            $settings = Setting::getAllAsArray();

            // If AJAX request, return JSON with result data
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'result' => $result,
                ]);
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghitung: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }

        // Regular request, return full page
        return view('frontend.pph21-calculator.result', [
            'input' => $data,
            'result' => $result,
            'settings' => $settings,
        ]);
    }
}

