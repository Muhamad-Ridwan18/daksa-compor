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
     * Membaca dari database
     * 
     * Catatan: Data dari database mungkin dalam format desimal (0.25 untuk 0.25%)
     * Fungsi ini menormalisasi semua data menjadi format persen (24.00 untuk 24%)
     */
    private static function getTabelTarifTER($kategori)
    {
        // Baca dari database
        $terFromDb = TerTable::getByKategori($kategori);
        
        if (empty($terFromDb)) {
            // Jika database kosong, return empty array
            // Seharusnya data sudah di-seed melalui TerTableSeeder
            return [];  
        }
        
        // Normalisasi data dari database ke format persen
        // Deteksi format: cek tarif maksimal di tabel
        // Tarif maksimal di tabel TER adalah 34.00 (34%)
        // Jika tarif maksimal <= 1, berarti format desimal (0.25 = 0.25%), perlu dikali 100
        // Jika tarif maksimal > 1, berarti sudah format persen (24.00 = 24%), tidak perlu konversi
        $maxTarif = max(array_map(function($range) {
            return (float) $range[2];
        }, $terFromDb));
        
        // Jika tarif maksimal <= 1, berarti semua tarif dalam format desimal, konversi ke persen
        // Contoh: 0.25 -> 25.00, 0.0025 -> 0.25
        $needConversion = ($maxTarif <= 1 && $maxTarif > 0);
        
        return array_map(function($range) use ($needConversion) {
            [$min, $max, $tarif] = $range;
            $tarif = (float) $tarif;
            // Jika perlu konversi, kalikan dengan 100
            // Contoh: 0.25 (0.25%) -> 25.00 (25%), atau 0.0025 (0.0025%) -> 0.25 (0.25%)
            if ($needConversion && $tarif > 0) {
                $tarif = $tarif * 100;
            }
            return [$min, $max, $tarif];
        }, $terFromDb);
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
            
            // Gross-Up dengan TER dari tabel
            // Rumus: T = PB × TER / (1 - TER), dimana T = Tunjangan PPh, PB = Penghasilan Bruto Awal
            // Tapi karena TER berubah tergantung Penghasilan Bruto Final, perlu iterasi
            
            // Estimasi awal: hitung TER dari Penghasilan Bruto Awal
            $terAwal = self::getTERFromTable($penghasilanBrutoAwal, $kategoriTER);
            
            if ($terAwal <= 0 || $terAwal >= 1) {
                // Jika TER tidak valid, gunakan metode PKP
                $grossUpResult = self::calculateGrossUp($penghasilanBrutoAwal, $ptkp);
                $penghasilanBrutoFinal = $penghasilanBrutoAwal + $grossUpResult['tunjangan_pph'];
                $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
                $result = [
                    'penghasilan_neto' => $grossUpResult['penghasilan_neto'],
                    'pkp' => $grossUpResult['pkp'],
                    'pph_terutang' => $grossUpResult['pph_terutang'],
                    'tunjangan_pph' => $grossUpResult['tunjangan_pph'],
                ];
            } else {
                // Hitung estimasi awal: T = PB × TER / (1 - TER)
                $tunjanganPPh = ($penghasilanBrutoAwal * $terAwal) / (1 - $terAwal);
                
                // Iterasi untuk memperbaiki (maksimal 5 iterasi untuk stabilitas)
                $iterasi = 0;
                $maxIterasi = 5;
                $tolerance = 0.01;
                
                while ($iterasi < $maxIterasi) {
                    $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
                    $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
                    
                    if ($terFromTable <= 0 || $terFromTable >= 1) {
                        break;
                    }
                    
                    // Hitung Tunjangan PPh baru
                    $tunjanganPPhBaru = ($penghasilanBrutoAwal * $terFromTable) / (1 - $terFromTable);
                    
                    // Cek konvergensi
                    if (abs($tunjanganPPh - $tunjanganPPhBaru) < $tolerance) {
                        $tunjanganPPh = $tunjanganPPhBaru;
                        break;
                    }
                    
                    // Update dengan damping (50% dari perubahan)
                    $tunjanganPPh = $tunjanganPPh + ($tunjanganPPhBaru - $tunjanganPPh) * 0.5;
                    $iterasi++;
                }
                
                // Final calculation - pastikan konsistensi
                $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
                $terFromTable = self::getTERFromTable($penghasilanBrutoFinal, $kategoriTER);
                
                // Hitung PPh Terutang menggunakan TER
                $pphTerutang = $penghasilanBrutoFinal * $terFromTable;
                
                // Pastikan Tunjangan PPh = PPh Terutang (konsistensi gross-up)
                $tunjanganPPh = $pphTerutang;
                
                // Recalculate Penghasilan Bruto Final dengan Tunjangan PPh yang sudah disesuaikan
                $penghasilanBrutoFinal = $penghasilanBrutoAwal + $tunjanganPPh;
                
                // Penghasilan Neto = Penghasilan Bruto final - Tunjangan PPh
                $penghasilanNeto = $penghasilanBrutoFinal - $tunjanganPPh;
                $pkp = max(0, $penghasilanNeto - $ptkp);
                
                $result = [
                    'penghasilan_neto' => $penghasilanNeto,
                    'pkp' => $pkp,
                    'pph_terutang' => $pphTerutang,
                    'tunjangan_pph' => $tunjanganPPh,
                ];
            }
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
        
        // Pastikan semua nilai adalah float untuk menghindari masalah presisi
        return [
            'penghasilan_bruto' => (float) round($penghasilanBrutoFinal, 2),
            'ptkp' => (float) round($ptkp, 2),
            'penghasilan_neto' => (float) round($result['penghasilan_neto'], 2),
            'pkp' => (float) round($result['pkp'], 2),
            'pph_terutang' => (float) round($result['pph_terutang'], 2),
            'tunjangan_pph' => (float) round($result['tunjangan_pph'], 2),
            'ter' => (float) round($ter, 4),
            'ter_from_table' => (float) round($terFromTable, 4),
            'kategori_ter' => $kategoriTER,
        ];
    }
}

