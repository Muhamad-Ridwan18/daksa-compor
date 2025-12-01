<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PPh21MasaTerakhirService;
use App\Services\SeoService;
use App\Models\Setting;
use Illuminate\Http\Request;

class PPh21MasaTerakhirController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        
        // Generate SEO data
        $seoData = SeoService::getSeoData(null, 'pph21-masa-terakhir', [
            'meta_title' => 'Kalkulator PPh 21 Masa Pajak Terakhir - Hitung Pajak Akumulatif | ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => 'Kalkulator PPh 21 Masa Pajak Terakhir untuk menghitung Pajak Penghasilan Pasal 21 dengan akumulasi dari masa sebelumnya. Hitung PPh 21 masa terakhir dengan mudah dan akurat.',
            'meta_keywords' => 'kalkulator pph 21 masa terakhir, kalkulator pph 21 akumulatif, hitung pph 21 masa pajak terakhir, kalkulator pph 21 online',
        ]);

        return view('frontend.pph21-masa-terakhir.index', compact('settings', 'seoData'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'npwp' => 'required|in:NPWP,No NPWP',
            'status_kawin' => 'required|in:TK,K',
            'tanggungan' => 'required|integer|min:0|max:10',
            'bulan_dari' => 'required|integer|min:1|max:12',
            'bulan_sampai' => 'required|integer|min:1|max:12|gte:bulan_dari',
            'tahun' => 'required|integer|min:2020|max:2100',
            'status' => 'nullable|string',
            'tunjangan_pajak' => 'required|in:gross,gross-up',
            'ketentuan_ptkp_tahun' => 'required|integer|min:2020|max:2100',
            'ketentuan_pasal17_tahun' => 'required|integer|min:2020|max:2100',
            
            // A. Penghasilan
            'gaji_pensiun_tht_jht' => 'nullable|numeric|min:0',
            'tunjangan_pph' => 'nullable|numeric|min:0',
            'tunjangan_lainnya' => 'nullable|numeric|min:0',
            'uang_lembur' => 'nullable|numeric|min:0',
            'honorarium' => 'nullable|numeric|min:0',
            'premi_asuransi' => 'nullable|numeric|min:0',
            'natura_kenikmatan' => 'nullable|numeric|min:0',
            'tantiem' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'gratifikasi' => 'nullable|numeric|min:0',
            'jasa_produksi_thr' => 'nullable|numeric|min:0',
            'penghasilan_bruto' => 'nullable|numeric|min:0',
            
            // B. Pengurangan
            'iuran_pensiun' => 'nullable|numeric|min:0',
            'zakat' => 'nullable|numeric|min:0',
            
            // C. Data Masa Sebelumnya
            'penghasilan_neto_masa_sebelumnya' => 'nullable|numeric|min:0',
            'pph_dipotong_masa_sebelumnya' => 'nullable|numeric|min:0',
            'pph_sudah_disetor' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only([
            'npwp',
            'status_kawin',
            'tanggungan',
            'bulan_dari',
            'bulan_sampai',
            'tahun',
            'status',
            'tunjangan_pajak',
            'ketentuan_ptkp_tahun',
            'ketentuan_pasal17_tahun',
            'gaji_pensiun_tht_jht',
            'tunjangan_pph',
            'tunjangan_lainnya',
            'uang_lembur',
            'honorarium',
            'premi_asuransi',
            'natura_kenikmatan',
            'tantiem',
            'bonus',
            'gratifikasi',
            'jasa_produksi_thr',
            'penghasilan_bruto',
            'iuran_pensiun',
            'zakat',
            'penghasilan_neto_masa_sebelumnya',
            'pph_dipotong_masa_sebelumnya',
            'pph_sudah_disetor',
        ]);

        // Calculate jumlah bulan
        $bulanDari = (int) $data['bulan_dari'];
        $bulanSampai = (int) $data['bulan_sampai'];
        $jumlahBulan = $bulanSampai - $bulanDari + 1;
        $data['jumlah_bulan'] = $jumlahBulan;

        // Convert to numeric
        foreach ($data as $key => $value) {
            if (in_array($key, ['npwp', 'status_kawin', 'tanggungan', 'bulan_dari', 'bulan_sampai', 'tahun', 'status', 'tunjangan_pajak', 'ketentuan_ptkp_tahun', 'ketentuan_pasal17_tahun', 'jumlah_bulan'])) {
                continue;
            }
            $data[$key] = (float) ($value ?? 0);
        }

        $result = PPh21MasaTerakhirService::calculate($data);
        $settings = Setting::getAllAsArray();

        // If AJAX request, return JSON with HTML
        if ($request->ajax()) {
            $html = view('frontend.pph21-masa-terakhir._result', [
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

        return view('frontend.pph21-masa-terakhir.result', [
            'input' => $data,
            'result' => $result,
            'settings' => $settings,
        ]);
    }
}

