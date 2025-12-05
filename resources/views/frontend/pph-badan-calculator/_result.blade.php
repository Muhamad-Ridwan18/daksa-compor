<!-- Summary Card -->
<div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-lg p-6 mb-6">
    <div class="space-y-4">
        <!-- Untuk UMKM -->
        <template x-if="result.jenis === 'umkm'">
            <div>
                <div class="mb-3">
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                        UMKM
                    </span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Rumus</span>
                    <span class="text-sm font-medium text-gray-700" x-text="result.formula || 'Omzet × 0,50%'"></span>
                </div>
                <div class="border-t border-primary/20 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">PPh Terutang</span>
                        <span class="text-2xl font-bold text-primary" x-text="formatCurrency(result.pajak_terutang)"></span>
                    </div>
                </div>
                <div class="border-t border-primary/20 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">PPh Pasal 29</span>
                        <span class="text-2xl font-bold text-green-600" x-text="formatCurrency(result.pph_pasal_29)"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pajak yang harus disetor</p>
                </div>
            </div>
        </template>

        <!-- Untuk Umum -->
        <template x-if="result.jenis === 'umum' || !result.jenis">
            <div>
                <div class="mb-3" x-show="result.jenis === 'umum'">
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                        Umum
                    </span>
                </div>
                <!-- Laba Fiskal -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Laba / (Rugi) Fiskal</span>
                    <span class="text-lg font-semibold text-gray-900" x-text="formatCurrency(result.laba_fiskal)"></span>
                </div>

                <!-- Zona Fasilitas -->
                <div class="border-t border-primary/20 pt-4">
                    <div class="mb-2">
                        <span class="text-sm text-gray-600">Zona Fasilitas</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700" x-text="getZonaLabel(result.zona)"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1" x-text="getZonaDescription(result.zona)"></p>
                </div>

                <!-- Pajak Terutang -->
                <div class="border-t border-primary/20 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Pajak Terutang</span>
                        <span class="text-2xl font-bold text-primary" x-text="formatCurrency(result.pajak_terutang)"></span>
                    </div>
                </div>

                <!-- PPh Pasal 29 -->
                <div class="border-t border-primary/20 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">PPh Pasal 29</span>
                        <span class="text-2xl font-bold text-green-600" x-text="formatCurrency(result.pph_pasal_29)"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pajak yang harus disetor</p>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Detailed Breakdown (Expandable) -->
<div class="border border-gray-200 rounded-lg overflow-hidden mb-6">
    <button 
        @click="showDetails = !showDetails"
        class="w-full px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
    >
        <span class="font-medium text-gray-900">Detail Perhitungan</span>
        <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="showDetails ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="showDetails" x-transition class="p-4 space-y-3 bg-white">
        <!-- Input Data -->
        <div class="border-b border-gray-200 pb-3">
            <h4 class="font-semibold text-gray-900 mb-2">Data Input</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Omzet / Peredaran Bruto</span>
                    <span class="font-medium text-gray-900" x-text="formatCurrency(result.input.omzet || result.input?.omzet || 0)"></span>
                </div>
                
                <!-- Untuk Umum -->
                <template x-if="result.jenis === 'umum' || !result.jenis">
                    <div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saldo Laba (Rugi) Komersial</span>
                            <span class="font-medium text-gray-900" x-text="formatCurrency(result.input.laba_komersial)"></span>
                        </div>
                        
                        <!-- Koreksi Fiskal Positif -->
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="text-xs font-semibold text-gray-700 mb-2">Koreksi Fiskal Positif</div>
                            <div class="pl-3 space-y-1">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-600">a. Beban</span>
                                    <span class="font-medium text-gray-900" x-text="formatCurrency(result.input.beban || 0)"></span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-600">b. Biaya Operasional</span>
                                    <span class="font-medium text-gray-900" x-text="formatCurrency(result.input.biaya_operasional || 0)"></span>
                                </div>
                                <div class="flex justify-between pt-1 border-t border-gray-100">
                                    <span class="text-gray-700 font-semibold">Total Koreksi Positif</span>
                                    <span class="font-bold text-gray-900" x-text="formatCurrency(result.input.koreksi_positif || 0)"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Koreksi Fiskal Negatif -->
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="text-xs font-semibold text-gray-700 mb-2">Koreksi Fiskal Negatif</div>
                            <div class="pl-3 space-y-1">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-600">a. Pendapatan Lain-lain</span>
                                    <span class="font-medium text-gray-900" x-text="formatCurrency(result.input.pendapatan_lain || 0)"></span>
                                </div>
                                <div class="flex justify-between pt-1 border-t border-gray-100">
                                    <span class="text-gray-700 font-semibold">Total Koreksi Negatif</span>
                                    <span class="font-bold text-gray-900" x-text="formatCurrency(result.input.koreksi_negatif || 0)"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <span class="text-gray-600">Tarif PPh</span>
                            <span class="font-medium text-gray-900" x-text="formatPercent(result.input.tarif_pph * 100) + '%'"></span>
                        </div>
                    </div>
                </template>
                
                <!-- Untuk UMKM -->
                <template x-if="result.jenis === 'umkm'">
                    <div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Rumus</span>
                            <span class="font-medium text-gray-900" x-text="result.formula || 'Omzet × 0,50%'"></span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <span class="text-gray-600">Tarif PPh</span>
                            <span class="font-medium text-gray-900">0,50%</span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Laba Kena Pajak (Hanya untuk Umum) -->
        <template x-if="result.jenis === 'umum' || !result.jenis">
            <div>
                <div class="border-b border-gray-200 pb-3">
                    <h4 class="font-semibold text-gray-900 mb-2">Laba Kena Pajak (LKP)</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between" x-show="result.lkp_fasilitas > 0">
                            <span class="text-gray-600">LKP Fasilitas</span>
                            <span class="font-medium text-gray-900" x-text="formatCurrency(result.lkp_fasilitas)"></span>
                        </div>
                        <div class="flex justify-between" x-show="result.lkp_non_fasilitas > 0">
                            <span class="text-gray-600">LKP Non Fasilitas</span>
                            <span class="font-medium text-gray-900" x-text="formatCurrency(result.lkp_non_fasilitas)"></span>
                        </div>
                    </div>
                </div>

                <!-- Perhitungan Pajak -->
                <div class="border-b border-gray-200 pb-3">
                    <h4 class="font-semibold text-gray-900 mb-2">Perhitungan Pajak</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between" x-show="result.pajak_fasilitas > 0">
                            <span class="text-gray-600">
                                Pajak Fasilitas 
                                <span class="text-xs text-gray-500" x-text="'(22% × 50% = ' + formatPercent(result.detail.pajak.tarif_fasilitas * 100) + '%)'"></span>
                            </span>
                            <span class="font-medium text-gray-900" x-text="formatCurrency(result.pajak_fasilitas)"></span>
                        </div>
                        <div class="flex justify-between" x-show="result.pajak_non_fasilitas > 0">
                            <span class="text-gray-600">
                                Pajak Non Fasilitas 
                                <span class="text-xs text-gray-500" x-text="'(22% × 100% = ' + formatPercent(result.detail.pajak.tarif_non_fasilitas * 100) + '%)'"></span>
                            </span>
                            <span class="font-medium text-gray-900" x-text="formatCurrency(result.pajak_non_fasilitas)"></span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <span class="font-semibold text-gray-900">Total Pajak Terutang</span>
                            <span class="font-bold text-primary" x-text="formatCurrency(result.pajak_terutang)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Perhitungan UMKM -->
        <template x-if="result.jenis === 'umkm'">
            <div class="border-b border-gray-200 pb-3">
                <h4 class="font-semibold text-gray-900 mb-2">Perhitungan Pajak</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Omzet</span>
                        <span class="font-medium text-gray-900" x-text="formatCurrency(result.input.omzet)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tarif</span>
                        <span class="font-medium text-gray-900">0,50%</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="font-semibold text-gray-900">PPh Terutang</span>
                        <span class="font-bold text-primary" x-text="formatCurrency(result.pajak_terutang)"></span>
                    </div>
                </div>
            </div>
        </template>

        <!-- PPh Pasal 29 -->
        <div class="pt-3">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-900">PPh Pasal 29 (Harus Disetor)</span>
                <span class="text-xl font-bold text-green-600" x-text="formatCurrency(result.pph_pasal_29)"></span>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Pajak Terutang (tanpa kredit pajak)
            </p>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <div class="text-sm text-blue-700">
            <p class="font-semibold mb-1">Catatan:</p>
            <ul class="list-disc list-inside space-y-1 text-xs">
                <li>Perhitungan ini berdasarkan peraturan perpajakan terbaru tahun 2024</li>
                <template x-if="result.jenis === 'umkm'">
                    <li>Rumus UMKM: PPh Terutang = Omzet × 0,50%</li>
                </template>
                <template x-if="result.jenis === 'umum' || !result.jenis">
                    <div>
                        <li>Laba Fiskal = Saldo Laba (Rugi) Komersial + Koreksi Positif - Koreksi Negatif</li>
                        <li>Fasilitas pengurangan tarif 50% berlaku untuk omzet ≤ Rp 4,8 Miliar</li>
                        <li>Untuk omzet antara 4,8 M - 50 M, fasilitas diberikan secara proporsional</li>
                        <li>Omzet ≥ Rp 50 Miliar tidak mendapat fasilitas</li>
                    </div>
                </template>
            </ul>
        </div>
    </div>
</div>

