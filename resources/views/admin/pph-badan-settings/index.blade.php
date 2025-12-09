@extends('layouts.admin')

@section('title', 'Pengaturan PPh Badan')
@section('page-title', 'Pengaturan PPh Badan')

@section('content')
<form action="{{ route('admin.pph-badan-settings.update') }}" method="POST" id="pphBadanSettingsForm">
    @csrf
    @method('PATCH')
    
    <!-- Header with Reset Button -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Kalkulator PPh Badan</h2>
            <p class="text-gray-600 mt-1">Kelola konstanta dan parameter perhitungan PPh Badan</p>
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

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button type="button" 
                    onclick="switchTab('fasilitas')"
                    id="tab-fasilitas"
                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-primary text-primary"
                    data-tab="fasilitas">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Batas Fasilitas
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
        </nav>
    </div>
    
    <div class="space-y-8">
        <!-- Fasilitas Tab Content -->
        <div id="tab-content-fasilitas" class="tab-content">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Batas Fasilitas PPh Badan</h3>
                <p class="text-sm text-gray-600 mb-6">Atur batas omzet untuk menentukan zona fasilitas</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($settings['fasilitas'] ?? [] as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $setting->label }}
                        </label>
                        <input type="text" 
                               id="setting_{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}][value]" 
                               data-original-value="{{ $setting->value }}"
                               value="{{ number_format($setting->value, 0, ',', '.') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary number-input">
                        @if($setting->description)
                        <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tarif Tab Content -->
        <div id="tab-content-tarif" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tarif PPh Badan</h3>
                <p class="text-sm text-gray-600 mb-6">Atur tarif pajak dan persentase fasilitas</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($settings['tarif'] ?? [] as $setting)
                    <div>
                        <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $setting->label }}
                        </label>
                        <div class="relative">
                            @if($setting->key === 'tarif_pph_badan')
                                <input type="number" 
                                       id="setting_{{ $setting->key }}" 
                                       name="settings[{{ $setting->key }}][value]" 
                                       value="{{ $setting->value }}"
                                       step="0.01"
                                       min="0"
                                       max="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                <span class="absolute right-3 top-2 text-gray-500">%</span>
                                <p class="text-xs text-blue-600 mt-1">Nilai: {{ number_format($setting->value * 100, 2, ',', '.') }}%</p>
                            @else
                                <input type="number" 
                                       id="setting_{{ $setting->key }}" 
                                       name="settings[{{ $setting->key }}][value]" 
                                       value="{{ $setting->value }}"
                                       step="0.01"
                                       min="0"
                                       max="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                <span class="absolute right-3 top-2 text-gray-500">%</span>
                                <p class="text-xs text-blue-600 mt-1">Nilai: {{ number_format($setting->value * 100, 2, ',', '.') }}%</p>
                            @endif
                        </div>
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
            window.location.href = '{{ route("admin.pph-badan-settings.reset") }}';
        }
    }

    // Format number dengan titik pemisah ribuan
    function formatNumberWithDots(value) {
        if (!value && value !== 0) return '';
        
        // Hapus semua karakter non-digit
        let numStr = value.toString().replace(/[^\d]/g, '');
        
        // Jika kosong, return empty
        if (!numStr) return '';
        
        // Parse sebagai integer
        const num = parseInt(numStr);
        if (isNaN(num)) return '';
        
        // Format dengan titik pemisah ribuan (format Indonesia)
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Hapus format (titik) untuk submit
    function removeFormat(value) {
        if (!value) return '';
        return value.toString().replace(/\./g, '');
    }

    // Format semua input number saat load
    document.querySelectorAll('.number-input').forEach(input => {
        // Format saat input (real-time)
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Simpan cursor position
            const cursorPos = e.target.selectionStart;
            
            // Hapus semua karakter non-digit
            value = value.replace(/[^\d]/g, '');
            
            if (value) {
                const formatted = formatNumberWithDots(value);
                e.target.value = formatted;
                
                // Restore cursor position (adjust for added dots)
                const newCursorPos = cursorPos + (formatted.length - value.length);
                e.target.setSelectionRange(newCursorPos, newCursorPos);
            } else {
                e.target.value = '';
            }
        });

        // Format saat blur (final format)
        input.addEventListener('blur', function() {
            if (this.value) {
                const num = removeFormat(this.value);
                if (num && !isNaN(num)) {
                    this.value = formatNumberWithDots(parseInt(num));
                } else {
                    this.value = '';
                }
            }
        });

        // Format saat focus (jika kosong, set ke 0)
        input.addEventListener('focus', function() {
            if (!this.value) {
                this.value = '';
            }
        });
    });

    // Konversi nilai sebelum submit (hapus semua titik)
    document.getElementById('pphBadanSettingsForm').addEventListener('submit', function(e) {
        document.querySelectorAll('.number-input').forEach(input => {
            const formattedValue = input.value;
            const numericValue = removeFormat(formattedValue);
            // Set nilai tanpa format untuk submit
            input.value = numericValue || '0';
        });
    });
</script>
@endsection

