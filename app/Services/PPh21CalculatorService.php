<?php

namespace App\Services;

use App\Models\PPh21Setting;
use App\Models\TerTable;

class PPh21CalculatorService
{
    // Default values (fallback jika database belum ada)
    const PTKP_TK_0 = 54000000;
    const PTKP_TK_1 = 58500000;
    const PTKP_TK_2 = 63000000;
    const PTKP_TK_3 = 67500000;
    const PTKP_K_0 = 58500000;
    const PTKP_K_1 = 63000000;
    const PTKP_K_2 = 67500000;
    const PTKP_K_3 = 72000000;
    const PTKP_TAMBAHAN = 4500000;

    const TARIF_5_PERSEN = 0.05;
    const TARIF_15_PERSEN = 0.15;
    const TARIF_25_PERSEN = 0.25;
    const TARIF_30_PERSEN = 0.30;

    const BATAS_LAPISAN_1 = 60000000;
    const BATAS_LAPISAN_2 = 250000000;
    const BATAS_LAPISAN_3 = 500000000;

    /**
     * Get setting value from database or fallback to constant
     */
    private static function getSetting($key, $constant)
    {
        try {
            $value = PPh21Setting::getValue($key);
            return $value !== null ? $value : $constant;
        } catch (\Exception $e) {
            // If database error, use constant
            return $constant;
        }
    }

    /**
     * Hitung PTKP berdasarkan status kawin dan tanggungan
     */
    public static function getPTKP($statusKawin, $tanggungan)
    {
        $tanggungan = (int) $tanggungan;
        
        if ($statusKawin === 'TK') {
            // Tidak Kawin
            if ($tanggungan === 0) {
                return self::getSetting('ptkp_tk_0', self::PTKP_TK_0);
            } elseif ($tanggungan === 1) {
                return self::getSetting('ptkp_tk_1', self::PTKP_TK_1);
            } elseif ($tanggungan === 2) {
                return self::getSetting('ptkp_tk_2', self::PTKP_TK_2);
            } elseif ($tanggungan === 3) {
                return self::getSetting('ptkp_tk_3', self::PTKP_TK_3);
            } else {
                // Lebih dari 3 tanggungan
                $ptkp3 = self::getSetting('ptkp_tk_3', self::PTKP_TK_3);
                $tambahan = self::getSetting('ptkp_tambahan', self::PTKP_TAMBAHAN);
                return $ptkp3 + (($tanggungan - 3) * $tambahan);
            }
        } else {
            // Kawin (K) atau Hidup Berpisah (HB) - menggunakan PTKP yang sama
            if ($tanggungan === 0) {
                return self::getSetting('ptkp_k_0', self::PTKP_K_0);
            } elseif ($tanggungan === 1) {
                return self::getSetting('ptkp_k_1', self::PTKP_K_1);
            } elseif ($tanggungan === 2) {
                return self::getSetting('ptkp_k_2', self::PTKP_K_2);
            } elseif ($tanggungan === 3) {
                return self::getSetting('ptkp_k_3', self::PTKP_K_3);
            } else {
                // Lebih dari 3 tanggungan
                $ptkp3 = self::getSetting('ptkp_k_3', self::PTKP_K_3);
                $tambahan = self::getSetting('ptkp_tambahan', self::PTKP_TAMBAHAN);
                return $ptkp3 + (($tanggungan - 3) * $tambahan);
            }
        }
    }

    /**
     * Hitung PPh 21 dengan metode Gross
     */
    public static function calculateGross($penghasilanBruto, $ptkp, $tunjanganPPh = 0)
    {
        // Penghasilan Neto = Penghasilan Bruto - Tunjangan PPh
        $penghasilanNeto = $penghasilanBruto - $tunjanganPPh;
        
        // Penghasilan Kena Pajak = Penghasilan Neto - PTKP
        $pkp = max(0, $penghasilanNeto - $ptkp);
        
        // Hitung PPh Terutang
        $pphTerutang = self::calculatePPhTerutang($pkp);
        
        return [
            'penghasilan_neto' => $penghasilanNeto,
            'pkp' => $pkp,
            'pph_terutang' => $pphTerutang,
            'tunjangan_pph' => $tunjanganPPh,
        ];
    }

    /**
     * Hitung PPh 21 dengan metode Gross-Up
     * Dalam Gross-Up, Tunjangan PPh dihitung otomatis sehingga PPh Terutang = Tunjangan PPh
     * 
     * Konsep Gross-Up:
     * - Penghasilan Bruto awal = Gaji + Tunjangan lainnya (TANPA Tunjangan PPh)
     * - Tunjangan PPh dihitung sehingga PPh Terutang = Tunjangan PPh
     * - Penghasilan Bruto final = Penghasilan Bruto awal + Tunjangan PPh
     * - Penghasilan Neto = Penghasilan Bruto final - Tunjangan PPh
     * 
     * Perlu iterasi karena Tunjangan PPh mempengaruhi Penghasilan Bruto yang mempengaruhi PKP
     * 
     * @param float $penghasilanBrutoAwal Penghasilan bruto TANPA Tunjangan PPh
     * @param float $ptkp PTKP
     * @return array
     */
    public static function calculateGrossUp($penghasilanBrutoAwal, $ptkp)
    {
        // Estimasi awal: hitung PPh tanpa Tunjangan PPh
        $pkpAwal = max(0, $penghasilanBrutoAwal - $ptkp);
        
        // Jika PKP <= 0, tidak ada PPh
        if ($pkpAwal <= 0) {
            return [
                'penghasilan_neto' => $penghasilanBrutoAwal,
                'pkp' => 0,
                'pph_terutang' => 0,
                'tunjangan_pph' => 0,
            ];
        }
        
        // Iterasi untuk mendapatkan nilai yang tepat
        // Tujuan: Tunjangan PPh = PPh Terutang
        $tunjanganPPh = 0;
        $iterasi = 0;
        $maxIterasi = 100;
        $tolerance = 0.01; // Toleransi 0.01 rupiah
        
        while ($iterasi < $maxIterasi) {
            // Penghasilan Bruto dengan Tunjangan PPh
            $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
            
            // Penghasilan Neto = Penghasilan Bruto final - Tunjangan PPh
            $penghasilanNeto = $penghasilanBrutoFinal - $tunjanganPPh;
            
            // PKP = Penghasilan Neto - PTKP
            $pkp = max(0, $penghasilanNeto - $ptkp);
            
            if ($pkp <= 0) {
                return [
                    'penghasilan_neto' => $penghasilanBrutoAwal,
                    'pkp' => 0,
                    'pph_terutang' => 0,
                    'tunjangan_pph' => 0,
                ];
            }
            
            // Hitung PPh Terutang berdasarkan PKP
            $pphTerutang = self::calculatePPhTerutang($pkp);
            
            // Dalam Gross-Up, Tunjangan PPh harus sama dengan PPh Terutang
            // Jika sudah konvergen, break
            if (abs($tunjanganPPh - $pphTerutang) < $tolerance) {
                break;
            }
            
            // Update Tunjangan PPh = PPh Terutang
            $tunjanganPPh = $pphTerutang;
            $iterasi++;
        }
        
        // Final calculation untuk memastikan akurasi
        $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
        $penghasilanNeto = $penghasilanBrutoFinal - $tunjanganPPh;
        $pkp = max(0, $penghasilanNeto - $ptkp);
        $pphTerutang = self::calculatePPhTerutang($pkp);
        
        // Pastikan Tunjangan PPh = PPh Terutang
        $tunjanganPPh = $pphTerutang;
        
        return [
            'penghasilan_neto' => $penghasilanNeto,
            'pkp' => $pkp,
            'pph_terutang' => $pphTerutang,
            'tunjangan_pph' => $tunjanganPPh,
        ];
    }

    /**
     * Hitung PPh Terutang berdasarkan PKP
     */
    public static function calculatePPhTerutang($pkp)
    {
        if ($pkp <= 0) {
            return 0;
        }

        // Get settings from database
        $batas1 = self::getSetting('batas_lapisan_1', self::BATAS_LAPISAN_1);
        $batas2 = self::getSetting('batas_lapisan_2', self::BATAS_LAPISAN_2);
        $batas3 = self::getSetting('batas_lapisan_3', self::BATAS_LAPISAN_3);
        
        $tarif5 = self::getSetting('tarif_5_persen', self::TARIF_5_PERSEN);
        $tarif15 = self::getSetting('tarif_15_persen', self::TARIF_15_PERSEN);
        $tarif25 = self::getSetting('tarif_25_persen', self::TARIF_25_PERSEN);
        $tarif30 = self::getSetting('tarif_30_persen', self::TARIF_30_PERSEN);

        $pphTerutang = 0;

        // Lapisan 1: 0 - batas1 (5%)
        if ($pkp > $batas1) {
            $pphTerutang += $batas1 * $tarif5;
            $sisa = $pkp - $batas1;
        } else {
            return $pkp * $tarif5;
        }

        // Lapisan 2: batas1 - batas2 (15%)
        if ($sisa > ($batas2 - $batas1)) {
            $pphTerutang += ($batas2 - $batas1) * $tarif15;
            $sisa = $sisa - ($batas2 - $batas1);
        } else {
            return $pphTerutang + ($sisa * $tarif15);
        }

        // Lapisan 3: batas2 - batas3 (25%)
        if ($sisa > ($batas3 - $batas2)) {
            $pphTerutang += ($batas3 - $batas2) * $tarif25;
            $sisa = $sisa - ($batas3 - $batas2);
        } else {
            return $pphTerutang + ($sisa * $tarif25);
        }

        // Lapisan 4: Di atas batas3 (30%)
        $pphTerutang += $sisa * $tarif30;

        return $pphTerutang;
    }

    /**
     * Hitung Tarif Efektif Rata-rata (TER)
     */
    public static function getTarifEfektif($pkp)
    {
        if ($pkp <= 0) {
            return 0;
        }

        $pphTerutang = self::calculatePPhTerutang($pkp);
        return $pphTerutang / $pkp;
    }

    /**
     * Get kategori TER berdasarkan status PTKP
     * Sesuai PP No. 58 Tahun 2023:
     * - TER A: TK0, TK1, K0
     * - TER B: TK2, TK3, K1, K2
     * - TER C: K3
     */
    public static function getKategoriTERByStatus($statusKawin, $tanggungan)
    {
        $tanggungan = (int) $tanggungan;
        
        if ($statusKawin === 'TK') {
            // Tidak Kawin
            if ($tanggungan === 0 || $tanggungan === 1) {
                return 'TER A';
            } elseif ($tanggungan === 2 || $tanggungan === 3) {
                return 'TER B';
            } else {
                // Lebih dari 3 tanggungan, gunakan kategori TER B
                return 'TER B';
            }
        } else {
            // Kawin (K) atau Hidup Berpisah (HB) - menggunakan kategori yang sama
            if ($tanggungan === 0) {
                return 'TER A';
            } elseif ($tanggungan === 1 || $tanggungan === 2) {
                return 'TER B';
            } elseif ($tanggungan === 3) {
                return 'TER C';
            } else {
                // Lebih dari 3 tanggungan, gunakan kategori TER C
                return 'TER C';
            }
        }
    }

    /**
     * Get tabel tarif TER sesuai PP No. 58 Tahun 2023
     * Format: [min, max, tarif_percent]
     * Sekarang membaca dari database dengan fallback ke hardcode
     */
    private static function getTabelTarifTER($kategori)
    {
        // Coba baca dari database dulu
        try {
            $terFromDb = TerTable::getByKategori($kategori);
            if (!empty($terFromDb)) {
                return $terFromDb;
            }
        } catch (\Exception $e) {
            // Jika error, fallback ke hardcode
        }

        // Fallback ke hardcode (default values)
        // KATEGORI A: TK0/TK1/K0
        $tabelA = [
            [0, 5400000, 0.00],
            [5400001, 5650000, 0.25],
            [5650001, 5950000, 0.50],
            [5950001, 6300000, 0.75],
            [6300001, 6750000, 1.00],
            [6750001, 7500000, 1.25],
            [7500001, 8550000, 1.50],
            [8550001, 9650000, 1.75],
            [9650001, 10050000, 2.00],
            [10050001, 10350000, 2.25],
            [10350001, 10700000, 2.50],
            [10700001, 11050000, 3.00],
            [11050001, 11600000, 3.50],
            [11600001, 12500000, 4.00],
            [12500001, 13750000, 5.00],
            [13750001, 15100000, 6.00],
            [15100001, 16950000, 7.00],
            [16950001, 19750000, 8.00],
            [19750001, 24150000, 9.00],
            [24150001, 26450000, 10.00],
            [26450001, 28000000, 11.00],
            [28000001, 30050000, 12.00],
            [30050001, 32400000, 13.00],
            [32400001, 35400000, 14.00],
            [35400001, 39100000, 15.00],
            [39100001, 43850000, 16.00],
            [43850001, 47800000, 17.00],
            [47800001, 51400000, 18.00],
            [51400001, 56300000, 19.00],
            [56300001, 62200000, 20.00],
            [62200001, 68600000, 21.00],
            [68600001, 77500000, 22.00],
            [77500001, 89000000, 23.00],
            [89000001, 103000000, 24.00],
            [103000001, 125000000, 25.00],
            [125000001, 157000000, 26.00],
            [157000001, 206000000, 27.00],
            [206000001, 337000000, 28.00],
            [337000001, 454000000, 29.00],
            [454000001, 550000000, 30.00],
            [550000001, 695000000, 31.00],
            [695000001, 910000000, 32.00],
            [910000001, 1400000000, 33.00],
            [1400000001, 999999999999, 34.00],
        ];

        // KATEGORI B: TK2/TK3/K1/K2
        $tabelB = [
            [0, 6200000, 0.00],
            [6200001, 6500000, 0.25],
            [6500001, 6850000, 0.50],
            [6850001, 7300000, 0.75],
            [7300001, 9200000, 1.00],
            [9200001, 10750000, 1.50],
            [10750001, 11250000, 2.00],
            [11250001, 11600000, 2.50],
            [11600001, 12600000, 3.00],
            [12600001, 13600000, 4.00],
            [13600001, 14950000, 5.00],
            [14950001, 16400000, 6.00],
            [16400001, 18450000, 7.00],
            [18450001, 21850000, 8.00],
            [21850001, 26000000, 9.00],
            [26000001, 27700000, 10.00],
            [27700001, 29350000, 11.00],
            [29350001, 31450000, 12.00],
            [31450001, 33950000, 13.00],
            [33950001, 37100000, 14.00],
            [37100001, 41100000, 15.00],
            [41100001, 45800000, 16.00],
            [45800001, 49500000, 17.00],
            [49500001, 53800000, 18.00],
            [53800001, 58500000, 19.00],
            [58500001, 64000000, 20.00],
            [64000001, 71000000, 21.00],
            [71000001, 80000000, 22.00],
            [80000001, 93000000, 23.00],
            [93000001, 109000000, 24.00],
            [109000001, 129000000, 25.00],
            [129000001, 163000000, 26.00],
            [163000001, 211000000, 27.00],
            [211000001, 374000000, 28.00],
            [374000001, 459000000, 29.00],
            [459000001, 555000000, 30.00],
            [555000001, 704000000, 31.00],
            [704000001, 957000000, 32.00],
            [957000001, 1405000000, 33.00],
            [1405000001, 999999999999, 34.00],
        ];

        // KATEGORI C: K3
        $tabelC = [
            [0, 6600000, 0.00],
            [6600001, 6950000, 0.25],
            [6950001, 7350000, 0.50],
            [7350001, 7800000, 0.75],
            [7800001, 8850000, 1.00],
            [8850001, 9800000, 1.25],
            [9800001, 10950000, 1.50],
            [10950001, 11200000, 1.75],
            [11200001, 12050000, 2.00],
            [12050001, 12950000, 3.00],
            [12950001, 14150000, 4.00],
            [14150001, 15550000, 5.00],
            [15550001, 17050000, 6.00],
            [17050001, 19500000, 7.00],
            [19500001, 22700000, 8.00],
            [22700001, 26600000, 9.00],
            [26600001, 28100000, 10.00],
            [28100001, 30100000, 11.00],
            [30100001, 32600000, 12.00],
            [32600001, 35400000, 13.00],
            [35400001, 38900000, 14.00],
            [38900001, 43000000, 15.00],
            [43000001, 47400000, 16.00],
            [47400001, 51200000, 17.00],
            [51200001, 55800000, 18.00],
            [55800001, 60400000, 19.00],
            [60400001, 66700000, 20.00],
            [66700001, 74500000, 21.00],
            [74500001, 83200000, 22.00],
            [83200001, 95600000, 23.00],
            [95600001, 110000000, 24.00],
            [110000001, 134000000, 25.00],
            [134000001, 169000000, 26.00],
            [169000001, 221000000, 27.00],
            [221000001, 390000000, 28.00],
            [390000001, 463000000, 29.00],
            [463000001, 561000000, 30.00],
            [561000001, 709000000, 31.00],
            [709000001, 965000000, 32.00],
            [965000001, 1419000000, 33.00],
            [1419000001, 999999999999, 34.00],
        ];

        switch ($kategori) {
            case 'TER A':
                return $tabelA;
            case 'TER B':
                return $tabelB;
            case 'TER C':
                return $tabelC;
            default:
                return $tabelA; // Default ke TER A
        }
    }

    /**
     * Hitung TER berdasarkan tabel PP No. 58 Tahun 2023
     * @param float $penghasilanBruto Penghasilan bruto bulanan
     * @param string $kategoriTER Kategori TER (TER A, TER B, atau TER C)
     * @return float Tarif efektif dalam desimal (0.24 untuk 24%)
     */
    public static function getTERFromTable($penghasilanBruto, $kategoriTER)
    {
        $penghasilanBruto = (float) $penghasilanBruto;
        $tabel = self::getTabelTarifTER($kategoriTER);
        
        foreach ($tabel as $range) {
            [$min, $max, $tarif] = $range;
            $min = (float) $min;
            $max = (float) $max;
            
            // Cek apakah penghasilan bruto masuk dalam range
            if ($penghasilanBruto >= $min && $penghasilanBruto <= $max) {
                return (float) ($tarif / 100); // Convert to decimal (24.00 -> 0.24)
            }
        }
        
        // Jika tidak ditemukan, return 0
        return 0;
    }

    /**
     * Get kategori TER berdasarkan status PTKP
     * Alias untuk getKategoriTERByStatus untuk backward compatibility
     */
    public static function getKategoriTER($statusKawin, $tanggungan)
    {
        return self::getKategoriTERByStatus($statusKawin, $tanggungan);
    }

    /**
     * Hitung total penghasilan bruto dari semua komponen
     * @param bool $includeTunjanganPPh Apakah include Tunjangan PPh dalam perhitungan
     */
    public static function calculatePenghasilanBruto($data, $includeTunjanganPPh = true)
    {
        // Field yang digabungkan: 
        // - tunjangan_lainnya sudah termasuk uang_lembur (dari controller mapping)
        // - tantiem sudah termasuk bonus, gratifikasi, jasa_produksi_thr (dari controller mapping)
        $total = (
            ($data['gaji_pensiun_tht_jht'] ?? 0) +
            ($data['tunjangan_lainnya'] ?? 0) +
            ($data['uang_lembur'] ?? 0) +
            ($data['honorarium'] ?? 0) +
            ($data['premi_asuransi'] ?? 0) +
            ($data['natura_kenikmatan'] ?? 0) +
            ($data['tantiem'] ?? 0) +
            ($data['bonus'] ?? 0) +
            ($data['gratifikasi'] ?? 0) +
            ($data['jasa_produksi_thr'] ?? 0) +
            ($data['penghasilan_bruto'] ?? 0)
        );
        
        if ($includeTunjanganPPh) {
            $total += ($data['tunjangan_pph'] ?? 0);
        }
        
        return $total;
    }

    /**
     * Main calculation method
     */
    public static function calculate($data)
    {
        // Get PTKP
        $ptkp = self::getPTKP($data['status_kawin'] ?? 'TK', $data['tanggungan'] ?? 0);
        
        // Get kategori TER berdasarkan status PTKP
        $kategoriTER = self::getKategoriTERByStatus(
            $data['status_kawin'] ?? 'TK', 
            $data['tanggungan'] ?? 0
        );
        
        // Hitung berdasarkan metode
        if (($data['tunjangan_pajak'] ?? 'gross') === 'gross-up') {
            // Mode Gross-Up: Penghasilan bruto awal TIDAK termasuk Tunjangan PPh
            $penghasilanBrutoAwal = self::calculatePenghasilanBruto($data, false);
            
            // Iterasi untuk Gross-Up dengan TER dari tabel
            // Tujuan: Tunjangan PPh = PPh Terutang (dihitung dari TER)
            $tunjanganPPh = 0;
            $iterasi = 0;
            $maxIterasi = 100;
            $tolerance = 0.01;
            
            while ($iterasi < $maxIterasi) {
                // Penghasilan Bruto dengan Tunjangan PPh
                $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
                
                // Hitung TER dari tabel berdasarkan penghasilan bruto final
                $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
                
                // Hitung PPh Terutang menggunakan TER dari tabel
                // Rumus: PPh Terutang = Penghasilan Bruto × TER dari tabel
                $pphTerutang = $penghasilanBrutoFinal * $terFromTable;
                
                // Dalam Gross-Up, Tunjangan PPh harus sama dengan PPh Terutang
                if (abs($tunjanganPPh - $pphTerutang) < $tolerance) {
                    break;
                }
                
                $tunjanganPPh = $pphTerutang;
                $iterasi++;
            }
            
            // Final calculation
            $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
            $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
            $pphTerutang = $penghasilanBrutoFinal * $terFromTable;
            $tunjanganPPh = $pphTerutang;
            
            // Penghasilan Neto = Penghasilan Bruto final - Tunjangan PPh
            $penghasilanNeto = $penghasilanBrutoFinal - $tunjanganPPh;
            $pkp = max(0, $penghasilanNeto - $ptkp);
            
            $result = [
                'penghasilan_neto' => $penghasilanNeto,
                'pkp' => $pkp,
                'pph_terutang' => $pphTerutang,
                'tunjangan_pph' => $tunjanganPPh,
            ];
        } else {
            // Mode Gross: Penghasilan bruto termasuk Tunjangan PPh (input manual)
            $penghasilanBruto = self::calculatePenghasilanBruto($data, true);
            $penghasilanBrutoFinal = $penghasilanBruto;
            
            // Hitung TER dari tabel berdasarkan penghasilan bruto
            $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
            
            // Hitung PPh Terutang menggunakan TER dari tabel
            // Rumus: PPh Terutang = Penghasilan Bruto × TER dari tabel
            $pphTerutang = $penghasilanBrutoFinal * $terFromTable;
            
            // Penghasilan Neto = Penghasilan Bruto - Tunjangan PPh
            $tunjanganPPh = $data['tunjangan_pph'] ?? 0;
            $penghasilanNeto = $penghasilanBruto - $tunjanganPPh;
            $pkp = max(0, $penghasilanNeto - $ptkp);
            
            $result = [
                'penghasilan_neto' => $penghasilanNeto,
                'pkp' => $pkp,
                'pph_terutang' => $pphTerutang,
                'tunjangan_pph' => $tunjanganPPh,
            ];
        }
        
        // Hitung TER aktual (untuk perbandingan)
        // TER = PPh Terutang / Penghasilan Bruto (jika penghasilan bruto > 0)
        $ter = $penghasilanBrutoFinal > 0 ? ($result['pph_terutang'] / $penghasilanBrutoFinal) : 0;
        
        // Hitung TER dari tabel (final)
        $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
        
        // Catatan: PPh Terutang dihitung menggunakan TER dari tabel PP No. 58 Tahun 2023
        // Rumus: PPh Terutang = Penghasilan Bruto × TER dari tabel
        
        return [
            'penghasilan_bruto' => $penghasilanBrutoFinal,
            'ptkp' => $ptkp,
            'penghasilan_neto' => $result['penghasilan_neto'],
            'pkp' => $result['pkp'],
            'pph_terutang' => $result['pph_terutang'],
            'tunjangan_pph' => $result['tunjangan_pph'],
            'ter' => $ter,
            'ter_from_table' => $terFromTable,
            'kategori_ter' => $kategoriTER,
        ];
    }
}

