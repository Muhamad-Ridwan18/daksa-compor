@extends('layouts.frontend')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 md:py-12" x-data="pphBadanCalculator()" x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Kalkulator PPh Badan
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Hitung Pajak Penghasilan Badan dengan mudah dan akurat sesuai peraturan terbaru 2024. Perhitungan fasilitas UMKM dan tarif pajak badan.
            </p>
        </div>

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

