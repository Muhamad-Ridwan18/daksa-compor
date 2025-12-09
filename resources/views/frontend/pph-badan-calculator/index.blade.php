@extends('layouts.frontend')

@section('content')
<!-- Hero Section with Modern Gradient -->
<section class="relative min-h-[20vh] sm:min-h-[30vh] flex items-center justify-center bg-primary overflow-hidden">
    {{-- <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 pattern-dots"></div>
    </div>
    
    <!-- Floating Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none bg-primary">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl" style="animation-delay: 1s;"></div>
    </div> --}}
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-8 sm:py-12 lg:py-16">
        <div class="max-w-4xl mx-auto text-center text-white">
            <!-- Badge -->
            <div class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white/10 backdrop-blur-md rounded-full text-xs sm:text-sm font-semibold mb-4 sm:mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
                Kalkulator Pajak
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight px-2">
                Kalkulator PPh Badan
            </h1>
            
            <!-- Subtitle -->
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 text-white/90 max-w-3xl mx-auto px-4">
                Hitung Pajak Penghasilan Badan dengan mudah dan akurat sesuai peraturan terbaru 2024. Perhitungan fasilitas UMKM dan tarif pajak badan.
            </p>
            
            <!-- Action Button to Documents -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('documents.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md hover:bg-white/30 text-white font-semibold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border border-white/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Lihat Dokumen & Peraturan</span>
                </a>
            </div>
        </div>
    </div>
</section>

<div class="min-h-screen bg-gray-50 py-8 md:py-12" x-data="pphBadanCalculator()" x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Content: Form & Result Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <!-- Left: Form Section -->
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Data Perusahaan</h2>
                
                <form id="pph-badan-calculator-form" @submit.prevent="calculate()">
                    <!-- Jenis Perhitungan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Perhitungan <span class="text-red-500">*</span>
                        </label>
                        <select 
                            x-model="formData.jenis"
                            class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                            @change="debouncedCalculate()"
                            required
                        >
                            <option value="">Pilih Jenis</option>
                            <option value="umum">Umum (Perhitungan Zona Fasilitas)</option>
                            <option value="umkm">UMKM (Omzet × 0,50%)</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">
                            <span x-show="formData.jenis === 'umum'">Perhitungan dengan zona fasilitas berdasarkan omzet dan laba fiskal</span>
                            <span x-show="formData.jenis === 'umkm'">Perhitungan sederhana: Omzet × 0,50%</span>
                        </p>
                    </div>

                    <!-- 1. Omzet / Peredaran Bruto -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            1. Omzet / Peredaran Bruto Setahun <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input 
                                type="text" 
                                name="omzet"
                                x-model="formData.omzet"
                                class="currency-input w-full pl-10 pr-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                placeholder="0"
                                @input="debouncedCalculate()"
                                required
                            >
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            <span x-show="formData.jenis === 'umum'">Untuk perhitungan zonasi fasilitas</span>
                            <span x-show="formData.jenis === 'umkm'">Untuk perhitungan PPh UMKM</span>
                        </p>
                    </div>

                    <!-- Input Detail untuk Umum -->
                    <div x-show="formData.jenis === 'umum'">
                        <!-- 2. Saldo Laba (Rugi) Komersial -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                2. Saldo Laba (Rugi) Komersial <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input 
                                    type="text" 
                                    name="laba_komersial"
                                    x-model="formData.laba_komersial"
                                    class="currency-input w-full pl-10 pr-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                    placeholder="0"
                                    @input="debouncedCalculate()"
                                    :required="formData.jenis === 'umum'"
                                >
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Masukkan saldo laba atau rugi komersial (bisa negatif untuk rugi)
                            </p>
                        </div>

                        <!-- 3. Koreksi Fiskal Positif -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                3. Koreksi Fiskal Positif
                            </label>
                            
                            <!-- 3a. Beban -->
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    a. Beban
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input 
                                        type="text" 
                                        name="beban"
                                        x-model="formData.beban"
                                        class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="0"
                                        @input="debouncedCalculate()"
                                    >
                                </div>
                            </div>

                            <!-- 3b. Biaya Operasional -->
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    b. Biaya Operasional
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input 
                                        type="text" 
                                        name="biaya_operasional"
                                        x-model="formData.biaya_operasional"
                                        class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="0"
                                        @input="debouncedCalculate()"
                                    >
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Total Koreksi Positif: <span class="font-semibold" x-text="formatCurrency(getTotalKoreksiPositif())"></span>
                            </p>
                        </div>

                        <!-- 4. Koreksi Fiskal Negatif -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                4. Koreksi Fiskal Negatif
                            </label>
                            
                            <!-- 4a. Pendapatan Lain-lain -->
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    a. Pendapatan Lain-lain
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input 
                                        type="text" 
                                        name="pendapatan_lain"
                                        x-model="formData.pendapatan_lain"
                                        class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                        placeholder="0"
                                        @input="debouncedCalculate()"
                                    >
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Total Koreksi Negatif: <span class="font-semibold" x-text="formatCurrency(getTotalKoreksiNegatif())"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Info Box untuk UMKM -->
                    <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded-lg" x-show="formData.jenis === 'umkm'">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-green-700">
                                <p class="font-semibold mb-1">Rumus UMKM:</p>
                                <p class="text-xs">PPh Terutang = Omzet × 0,50%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button 
                            type="button"
                            @click="resetForm()"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                        >
                            Reset
                        </button>
                        <button 
                            type="button"
                            @click="calculate()"
                            :disabled="loading"
                            class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span x-show="!loading">Hitung</span>
                            <span x-show="loading" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Menghitung...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Result Section -->
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Hasil Perhitungan</h2>
                
                <!-- Loading State -->
                <div x-show="loading" class="text-center py-12">
                    <svg class="animate-spin h-12 w-12 text-primary mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600">Menghitung...</p>
                </div>

                <!-- Error State -->
                <div x-show="error && !loading" class="p-4 bg-red-50 border border-red-200 rounded-lg mb-4">
                    <p class="text-sm text-red-700" x-text="error"></p>
                </div>

                <!-- Result Content -->
                <div x-show="result && !loading" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    @include('frontend.pph-badan-calculator._result')
                </div>

                <!-- Empty State -->
                <div x-show="!result && !loading && !error" class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">Masukkan data untuk melihat hasil perhitungan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer CTA Section -->
<section class="py-20 bg-primary relative overflow-hidden" data-aos="fade-up">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold mb-6" data-aos="fade-up" data-aos-delay="100">
                Siap Memulai?
            </div>
            <h5 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight" data-aos="fade-up" data-aos-delay="200">
                Mari Wujudkan Proyek Anda Bersama Kami
            </h5>
            <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10 leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                Hubungi kami sekarang untuk konsultasi gratis dan dapatkan solusi terbaik untuk kebutuhan bisnis Anda
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center" data-aos="fade-up" data-aos-delay="400">
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
                    $waText = 'Halo, saya tertarik dengan *Kalkulator PPh Badan* dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut.';
                    $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . '?text=' . urlencode($waText)) : '#';
                @endphp
                @if($waNumber)
                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-white text-primary rounded-xl font-bold text-lg hover:bg-white/90 transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105 group min-w-[200px] justify-center"
                   style="background-color: #ffffff; color: {{ $settings['primary_color'] ?? '#D89B30' }};">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span>Hubungi via WhatsApp</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function pphBadanCalculator() {
    return {
        formData: {
            jenis: '',
            omzet: '',
            laba_komersial: '',
            beban: '',
            biaya_operasional: '',
            pendapatan_lain: '',
        },
        result: null,
        loading: false,
        error: null,
        showDetails: false,
        debounceTimer: null,

        init() {
            // Initialize currency inputs
            this.initCurrencyInputs();
            
            // Auto calculate on load if there's existing data
            if (this.hasFormData()) {
                this.debouncedCalculate();
            }
        },

        initCurrencyInputs() {
            // Format currency inputs on blur
            document.querySelectorAll('.currency-input').forEach(input => {
                input.addEventListener('blur', (e) => {
                    const value = this.parseCurrency(e.target.value);
                    e.target.value = this.formatCurrencyInput(value);
                });
            });
        },

        hasFormData() {
            if (this.formData.jenis === 'umkm') {
                return this.formData.omzet && this.formData.omzet > 0;
            }
            return this.formData.jenis === 'umum' && this.formData.omzet && this.formData.laba_komersial;
        },

        getTotalKoreksiPositif() {
            const beban = this.parseCurrency(this.formData.beban || 0);
            const biayaOperasional = this.parseCurrency(this.formData.biaya_operasional || 0);
            return beban + biayaOperasional;
        },

        getTotalKoreksiNegatif() {
            return this.parseCurrency(this.formData.pendapatan_lain || 0);
        },

        parseCurrency(value) {
            if (!value) return 0;
            // Remove all non-digit characters
            return parseFloat(value.toString().replace(/[^\d]/g, '')) || 0;
        },

        formatCurrencyInput(value) {
            if (!value) return '';
            return new Intl.NumberFormat('id-ID').format(value);
        },

        formatCurrency(value) {
            if (!value && value !== 0) return 'Rp 0';
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        },

        formatPercent(value) {
            if (!value && value !== 0) return '0';
            return new Intl.NumberFormat('id-ID', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            }).format(value);
        },

        getFormData() {
            const data = {
                jenis: this.formData.jenis,
                omzet: this.parseCurrency(this.formData.omzet),
            };
            
            if (this.formData.jenis === 'umum') {
                data.laba_komersial = this.parseCurrency(this.formData.laba_komersial);
                data.koreksi_positif = this.getTotalKoreksiPositif();
                data.koreksi_negatif = this.getTotalKoreksiNegatif();
                data.beban = this.parseCurrency(this.formData.beban || 0);
                data.biaya_operasional = this.parseCurrency(this.formData.biaya_operasional || 0);
                data.pendapatan_lain = this.parseCurrency(this.formData.pendapatan_lain || 0);
            }
            
            return data;
        },

        debouncedCalculate() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.calculate();
            }, 500);
        },

        async calculate() {
            const data = this.getFormData();
            
            // Validate required fields
            if (!data.jenis || !data.omzet || data.omzet <= 0) {
                return;
            }
            
            // For umum, also validate laba_komersial
            if (data.jenis === 'umum' && !data.laba_komersial && data.laba_komersial !== 0) {
                return;
            }

            this.loading = true;
            this.error = null;

            try {
                const response = await fetch('{{ route("pph-badan-calculator.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (result.success) {
                    this.result = result.result;
                    this.error = null;
                    // Trigger Alpine.js update
                    this.$nextTick(() => {
                        // Force re-render
                    });
                } else {
                    this.error = result.message || 'Terjadi kesalahan saat menghitung';
                    this.result = null;
                }
            } catch (error) {
                this.error = 'Terjadi kesalahan: ' + error.message;
                this.result = null;
            } finally {
                this.loading = false;
            }
        },

        resetForm() {
            this.formData = {
                jenis: '',
                omzet: '',
                laba_komersial: '',
                beban: '',
                biaya_operasional: '',
                pendapatan_lain: '',
            };
            this.result = null;
            this.error = null;
            this.showDetails = false;
        },

        getZonaLabel(zona) {
            const labels = {
                'zona1': 'Omzet ≤ Rp 4,8 Miliar',
                'zona2': 'Omzet > Rp 4,8 Miliar dan < Rp 50 Miliar',
                'zona3': 'Omzet ≥ Rp 50 Miliar',
            };
            return labels[zona] || zona;
        },

        getZonaDescription(zona) {
            const descriptions = {
                'zona1': 'Seluruh LKP mendapat fasilitas pengurangan tarif 50%',
                'zona2': 'LKP proporsional dengan omzet 4,8 M mendapat fasilitas 50%',
                'zona3': 'Tidak ada fasilitas, seluruh LKP dikenakan tarif normal 22%',
            };
            return descriptions[zona] || '';
        },
    };
}
</script>
@endpush
@endsection

