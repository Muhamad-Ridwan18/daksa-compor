@extends('layouts.frontend')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 md:py-12" x-data="pph21Tahunan()" x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Kalkulator PPh 21 Tahunan
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Hitung Pajak Penghasilan Pasal 21 Tahunan dengan format sederhana sesuai ketentuan perpajakan
            </p>
        </div>

        <!-- Main Content: Form & Result Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <!-- Left: Form Section -->
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Input Data</h2>
                
                <form id="pph21-tahunan-form" @submit.prevent="calculate()">
                    <!-- A. Penghasilan -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                            A. Penghasilan
                        </h3>
                        
                        <!-- A.1 Penghasilan Bruto -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                A.1 Penghasilan Bruto <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 font-normal">(Penjumlahan dari semua tunjangan)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input 
                                    type="text" 
                                    name="penghasilan_bruto"
                                    x-model="formData.penghasilan_bruto"
                                    class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="0"
                                    @input="debouncedCalculate()"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- B. Pengurang -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                            B. Pengurang
                        </h3>
                        
                        <!-- B.1 Biaya Jabatan (Info) -->
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-blue-700">
                                    <strong>B.1 Biaya Jabatan:</strong> Dihitung otomatis 5% dari Penghasilan Bruto (Maksimal Rp 6.000.000/tahun)
                                </div>
                            </div>
                        </div>

                        <!-- B.2 Iuran Pensiun -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                B.2 Iuran Pensiun
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input 
                                    type="text" 
                                    name="iuran_pensiun"
                                    x-model="formData.iuran_pensiun"
                                    class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="0"
                                    @input="debouncedCalculate()"
                                >
                            </div>
                        </div>

                        <!-- B.3 Zakat / Sumbangan -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                B.3 Zakat / Sumbangan
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input 
                                    type="text" 
                                    name="zakat"
                                    x-model="formData.zakat"
                                    class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="0"
                                    @input="debouncedCalculate()"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- PTKP -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                            Informasi PTKP
                        </h3>
                        
                        <!-- Status Kawin -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status Kawin <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                                       :class="formData.status_kawin === 'TK' ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" x-model="formData.status_kawin" value="TK" class="sr-only" @change="debouncedCalculate()">
                                    <span class="text-sm font-medium">Tidak Kawin (TK)</span>
                                </label>
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all"
                                       :class="formData.status_kawin === 'K' ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" x-model="formData.status_kawin" value="K" class="sr-only" @change="debouncedCalculate()">
                                    <span class="text-sm font-medium">Kawin (K)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Jumlah Tanggungan -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Tanggungan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                x-model.number="formData.tanggungan"
                                min="0" 
                                max="10" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                @input="debouncedCalculate()"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-500">Maksimal 10 tanggungan</p>
                        </div>
                    </div>

                    <!-- C.8 PPh Yang Sudah Disetor -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">
                            C. Penghitungan PPh Pasal 21
                        </h3>
                        
                        <!-- C.8 PPh Yang Sudah Disetor -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                C.8 PPh Pasal 21 Yang Sudah di Setor
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input 
                                    type="text" 
                                    name="pph_sudah_disetor"
                                    x-model="formData.pph_sudah_disetor"
                                    class="currency-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="0"
                                    @input="debouncedCalculate()"
                                >
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
                    <!-- A. Penghasilan -->
                    <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">A. Penghasilan</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">A.1 Penghasilan Bruto</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.a_penghasilan_bruto)"></span>
                            </div>
                        </div>
                    </div>

                    <!-- B. Pengurang -->
                    <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">B. Pengurang</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">B.1 Biaya Jabatan (5%, maks 6jt)</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.b_biaya_jabatan)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">B.2 Iuran Pensiun</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.b_iuran_pensiun)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">B.3 Zakat / Sumbangan</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.b_zakat)"></span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-900">Jumlah Pengurang</span>
                                    <span class="font-bold text-lg text-gray-900" x-text="formatCurrency(result.b_jumlah_pengurang)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- C. Penghitungan PPh Pasal 21 -->
                    <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">C. Penghitungan PPh Pasal 21</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.1 Jumlah Pengurang</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c1_jumlah_pengurang)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.2 Penghasilan Netto</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c2_penghasilan_neto)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.3 Penghasilan Neto Setahun/Disetahunkan</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c3_penghasilan_neto_setahun)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.4 Penghasilan Tidak Kena Pajak (PTKP)</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c4_ptkp)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.5 PKP Setahun/Disetahunkan</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c5_pkp_setahun)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.6 PPh Pasal 21 atas PKP</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c6_pph_atas_pkp)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.7 PPh Pasal 21 Dipotong Masa Sebelumnya</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c7_pph_dipotong_masa_sebelumnya)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">C.8 PPh Pasal 21 Yang Sudah di Setor</span>
                                <span class="font-semibold text-gray-900" x-text="formatCurrency(result.c8_pph_sudah_disetor)"></span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-lg text-gray-900">C.9 PPh Pasal 21 Terutang bulan ini</span>
                                    <span class="font-bold text-2xl text-primary" x-text="formatCurrency(result.c9_pph_terutang_bulan_ini)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div x-show="!result && !loading && !error" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">Lengkapi form di sebelah kiri untuk melihat hasil perhitungan</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function pph21Tahunan() {
    return {
        formData: {
            penghasilan_bruto: '',
            iuran_pensiun: '',
            zakat: '',
            status_kawin: 'TK',
            tanggungan: 0,
            pph_sudah_disetor: ''
        },
        result: null,
        loading: false,
        error: null,
        debounceTimer: null,

        init() {
            // Initialize currency formatting
            this.$nextTick(() => {
                setTimeout(() => {
                    if (window.PPh21Calculator) {
                        window.PPh21Calculator.initCurrencyFormatting();
                    }
                }, 100);
            });
        },

        debouncedCalculate() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.calculate();
            }, 500);
        },

        async calculate() {
            // Validate required fields
            if (!this.formData.penghasilan_bruto || this.formData.tanggungan === null || !this.formData.status_kawin) {
                return;
            }

            this.loading = true;
            this.error = null;

            try {
                // Prepare form data - unformat currency values
                const data = {
                    penghasilan_bruto: this.unformatCurrency(this.formData.penghasilan_bruto),
                    iuran_pensiun: this.unformatCurrency(this.formData.iuran_pensiun),
                    zakat: this.unformatCurrency(this.formData.zakat),
                    status_kawin: this.formData.status_kawin,
                    tanggungan: this.formData.tanggungan,
                    pph_sudah_disetor: this.unformatCurrency(this.formData.pph_sudah_disetor)
                };

                const response = await fetch('{{ route("pph21-tahunan.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const responseData = await response.json();

                if (!response.ok) {
                    if (response.status === 422 && responseData.errors) {
                        const errorMessages = Object.values(responseData.errors).flat();
                        throw new Error(errorMessages.join(', ') || 'Validasi gagal');
                    }
                    throw new Error(responseData.message || 'Terjadi kesalahan saat menghitung');
                }

                if (responseData.success) {
                    this.result = responseData.result;
                } else {
                    throw new Error(responseData.message || 'Terjadi kesalahan');
                }
            } catch (error) {
                console.error('Calculation error:', error);
                this.error = error.message || 'Terjadi kesalahan saat menghitung. Silakan coba lagi.';
                this.result = null;
            } finally {
                this.loading = false;
            }
        },

        resetForm() {
            this.formData = {
                penghasilan_bruto: '',
                iuran_pensiun: '',
                zakat: '',
                status_kawin: 'TK',
                tanggungan: 0,
                pph_sudah_disetor: ''
            };
            this.result = null;
            this.error = null;
        },

        formatCurrency(value) {
            if (!value && value !== 0) return 'Rp 0';
            const num = typeof value === 'string' ? parseFloat(value.replace(/\./g, '')) : value;
            if (isNaN(num)) return 'Rp 0';
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },

        unformatCurrency(value) {
            if (!value) return '0';
            return String(value).replace(/\./g, '').replace(/[^\d]/g, '') || '0';
        }
    }
}
</script>
@endpush
@endsection

