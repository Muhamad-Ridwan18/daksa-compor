<?php

namespace App\Services;

class PPhBadanCalculatorService
{
    // Konstanta untuk batas omzet fasilitas
    const BATAS_FASILITAS_MIN = 4800000000; // 4,8 M
    const BATAS_FASILITAS_MAX = 50000000000; // 50 M
    
    // Tarif PPh Badan (default 22%)
    const TARIF_PPH_BADAN = 0.22;
    
    // Persentase pengurangan tarif untuk fasilitas (50%)
    const PERSENTASE_FASILITAS = 0.50;

    /**
     * Hitung Laba Fiskal (Laba Kena Pajak)
     * 
     * @param float $labaKomersial Saldo Laba (Rugi) Komersial
     * @param float $koreksiPositif Koreksi Fiskal Positif
     * @param float $koreksiNegatif Koreksi Fiskal Negatif
     * @return float Laba Fiskal
     */
    public static function calculateLabaFiskal($labaKomersial, $koreksiPositif = 0, $koreksiNegatif = 0)
    {
        $labaFiskal = $labaKomersial + $koreksiPositif - $koreksiNegatif;
        return max(0, $labaFiskal); // Laba fiskal tidak boleh negatif untuk perhitungan pajak
    }

    /**
     * Tentukan zona fasilitas berdasarkan omzet
     * 
     * @param float $omzet Omzet / Peredaran Bruto
     * @return string Zona fasilitas: 'zona1', 'zona2', atau 'zona3'
     */
    public static function getZonaFasilitas($omzet)
    {
        if ($omzet <= self::BATAS_FASILITAS_MIN) {
            return 'zona1'; // Omzet ≤ 4,8 M
        } elseif ($omzet < self::BATAS_FASILITAS_MAX) {
            return 'zona2'; // 4,8 M < Omzet < 50 M
        } else {
            return 'zona3'; // Omzet ≥ 50 M
        }
    }

    /**
     * Hitung Laba Kena Pajak Fasilitas dan Non Fasilitas
     * 
     * @param float $omzet Omzet / Peredaran Bruto
     * @param float $labaFiskal Laba Fiskal
     * @return array ['lkp_fasilitas' => float, 'lkp_non_fasilitas' => float, 'zona' => string]
     */
    public static function calculateLKP($omzet, $labaFiskal)
    {
        $zona = self::getZonaFasilitas($omzet);
        
        $lkpFasilitas = 0;
        $lkpNonFasilitas = 0;
        
        switch ($zona) {
            case 'zona1':
                // Omzet ≤ 4,8 M: Seluruh LKP mendapat fasilitas
                $lkpFasilitas = $labaFiskal;
                $lkpNonFasilitas = 0;
                break;
                
            case 'zona2':
                // 4,8 M < Omzet < 50 M: Proporsional
                // LKP Fasilitas = LKP × (4,8 M / Omzet)
                $lkpFasilitas = $labaFiskal * (self::BATAS_FASILITAS_MIN / $omzet);
                $lkpNonFasilitas = $labaFiskal - $lkpFasilitas;
                break;
                
            case 'zona3':
                // Omzet ≥ 50 M: Tidak ada fasilitas
                $lkpFasilitas = 0;
                $lkpNonFasilitas = $labaFiskal;
                break;
        }
        
        return [
            'lkp_fasilitas' => $lkpFasilitas,
            'lkp_non_fasilitas' => $lkpNonFasilitas,
            'zona' => $zona,
        ];
    }

    /**
     * Hitung Pajak Terutang
     * 
     * @param float $lkpFasilitas Laba Kena Pajak yang mendapat fasilitas
     * @param float $lkpNonFasilitas Laba Kena Pajak yang tidak mendapat fasilitas
     * @param float $tarifPPh Tarif PPh Badan (default 22%)
     * @return array ['pajak_terutang' => float, 'detail' => array]
     */
    public static function calculatePajakTerutang($lkpFasilitas, $lkpNonFasilitas, $tarifPPh = null)
    {
        $tarifPPh = $tarifPPh ?? self::TARIF_PPH_BADAN;
        
        // Pajak atas LKP Fasilitas: 22% × 50% = 11%
        $pajakFasilitas = $lkpFasilitas * $tarifPPh * self::PERSENTASE_FASILITAS;
        
        // Pajak atas LKP Non Fasilitas: 22% × 100% = 22%
        $pajakNonFasilitas = $lkpNonFasilitas * $tarifPPh;
        
        $pajakTerutang = $pajakFasilitas + $pajakNonFasilitas;
        
        return [
            'pajak_terutang' => $pajakTerutang,
            'pajak_fasilitas' => $pajakFasilitas,
            'pajak_non_fasilitas' => $pajakNonFasilitas,
            'detail' => [
                'lkp_fasilitas' => $lkpFasilitas,
                'tarif_fasilitas' => $tarifPPh * self::PERSENTASE_FASILITAS,
                'pajak_fasilitas' => $pajakFasilitas,
                'lkp_non_fasilitas' => $lkpNonFasilitas,
                'tarif_non_fasilitas' => $tarifPPh,
                'pajak_non_fasilitas' => $pajakNonFasilitas,
            ],
        ];
    }

    /**
     * Hitung PPh Pasal 29 (Pajak yang harus disetor)
     * 
     * @param float $pajakTerutang Pajak Terutang
     * @param float $kreditPPh22 Kredit PPh 22
     * @param float $kreditPPh23 Kredit PPh 23
     * @param float $kreditPPh25 Kredit PPh 25
     * @param float $kreditPPhLainnya Kredit PPh lainnya
     * @return array ['pph_pasal_29' => float, 'total_kredit' => float]
     */
    public static function calculatePPhPasal29($pajakTerutang, $kreditPPh22 = 0, $kreditPPh23 = 0, $kreditPPh25 = 0, $kreditPPhLainnya = 0)
    {
        $totalKredit = $kreditPPh22 + $kreditPPh23 + $kreditPPh25 + $kreditPPhLainnya;
        $pphPasal29 = max(0, $pajakTerutang - $totalKredit); // Tidak boleh negatif
        
        return [
            'pph_pasal_29' => $pphPasal29,
            'total_kredit' => $totalKredit,
            'detail_kredit' => [
                'pph22' => $kreditPPh22,
                'pph23' => $kreditPPh23,
                'pph25' => $kreditPPh25,
                'pph_lainnya' => $kreditPPhLainnya,
            ],
        ];
    }

    /**
     * Main calculation method - Hitung semua komponen PPh Badan
     * 
     * @param array $data Input data
     * @return array Hasil perhitungan lengkap
     */
    public static function calculate($data)
    {
        // Extract input
        $omzet = (float) ($data['omzet'] ?? 0);
        $labaKomersial = (float) ($data['laba_komersial'] ?? 0);
        $koreksiPositif = (float) ($data['koreksi_positif'] ?? 0);
        $koreksiNegatif = (float) ($data['koreksi_negatif'] ?? 0);
        $tarifPPh = isset($data['tarif_pph']) ? (float) $data['tarif_pph'] : null;
        $kreditPPh22 = (float) ($data['kredit_pph22'] ?? 0);
        $kreditPPh23 = (float) ($data['kredit_pph23'] ?? 0);
        $kreditPPh25 = (float) ($data['kredit_pph25'] ?? 0);
        $kreditPPhLainnya = (float) ($data['kredit_pph_lainnya'] ?? 0);
        $tahunPajak = $data['tahun_pajak'] ?? date('Y');

        // 1. Hitung Laba Fiskal
        $labaFiskal = self::calculateLabaFiskal($labaKomersial, $koreksiPositif, $koreksiNegatif);
        
        // 2. Tentukan zona dan hitung LKP
        $lkpResult = self::calculateLKP($omzet, $labaFiskal);
        
        // 3. Hitung Pajak Terutang
        $pajakResult = self::calculatePajakTerutang(
            $lkpResult['lkp_fasilitas'],
            $lkpResult['lkp_non_fasilitas'],
            $tarifPPh
        );
        
        // 4. Hitung PPh Pasal 29
        $pphPasal29Result = self::calculatePPhPasal29(
            $pajakResult['pajak_terutang'],
            $kreditPPh22,
            $kreditPPh23,
            $kreditPPh25,
            $kreditPPhLainnya
        );
        
        // Return hasil lengkap
        return [
            'input' => [
                'omzet' => $omzet,
                'laba_komersial' => $labaKomersial,
                'koreksi_positif' => $koreksiPositif,
                'koreksi_negatif' => $koreksiNegatif,
                'tarif_pph' => $tarifPPh ?? self::TARIF_PPH_BADAN,
                'kredit_pph22' => $kreditPPh22,
                'kredit_pph23' => $kreditPPh23,
                'kredit_pph25' => $kreditPPh25,
                'kredit_pph_lainnya' => $kreditPPhLainnya,
                'tahun_pajak' => $tahunPajak,
            ],
            'laba_fiskal' => $labaFiskal,
            'zona' => $lkpResult['zona'],
            'lkp_fasilitas' => $lkpResult['lkp_fasilitas'],
            'lkp_non_fasilitas' => $lkpResult['lkp_non_fasilitas'],
            'pajak_terutang' => $pajakResult['pajak_terutang'],
            'pajak_fasilitas' => $pajakResult['pajak_fasilitas'],
            'pajak_non_fasilitas' => $pajakResult['pajak_non_fasilitas'],
            'pph_pasal_29' => $pphPasal29Result['pph_pasal_29'],
            'total_kredit' => $pphPasal29Result['total_kredit'],
            'detail' => [
                'pajak' => $pajakResult['detail'],
                'kredit' => $pphPasal29Result['detail_kredit'],
            ],
        ];
    }

    /**
     * Format rupiah untuk display
     * 
     * @param float $amount Jumlah uang
     * @return string Format rupiah
     */
    public static function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Get deskripsi zona fasilitas
     * 
     * @param string $zona Zona fasilitas
     * @return string Deskripsi zona
     */
    public static function getDeskripsiZona($zona)
    {
        $deskripsi = [
            'zona1' => 'Omzet ≤ Rp 4,8 Miliar (Seluruh LKP mendapat fasilitas 50%)',
            'zona2' => 'Omzet > Rp 4,8 Miliar dan < Rp 50 Miliar (LKP proporsional)',
            'zona3' => 'Omzet ≥ Rp 50 Miliar (Tidak ada fasilitas)',
        ];
        
        return $deskripsi[$zona] ?? 'Tidak diketahui';
    }
}

