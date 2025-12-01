<?php

namespace App\Services;

use App\Models\PPh21Setting;

class PPh21MasaTerakhirService
{
    /**
     * Get setting value from database or fallback to constant
     */
    private static function getSetting($key, $constant)
    {
        try {
            $value = PPh21Setting::getValue($key);
            return $value !== null ? $value : $constant;
        } catch (\Exception $e) {
            return $constant;
        }
    }

    /**
     * Hitung PTKP berdasarkan status kawin dan tanggungan dengan tahun tertentu
     */
    public static function getPTKP($statusKawin, $tanggungan, $tahunKetentuan = 2024)
    {
        // Untuk sekarang menggunakan service yang sama, bisa dikembangkan untuk tahun berbeda
        return PPh21CalculatorService::getPTKP($statusKawin, $tanggungan);
    }

    /**
     * Hitung Biaya Jabatan (5% dari Penghasilan Bruto, maksimal 6 juta per tahun atau 500rb per bulan)
     */
    public static function calculateBiayaJabatan($penghasilanBruto, $jumlahBulan = 1)
    {
        $biayaJabatan = $penghasilanBruto * 0.05;
        $maksimalPerBulan = 500000;
        $maksimalPerTahun = 6000000;
        
        // Maksimal per bulan
        $biayaJabatan = min($biayaJabatan, $maksimalPerBulan);
        
        // Jika sudah melebihi maksimal tahunan, sesuaikan
        $totalTahunan = $biayaJabatan * 12;
        if ($totalTahunan > $maksimalPerTahun) {
            $biayaJabatan = $maksimalPerTahun / 12;
        }
        
        return $biayaJabatan * $jumlahBulan;
    }

    /**
     * Hitung PPh Terutang berdasarkan PKP dengan tahun ketentuan
     */
    public static function calculatePPhTerutang($pkp, $tahunKetentuan = 2024)
    {
        // Gunakan service yang sama untuk perhitungan tarif
        return PPh21CalculatorService::calculatePPhTerutang($pkp);
    }

    /**
     * Hitung Penghasilan Neto Setahun (Disetahunkan)
     */
    public static function calculatePenghasilanNetoSetahun($penghasilanNetoBulanan, $jumlahBulan)
    {
        if ($jumlahBulan <= 0) {
            return 0;
        }
        return ($penghasilanNetoBulanan / $jumlahBulan) * 12;
    }

    /**
     * Main calculation method untuk Masa Pajak Terakhir
     */
    public static function calculate($data)
    {
        // A. Penghasilan
        $penghasilanBruto = self::calculatePenghasilanBruto($data);
        
        // B. Pengurangan
        $biayaJabatan = self::calculateBiayaJabatan($penghasilanBruto, $data['jumlah_bulan'] ?? 1);
        $iuranPensiun = (float) ($data['iuran_pensiun'] ?? 0);
        $zakat = (float) ($data['zakat'] ?? 0);
        $jumlahPengurang = $biayaJabatan + $iuranPensiun + $zakat;
        
        // Penghasilan Neto
        $penghasilanNeto = max(0, $penghasilanBruto - $jumlahPengurang);
        
        // Penghasilan Neto Masa Sebelumnya
        $penghasilanNetoMasaSebelumnya = (float) ($data['penghasilan_neto_masa_sebelumnya'] ?? 0);
        
        // Penghasilan Neto Setahun/Disetahunkan
        $jumlahBulan = (int) ($data['jumlah_bulan'] ?? 1);
        $penghasilanNetoSetahun = self::calculatePenghasilanNetoSetahun($penghasilanNeto, $jumlahBulan);
        
        // Total Penghasilan Neto Setahun (dengan masa sebelumnya)
        $totalPenghasilanNetoSetahun = $penghasilanNetoMasaSebelumnya + $penghasilanNetoSetahun;
        
        // PTKP
        $tahunKetentuanPTKP = (int) ($data['ketentuan_ptkp_tahun'] ?? 2024);
        $ptkp = self::getPTKP($data['status_kawin'] ?? 'TK', $data['tanggungan'] ?? 0, $tahunKetentuanPTKP);
        
        // PKP Setahun/Disetahunkan
        $pkpSetahun = max(0, $totalPenghasilanNetoSetahun - $ptkp);
        
        // PPh Pasal 21 atas PKP
        $tahunKetentuanPasal17 = (int) ($data['ketentuan_pasal17_tahun'] ?? 2024);
        $pphAtasPKP = self::calculatePPhTerutang($pkpSetahun, $tahunKetentuanPasal17);
        
        // PPh Pasal 21 Dipotong Masa Sebelumnya
        $pphDipotongMasaSebelumnya = (float) ($data['pph_dipotong_masa_sebelumnya'] ?? 0);
        
        // PPh Pasal 21 Terutang Setahun/Disetahunkan
        $pphTerutangSetahun = $pphAtasPKP;
        
        // PPh Pasal 21 Yang Sudah di Setor
        $pphSudahDisetor = (float) ($data['pph_sudah_disetor'] ?? 0);
        
        // PPh Pasal 21 Terutang untuk Masa Ini (proporsional)
        // Total PPh terutang setahun dikurangi yang sudah dipotong dan disetor
        $pphTerutangKumulatif = $pphTerutangSetahun - $pphDipotongMasaSebelumnya - $pphSudahDisetor;
        
        // PPh terutang untuk masa ini = (PPh terutang kumulatif / 12) * jumlah bulan
        // Atau lebih tepat: PPh terutang untuk masa ini = PPh terutang kumulatif - PPh yang sudah dipotong sebelumnya
        $pphTerutangBulanIni = max(0, $pphTerutangKumulatif);
        
        // PKP atas Penghasilan Teratur Setahun
        // Penghasilan teratur = gaji/pensiun + tunjangan tetap (tanpa bonus, tantiem, dll)
        $penghasilanTeraturBruto = ($data['gaji_pensiun_tht_jht'] ?? 0) + 
                                   ($data['tunjangan_pph'] ?? 0) + 
                                   ($data['tunjangan_lainnya'] ?? 0) + 
                                   ($data['uang_lembur'] ?? 0) + 
                                   ($data['honorarium'] ?? 0) + 
                                   ($data['premi_asuransi'] ?? 0) + 
                                   ($data['natura_kenikmatan'] ?? 0);
        
        $biayaJabatanTeratur = self::calculateBiayaJabatan($penghasilanTeraturBruto, $jumlahBulan);
        $penghasilanNetoTeratur = max(0, $penghasilanTeraturBruto - $biayaJabatanTeratur - $iuranPensiun - $zakat);
        $penghasilanNetoTeraturSetahun = self::calculatePenghasilanNetoSetahun($penghasilanNetoTeratur, $jumlahBulan);
        $pkpTeraturSetahun = max(0, $penghasilanNetoTeraturSetahun - $ptkp);
        
        // PPh Pasal 21 atas Penghasilan Teratur Setahun
        $pphAtasTeraturSetahun = self::calculatePPhTerutang($pkpTeraturSetahun, $tahunKetentuanPasal17);
        
        // PPh Pasal 21 atas Penghasilan Tidak Teratur (bonus, tantiem, gratifikasi, jasa produksi, THR)
        $penghasilanTidakTeraturBruto = ($data['tantiem'] ?? 0) + 
                                       ($data['bonus'] ?? 0) + 
                                       ($data['gratifikasi'] ?? 0) + 
                                       ($data['jasa_produksi_thr'] ?? 0);
        
        if ($penghasilanTidakTeraturBruto > 0) {
            $biayaJabatanTidakTeratur = self::calculateBiayaJabatan($penghasilanTidakTeraturBruto, $jumlahBulan);
            $penghasilanNetoTidakTeratur = max(0, $penghasilanTidakTeraturBruto - $biayaJabatanTidakTeratur);
            $penghasilanNetoTidakTeraturSetahun = self::calculatePenghasilanNetoSetahun($penghasilanNetoTidakTeratur, $jumlahBulan);
            $pkpTidakTeraturSetahun = max(0, $penghasilanNetoTidakTeraturSetahun);
            $pphAtasTidakTeratur = self::calculatePPhTerutang($pkpTidakTeraturSetahun, $tahunKetentuanPasal17);
        } else {
            $pphAtasTidakTeratur = 0;
        }
        
        return [
            // A. Penghasilan
            'penghasilan_bruto' => $penghasilanBruto,
            
            // B. Pengurangan
            'biaya_jabatan' => $biayaJabatan,
            'iuran_pensiun' => $iuranPensiun,
            'zakat' => $zakat,
            'jumlah_pengurang' => $jumlahPengurang,
            'penghasilan_neto' => $penghasilanNeto,
            
            // C. Penghitungan
            'penghasilan_neto_masa_sebelumnya' => $penghasilanNetoMasaSebelumnya,
            'penghasilan_neto_setahun' => $penghasilanNetoSetahun,
            'total_penghasilan_neto_setahun' => $totalPenghasilanNetoSetahun,
            'ptkp' => $ptkp,
            'pkp_setahun' => $pkpSetahun,
            'pph_atas_pkp' => $pphAtasPKP,
            'pph_dipotong_masa_sebelumnya' => $pphDipotongMasaSebelumnya,
            'pph_terutang_setahun' => $pphTerutangSetahun,
            'pph_sudah_disetor' => $pphSudahDisetor,
            'pph_terutang_bulan_ini' => $pphTerutangBulanIni,
            'pkp_teratur_setahun' => $pkpTeraturSetahun,
            'pph_atas_teratur_setahun' => $pphAtasTeraturSetahun,
            'pph_atas_tidak_teratur' => $pphAtasTidakTeratur,
        ];
    }

    /**
     * Hitung total penghasilan bruto dari semua komponen
     */
    public static function calculatePenghasilanBruto($data)
    {
        return (
            ($data['gaji_pensiun_tht_jht'] ?? 0) +
            ($data['tunjangan_pph'] ?? 0) +
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
    }
}

