@extends('layouts.admin')

@section('title', 'Pengaturan PPh 21')
@section('page-title', 'Pengaturan PPh 21')

@section('content')
<form action="{{ route('admin.pph21-settings.update') }}" method="POST" id="pph21SettingsForm">
    @csrf
    @method('PATCH')
    
    <!-- Header with Reset Button -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Kalkulator PPh 21</h2>
            <p class="text-gray-600 mt-1">Kelola konstanta dan parameter perhitungan PPh 21</p>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="resetToDefault()" 
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                Reset ke Default
            </button>
            <button type="submit" 
                    class="px-6 py-2 bg-primary hover:bg-primary/90 text-white rounded-lg font-medium transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button type="button" 
                    onclick="switchTab('ptkp')"
                    id="tab-ptkp"
                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-primary text-primary"
                    data-tab="ptkp">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    PTKP
                </span>
            </button>
            <button type="button" 
                    onclick="switchTab('tarif')"
                    id="tab-tarif"
                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                    data-tab="tarif">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Tarif Pajak
                </span>
            </button>
            <button type="button" 
                    onclick="switchTab('batas')"
                    id="tab-batas"
                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                    data-tab="batas">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Batas Lapisan
                </span>
            </button>
        </nav>
    </div>
    
    <div class="space-y-8">
        <!-- PTKP Tab Content -->
        <div id="tab-content-ptkp" class="tab-content">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Penghasilan Tidak Kena Pajak (PTKP)</h3>
                <p class="text-sm text-gray-600 mb-6">Atur nilai PTKP berdasarkan status kawin dan jumlah tanggungan</p>
                
                <div class="space-y-6">
                    <!-- Tidak Kawin -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-800 mb-4 pb-2 border-b">Tidak Kawin (TK)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($settings['ptkp'] ?? [] as $setting)
                                @if(strpos($setting->key, 'ptkp_tk') === 0)
                                <div>
                                    <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $setting->label }}
                                    </label>
                                    <input type="number" 
                                           id="setting_{{ $setting->key }}" 
                                           name="settings[{{ $setting->key }}][value]" 
                                           value="{{ number_format($setting->value, 0, '', '') }}"
                                           step="1000"
                                           min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    @if($setting->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Kawin -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-800 mb-4 pb-2 border-b">Kawin (K)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($settings['ptkp'] ?? [] as $setting)
                                @if(strpos($setting->key, 'ptkp_k') === 0)
                                <div>
                                    <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $setting->label }}
                                    </label>
                                    <input type="number" 
                                           id="setting_{{ $setting->key }}" 
                                           name="settings[{{ $setting->key }}][value]" 
                                           value="{{ number_format($setting->value, 0, '', '') }}"
                                           step="1000"
                                           min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    @if($setting->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- PTKP Tambahan -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-800 mb-4 pb-2 border-b">PTKP Tambahan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($settings['ptkp'] ?? [] as $setting)
                                @if($setting->key === 'ptkp_tambahan')
                                <div>
                                    <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $setting->label }}
                                    </label>
                                    <input type="number" 
                                           id="setting_{{ $setting->key }}" 
                                           name="settings[{{ $setting->key }}][value]" 
                                           value="{{ number_format($setting->value, 0, '', '') }}"
                                           step="1000"
                                           min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    @if($setting->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarif Tab Content -->
        <div id="tab-content-tarif" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tarif Pajak Pasal 17</h3>
                <p class="text-sm text-gray-600 mb-6">Atur tarif pajak progresif untuk perhitungan PPh 21</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($settings['tarif'] ?? [] as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $setting->label }}
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   id="setting_{{ $setting->key }}" 
                                   name="settings[{{ $setting->key }}][value]" 
                                   value="{{ $setting->value }}"
                                   step="0.01"
                                   min="0"
                                   max="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <span class="absolute right-3 top-2 text-gray-500">%</span>
                        </div>
                        @if($setting->description)
                        <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                        @endif
                        <p class="text-xs text-blue-600 mt-1">Nilai: {{ number_format($setting->value * 100, 2) }}%</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Batas Tab Content -->
        <div id="tab-content-batas" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Batas Lapisan Tarif</h3>
                <p class="text-sm text-gray-600 mb-6">Atur batas atas untuk setiap lapisan tarif pajak</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($settings['batas'] ?? [] as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $setting->label }}
                        </label>
                        <input type="number" 
                               id="setting_{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}][value]" 
                               value="{{ number_format($setting->value, 0, '', '') }}"
                               step="1000000"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        @if($setting->description)
                        <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active state from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-primary', 'text-primary');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById('tab-content-' + tabName).classList.remove('hidden');
        
        // Add active state to selected tab
        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-primary', 'text-primary');
    }

    function resetToDefault() {
        if (confirm('Apakah Anda yakin ingin mereset semua pengaturan ke nilai default? Perubahan yang belum disimpan akan hilang.')) {
            window.location.href = '{{ route("admin.pph21-settings.reset") }}';
        }
    }

    // Format number inputs on blur
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                // For percentage inputs (tarif), keep decimal
                if (this.name.includes('tarif')) {
                    this.value = parseFloat(this.value).toFixed(2);
                } else {
                    // For other inputs, format as integer
                    this.value = Math.round(parseFloat(this.value));
                }
            }
        });
    });
</script>
@endsection

