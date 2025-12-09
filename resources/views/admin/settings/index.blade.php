@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    
    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button type="button" 
                    onclick="switchTab('general')"
                    id="tab-general"
                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-primary text-primary"
                    data-tab="general">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Umum
                </span>
            </button>
            <button type="button" 
                    onclick="switchTab('seo')"
                    id="tab-seo"
                    class="tab-button py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                    data-tab="seo">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    SEO
                </span>
            </button>
        </nav>
    </div>
    
    <div class="space-y-8">
        <!-- General Tab Content -->
        <div id="tab-content-general" class="tab-content">
        <!-- Site Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Website</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Website</label>
                    <input type="text" id="site_title" name="settings[site_title][value]" 
                           value="{{ $settings->where('key', 'site_title')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                    <input type="text" id="site_description" name="settings[site_description][value]" 
                           value="{{ $settings->where('key', 'site_description')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
            </div>
        </div>

        <!-- Company Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Perusahaan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                    <input type="text" id="company_name" name="settings[company_name][value]" 
                           value="{{ $settings->where('key', 'company_name')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="company_phone" name="settings[company_phone][value]" 
                           value="{{ $settings->where('key', 'company_phone')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="company_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="company_email" name="settings[company_email][value]" 
                           value="{{ $settings->where('key', 'company_email')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" id="whatsapp_number" name="settings[whatsapp_number][value]" 
                           value="{{ $settings->where('key', 'whatsapp_number')->first()->value ?? '' }}"
                           placeholder="Contoh: 6281234567890 (tanpa +)"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    <p class="text-xs text-gray-500 mt-1">Format internasional tanpa + atau spasi. Contoh: 62812xxxxxxx</p>
                </div>
                <div>
                    <label for="company_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input type="text" id="company_address" name="settings[company_address][value]" 
                           value="{{ $settings->where('key', 'company_address')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="md:col-span-2">
                    <label for="whatsapp_template" class="block text-sm font-medium text-gray-700 mb-2">Template Pesan WhatsApp (opsional)</label>
                    <textarea id="whatsapp_template" name="settings[whatsapp_template][value]" rows="3"
                              placeholder="Halo, saya tertarik dengan layanan {{ $settings->where('key', 'company_name')->first()->value ?? 'Daksa' }}. Mohon informasi lebih lanjut."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ $settings->where('key', 'whatsapp_template')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Pesan ini akan otomatis terisi saat membuka WhatsApp. Kosongkan jika tidak perlu.</p>
                </div>
                <div class="md:col-span-2">
                    <label for="gmaps_embed_url" class="block text-sm font-medium text-gray-700 mb-2">Google Maps Embed URL (opsional)</label>
                    <input type="url" id="gmaps_embed_url" name="settings[gmaps_embed_url][value]" 
                           value="{{ $settings->where('key', 'gmaps_embed_url')->first()->value ?? '' }}"
                           placeholder="https://www.google.com/maps/embed?pb=..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    <p class="text-xs text-gray-500 mt-2">Jika dikosongkan, peta akan menggunakan alamat pada kolom di atas. Untuk mendapatkan Embed URL: buka Google Maps → cari alamat → tombol Bagikan → sematkan peta → salin URL src.</p>
                    <div class="mt-2 text-xs text-gray-600">
                        Contoh (pendek): <code class="bg-gray-100 px-1 py-0.5 rounded">https://www.google.com/maps?q=Monas%20Jakarta&output=embed</code><br>
                        Contoh (resmi embed): <code class="bg-gray-100 px-1 py-0.5 rounded">https://www.google.com/maps/embed?pb=!1m18!1m12!...</code>
                    </div>
                </div>
                <div>
                    <label for="gmaps_latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude (opsional)</label>
                    <input type="text" id="gmaps_latitude" name="settings[gmaps_latitude][value]"
                           value="{{ $settings->where('key', 'gmaps_latitude')->first()->value ?? '' }}"
                           placeholder="-6.175392"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    <p class="text-xs text-gray-500 mt-1">Isi bersama Longitude untuk pin akurat.</p>
                </div>
                <div>
                    <label for="gmaps_longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude (opsional)</label>
                    <input type="text" id="gmaps_longitude" name="settings[gmaps_longitude][value]"
                           value="{{ $settings->where('key', 'gmaps_longitude')->first()->value ?? '' }}"
                           placeholder="106.827153"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="gmaps_zoom" class="block text-sm font-medium text-gray-700 mb-2">Zoom (opsional)</label>
                    <input type="number" min="1" max="21" id="gmaps_zoom" name="settings[gmaps_zoom][value]"
                           value="{{ $settings->where('key', 'gmaps_zoom')->first()->value ?? 15 }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    <p class="text-xs text-gray-500 mt-1">Semakin besar angka, semakin dekat (default 15).</p>
                </div>
            </div>
            <div class="mt-4">
                <label for="company_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Perusahaan</label>
                <textarea id="company_description" name="settings[company_description][value]" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ $settings->where('key', 'company_description')->first()->value ?? '' }}</textarea>
            </div>
        </div>

        <!-- Logo & Branding -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Logo & Branding</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo Perusahaan</label>
                    @php
                        $logo = $settings->where('key', 'logo')->first();
                        $logoValue = $logo ? $logo->value : '';
                    @endphp
                    
                    @if($logoValue)
                        <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                            <img src="{{ Storage::url($logoValue) }}" alt="Logo" class="h-16 w-auto">
                        </div>
                    @endif
                    
                    <input type="file" id="logo" name="logo" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                           onchange="previewImage(this, 'logo_preview')">
                    <input type="hidden" name="settings[logo][value]" value="{{ $logoValue }}">
                    <input type="hidden" name="settings[logo][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG dengan background transparan (Max: 2MB). Ukuran ideal: 200x60px</p>
                    
                    <div id="logo_preview" class="mt-3 hidden p-4 bg-gray-50 rounded-lg">
                        <img src="" alt="Preview" class="h-16 w-auto">
                    </div>
                </div>
                
                <div>
                    <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                    @php
                        $favicon = $settings->where('key', 'favicon')->first();
                        $faviconValue = $favicon ? $favicon->value : '';
                    @endphp
                    
                    @if($faviconValue)
                        <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                            <img src="{{ Storage::url($faviconValue) }}" alt="Favicon" class="h-12 w-12">
                        </div>
                    @endif
                    
                    <input type="file" id="favicon" name="favicon" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                           onchange="previewImage(this, 'favicon_preview')">
                    <input type="hidden" name="settings[favicon][value]" value="{{ $faviconValue }}">
                    <input type="hidden" name="settings[favicon][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: ICO atau PNG (Max: 1MB). Ukuran ideal: 32x32px atau 64x64px</p>
                    
                    <div id="favicon_preview" class="mt-3 hidden p-4 bg-gray-50 rounded-lg">
                        <img src="" alt="Preview" class="h-12 w-12">
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Colors -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Warna Tema</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">Warna Utama</label>
                    <div class="flex items-center space-x-2">
                        <input type="color" id="primary_color" name="settings[primary_color][value]" 
                               value="{{ $settings->where('key', 'primary_color')->first()->value ?? '#D89B30' }}"
                               class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                        <input type="text" value="{{ $settings->where('key', 'primary_color')->first()->value ?? '#D89B30' }}"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               onchange="document.getElementById('primary_color').value = this.value">
                    </div>
                </div>
                <div>
                    <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">Warna Sekunder</label>
                    <div class="flex items-center space-x-2">
                        <input type="color" id="secondary_color" name="settings[secondary_color][value]" 
                               value="{{ $settings->where('key', 'secondary_color')->first()->value ?? '#4B2E1A' }}"
                               class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                        <input type="text" value="{{ $settings->where('key', 'secondary_color')->first()->value ?? '#4B2E1A' }}"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               onchange="document.getElementById('secondary_color').value = this.value">
                    </div>
                </div>
                <div>
                    <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">Warna Background</label>
                    <div class="flex items-center space-x-2">
                        <input type="color" id="background_color" name="settings[background_color][value]" 
                               value="{{ $settings->where('key', 'background_color')->first()->value ?? '#F5F7FA' }}"
                               class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                        <input type="text" value="{{ $settings->where('key', 'background_color')->first()->value ?? '#F5F7FA' }}"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               onchange="document.getElementById('background_color').value = this.value">
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Hero Section</h3>
            <div class="space-y-4">
                <div>
                    <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Hero</label>
                    <input type="text" id="hero_title" name="settings[hero_title][value]" 
                           value="{{ $settings->where('key', 'hero_title')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="hero_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Hero</label>
                    <textarea id="hero_description" name="settings[hero_description][value]" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ $settings->where('key', 'hero_description')->first()->value ?? '' }}</textarea>
                </div>
            </div>
            
            <h4 class="text-md font-semibold text-gray-900 mt-6 mb-4">Hero Carousel Images</h4>
            <p class="text-sm text-gray-600 mb-4">Upload gambar untuk setiap slide hero carousel. Ukuran yang disarankan: 800x600px atau lebih besar.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Hero Image 1 -->
                <div>
                    <label for="hero_image_1" class="block text-sm font-medium text-gray-700 mb-2">Gambar Hero Slide 1</label>
                    @php
                        $heroImage1 = $settings->where('key', 'hero_image_1')->first();
                        $heroImage1Value = $heroImage1 ? $heroImage1->value : '';
                    @endphp
                    
                    @if($heroImage1Value)
                        <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                            <img src="{{ Storage::url($heroImage1Value) }}" alt="Hero Image 1" class="w-full h-32 object-cover rounded">
                        </div>
                    @endif
                    
                    <input type="file" id="hero_image_1" name="hero_image_1" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                           onchange="previewImage(this, 'hero_image_1_preview')">
                    <input type="hidden" name="settings[hero_image_1][value]" value="{{ $heroImage1Value }}">
                    <input type="hidden" name="settings[hero_image_1][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 5MB)</p>
                    
                    <div id="hero_image_1_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                        <img src="" alt="Preview" class="w-full h-32 object-cover rounded">
                    </div>
                </div>
                
                <!-- Hero Image 2 -->
                <div>
                    <label for="hero_image_2" class="block text-sm font-medium text-gray-700 mb-2">Gambar Hero Slide 2</label>
                    @php
                        $heroImage2 = $settings->where('key', 'hero_image_2')->first();
                        $heroImage2Value = $heroImage2 ? $heroImage2->value : '';
                    @endphp
                    
                    @if($heroImage2Value)
                        <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                            <img src="{{ Storage::url($heroImage2Value) }}" alt="Hero Image 2" class="w-full h-32 object-cover rounded">
                        </div>
                    @endif
                    
                    <input type="file" id="hero_image_2" name="hero_image_2" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                           onchange="previewImage(this, 'hero_image_2_preview')">
                    <input type="hidden" name="settings[hero_image_2][value]" value="{{ $heroImage2Value }}">
                    <input type="hidden" name="settings[hero_image_2][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 5MB)</p>
                    
                    <div id="hero_image_2_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                        <img src="" alt="Preview" class="w-full h-32 object-cover rounded">
                    </div>
                </div>
                
                <!-- Hero Image 3 -->
                <div>
                    <label for="hero_image_3" class="block text-sm font-medium text-gray-700 mb-2">Gambar Hero Slide 3</label>
                    @php
                        $heroImage3 = $settings->where('key', 'hero_image_3')->first();
                        $heroImage3Value = $heroImage3 ? $heroImage3->value : '';
                    @endphp
                    
                    @if($heroImage3Value)
                        <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                            <img src="{{ Storage::url($heroImage3Value) }}" alt="Hero Image 3" class="w-full h-32 object-cover rounded">
                        </div>
                    @endif
                    
                    <input type="file" id="hero_image_3" name="hero_image_3" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                           onchange="previewImage(this, 'hero_image_3_preview')">
                    <input type="hidden" name="settings[hero_image_3][value]" value="{{ $heroImage3Value }}">
                    <input type="hidden" name="settings[hero_image_3][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 5MB)</p>
                    
                    <div id="hero_image_3_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                        <img src="" alt="Preview" class="w-full h-32 object-cover rounded">
                    </div>
                </div>
            </div>
            <div class="mt-6">
                {{-- <h4 class="text-md font-semibold text-gray-900 mb-4">Background Hero</h4>
                <p class="text-sm text-gray-600 mb-4">Upload gambar background untuk hero section. Jika tidak ada, akan menggunakan gradient default. Ukuran yang disarankan: 1920x1080px atau lebih besar.</p>
                
                <div>
                    <label for="hero_background_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Background Hero</label>
                    @php
                        $heroBackgroundImage = $settings->where('key', 'hero_background_image')->first();
                        $heroBackgroundImageValue = $heroBackgroundImage ? $heroBackgroundImage->value : '';
                    @endphp
                    
                    @if($heroBackgroundImageValue)
                        <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                            <img src="{{ Storage::url($heroBackgroundImageValue) }}" alt="Hero Background" class="w-full h-48 object-cover rounded">
                        </div>
                    @endif
                    
                    <input type="file" id="hero_background_image" name="hero_background_image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                           onchange="previewImage(this, 'hero_background_image_preview')">
                    <input type="hidden" name="settings[hero_background_image][value]" value="{{ $heroBackgroundImageValue }}">
                    <input type="hidden" name="settings[hero_background_image][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 10MB)</p>
                    
                    <div id="hero_background_image_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                        <img src="" alt="Preview" class="w-full h-48 object-cover rounded">
                    </div>
                </div> --}}
                
                <!-- Individual Slide Backgrounds -->
                <div class="mt-6">
                    <h5 class="text-sm font-semibold text-gray-900 mb-3">Background Setiap Slide</h5>
                    <p class="text-xs text-gray-600 mb-4">Upload gambar background khusus untuk setiap slide. Jika tidak ada, akan menggunakan background utama atau gradient default.</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Slide 1 Background -->
                        <div>
                            <label for="hero_slide_bg_1" class="block text-sm font-medium text-gray-700 mb-2">Background Slide 1</label>
                            @php
                                $heroSlideBg1 = $settings->where('key', 'hero_slide_bg_1')->first();
                                $heroSlideBg1Value = $heroSlideBg1 ? $heroSlideBg1->value : '';
                            @endphp
                            
                            @if($heroSlideBg1Value)
                                <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                                    <img src="{{ Storage::url($heroSlideBg1Value) }}" alt="Hero Slide 1 BG" class="w-full h-32 object-cover rounded">
                                </div>
                            @endif
                            
                            <input type="file" id="hero_slide_bg_1" name="hero_slide_bg_1" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                                   onchange="previewImage(this, 'hero_slide_bg_1_preview')">
                            <input type="hidden" name="settings[hero_slide_bg_1][value]" value="{{ $heroSlideBg1Value }}">
                            <input type="hidden" name="settings[hero_slide_bg_1][type]" value="image">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 10MB)</p>
                            
                            <div id="hero_slide_bg_1_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                                <img src="" alt="Preview" class="w-full h-32 object-cover rounded">
                            </div>
                        </div>
                        
                        <!-- Slide 2 Background -->
                        <div>
                            <label for="hero_slide_bg_2" class="block text-sm font-medium text-gray-700 mb-2">Background Slide 2</label>
                            @php
                                $heroSlideBg2 = $settings->where('key', 'hero_slide_bg_2')->first();
                                $heroSlideBg2Value = $heroSlideBg2 ? $heroSlideBg2->value : '';
                            @endphp
                            
                            @if($heroSlideBg2Value)
                                <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                                    <img src="{{ Storage::url($heroSlideBg2Value) }}" alt="Hero Slide 2 BG" class="w-full h-32 object-cover rounded">
                                </div>
                            @endif
                            
                            <input type="file" id="hero_slide_bg_2" name="hero_slide_bg_2" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                                   onchange="previewImage(this, 'hero_slide_bg_2_preview')">
                            <input type="hidden" name="settings[hero_slide_bg_2][value]" value="{{ $heroSlideBg2Value }}">
                            <input type="hidden" name="settings[hero_slide_bg_2][type]" value="image">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 10MB)</p>
                            
                            <div id="hero_slide_bg_2_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                                <img src="" alt="Preview" class="w-full h-32 object-cover rounded">
                            </div>
                        </div>
                        
                        <!-- Slide 3 Background -->
                        <div>
                            <label for="hero_slide_bg_3" class="block text-sm font-medium text-gray-700 mb-2">Background Slide 3</label>
                            @php
                                $heroSlideBg3 = $settings->where('key', 'hero_slide_bg_3')->first();
                                $heroSlideBg3Value = $heroSlideBg3 ? $heroSlideBg3->value : '';
                            @endphp
                            
                            @if($heroSlideBg3Value)
                                <div class="mb-3 p-2 bg-gray-50 rounded-lg">
                                    <img src="{{ Storage::url($heroSlideBg3Value) }}" alt="Hero Slide 3 BG" class="w-full h-32 object-cover rounded">
                                </div>
                            @endif
                            
                            <input type="file" id="hero_slide_bg_3" name="hero_slide_bg_3" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm"
                                   onchange="previewImage(this, 'hero_slide_bg_3_preview')">
                            <input type="hidden" name="settings[hero_slide_bg_3][value]" value="{{ $heroSlideBg3Value }}">
                            <input type="hidden" name="settings[hero_slide_bg_3][type]" value="image">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 10MB)</p>
                            
                            <div id="hero_slide_bg_3_preview" class="mt-3 hidden p-2 bg-gray-50 rounded-lg">
                                <img src="" alt="Preview" class="w-full h-32 object-cover rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visi dan Misi Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Visi dan Misi</h3>
            <div class="space-y-4">
                <div>
                    <label for="vision_mission_intro" class="block text-sm font-medium text-gray-700 mb-2">Teks Pengantar</label>
                    <textarea id="vision_mission_intro" name="settings[vision_mission_intro][value]" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                              placeholder="Kami merupakan pelopor Jasa Pelatihan Accurate Accounting Software pertama di Indonesia...">{{ $settings->where('key', 'vision_mission_intro')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Teks pengantar yang ditampilkan di bawah judul "Visi dan Misi Kami"</p>
                </div>
                <div>
                    <label for="company_mission" class="block text-sm font-medium text-gray-700 mb-2">Misi Kami</label>
                    <textarea id="company_mission" name="settings[company_mission][value]" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                              placeholder="Masukkan misi perusahaan, setiap poin dipisahkan dengan baris baru">{{ $settings->where('key', 'company_mission')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Masukkan setiap poin misi dalam baris terpisah</p>
                </div>
                <div>
                    <label for="company_vision" class="block text-sm font-medium text-gray-700 mb-2">Visi Kami</label>
                    <textarea id="company_vision" name="settings[company_vision][value]" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                              placeholder="Masukkan visi perusahaan">{{ $settings->where('key', 'company_vision')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Masukkan visi perusahaan</p>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Section Tentang Kami</h3>
            <div class="space-y-4">
                <div>
                    <label for="about_title" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                    <input type="text" id="about_title" name="settings[about_title][value]" 
                           value="{{ $settings->where('key', 'about_title')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="about_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea id="about_description" name="settings[about_description][value]" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ $settings->where('key', 'about_description')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Ditampilkan di bagian atas section</p>
                </div>
                <div>
                    <label for="about_content" class="block text-sm font-medium text-gray-700 mb-2">Konten Detail</label>
                    <textarea id="about_content" name="settings[about_content][value]" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ $settings->where('key', 'about_content')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Ditampilkan di sebelah gambar</p>
                </div>
                <div>
                    <label for="about_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                    @php
                        $aboutImage = $settings->where('key', 'about_image')->first();
                        $aboutImageValue = $aboutImage ? $aboutImage->value : '';
                    @endphp
                    
                    @if($aboutImageValue)
                        <div class="mb-3">
                            <img src="{{ Storage::url($aboutImageValue) }}" alt="About Image" class="h-40 w-auto rounded-lg shadow-sm">
                        </div>
                    @endif
                    
                    <input type="file" id="about_image" name="about_image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                           onchange="previewImage(this, 'about_image_preview')">
                    <input type="hidden" name="settings[about_image][value]" value="{{ $aboutImageValue }}">
                    <input type="hidden" name="settings[about_image][type]" value="image">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB). Ukuran ideal: 800x600px</p>
                    
                    <div id="about_image_preview" class="mt-3 hidden">
                        <img src="" alt="Preview" class="h-40 w-auto rounded-lg shadow-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Settings -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Produk</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label for="show_price" class="block text-sm font-medium text-gray-700 mb-1">Tampilkan Harga Produk</label>
                        <p class="text-xs text-gray-500">Aktifkan untuk menampilkan harga produk di halaman depan</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="settings[show_price][type]" value="boolean">
                        <input type="hidden" name="settings[show_price][value]" value="0">
                        <input type="checkbox" 
                               id="show_price" 
                               name="settings[show_price][value]" 
                               value="1"
                               {{ ($settings->where('key', 'show_price')->first()->value ?? '1') == '1' ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik (Ditampilkan di Homepage)</h3>
            <p class="text-sm text-gray-600 mb-6">Atur angka dan label untuk 4 statistik yang ditampilkan di atas section Galeri</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat 1 -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Statistik 1</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="stat_1" class="block text-sm font-medium text-gray-700 mb-2">Angka</label>
                            <input type="number" id="stat_1" name="settings[stat_1][value]" 
                                   value="{{ $settings->where('key', 'stat_1')->first()->value ?? '250' }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="stat_1_label" class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                            <input type="text" id="stat_1_label" name="settings[stat_1_label][value]" 
                                   value="{{ $settings->where('key', 'stat_1_label')->first()->value ?? 'Klien' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   placeholder="Contoh: Klien, Proyek, dll">
                        </div>
                    </div>
                </div>
                
                <!-- Stat 2 -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Statistik 2</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="stat_2" class="block text-sm font-medium text-gray-700 mb-2">Angka</label>
                            <input type="number" id="stat_2" name="settings[stat_2][value]" 
                                   value="{{ $settings->where('key', 'stat_2')->first()->value ?? '100' }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="stat_2_label" class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                            <input type="text" id="stat_2_label" name="settings[stat_2_label][value]" 
                                   value="{{ $settings->where('key', 'stat_2_label')->first()->value ?? 'Proyek' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   placeholder="Contoh: Klien, Proyek, dll">
                        </div>
                    </div>
                </div>
                
                <!-- Stat 3 -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Statistik 3</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="stat_3" class="block text-sm font-medium text-gray-700 mb-2">Angka</label>
                            <input type="number" id="stat_3" name="settings[stat_3][value]" 
                                   value="{{ $settings->where('key', 'stat_3')->first()->value ?? '20' }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="stat_3_label" class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                            <input type="text" id="stat_3_label" name="settings[stat_3_label][value]" 
                                   value="{{ $settings->where('key', 'stat_3_label')->first()->value ?? 'Tahun' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   placeholder="Contoh: Klien, Proyek, dll">
                        </div>
                    </div>
                </div>
                
                <!-- Stat 4 -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Statistik 4</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="stat_4" class="block text-sm font-medium text-gray-700 mb-2">Angka</label>
                            <input type="number" id="stat_4" name="settings[stat_4][value]" 
                                   value="{{ $settings->where('key', 'stat_4')->first()->value ?? '8' }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="stat_4_label" class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                            <input type="text" id="stat_4_label" name="settings[stat_4_label][value]" 
                                   value="{{ $settings->where('key', 'stat_4_label')->first()->value ?? 'Award' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   placeholder="Contoh: Klien, Proyek, dll">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Media Sosial</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                    <input type="url" id="facebook_url" name="settings[facebook_url][value]" 
                           value="{{ $settings->where('key', 'facebook_url')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                    <input type="url" id="instagram_url" name="settings[instagram_url][value]" 
                           value="{{ $settings->where('key', 'instagram_url')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                    <input type="url" id="linkedin_url" name="settings[linkedin_url][value]" 
                           value="{{ $settings->where('key', 'linkedin_url')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
                    <input type="url" id="twitter_url" name="settings[twitter_url][value]" 
                           value="{{ $settings->where('key', 'twitter_url')->first()->value ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
            </div>
        </div>

        <!-- Hero Text Pages -->
        <div class="bg-white rounded-lg shadow p-6 mb-2">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Teks Hero Halaman</h3>
            <p class="text-sm text-gray-600 mb-6">Atur teks yang ditampilkan di hero section halaman Blog dan Gallery</p>
            
            <!-- Blog Hero Text -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">Blog & Artikel</h4>
                <div class="space-y-4">
                    <div>
                        <label for="blog_hero_badge" class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                        <input type="text" id="blog_hero_badge" name="settings[blog_hero_badge][value]" 
                               value="{{ $settings->where('key', 'blog_hero_badge')->first()->value ?? 'Blog & Artikel' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Blog & Artikel">
                    </div>
                    <div>
                        <label for="blog_hero_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Utama</label>
                        <input type="text" id="blog_hero_title" name="settings[blog_hero_title][value]" 
                               value="{{ $settings->where('key', 'blog_hero_title')->first()->value ?? 'Inspirasi & Wawasan' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Inspirasi & Wawasan">
                    </div>
                    <div>
                        <label for="blog_hero_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" id="blog_hero_subtitle" name="settings[blog_hero_subtitle][value]" 
                               value="{{ $settings->where('key', 'blog_hero_subtitle')->first()->value ?? 'untuk Bisnis Digital' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="untuk Bisnis Digital">
                    </div>
                    <div>
                        <label for="blog_hero_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="blog_hero_description" name="settings[blog_hero_description][value]" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                  placeholder="Temukan tips, tren terkini, dan panduan lengkap seputar digital marketing, teknologi, dan strategi bisnis">{{ $settings->where('key', 'blog_hero_description')->first()->value ?? 'Temukan tips, tren terkini, dan panduan lengkap seputar digital marketing, teknologi, dan strategi bisnis' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Gallery Hero Text -->
            <div>
                <h4 class="text-md font-semibold text-gray-800 mb-4">Gallery & Portfolio</h4>
                <div class="space-y-4">
                    <div>
                        <label for="gallery_hero_badge" class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                        <input type="text" id="gallery_hero_badge" name="settings[gallery_hero_badge][value]" 
                               value="{{ $settings->where('key', 'gallery_hero_badge')->first()->value ?? 'Gallery & Portfolio' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Gallery & Portfolio">
                    </div>
                    <div>
                        <label for="gallery_hero_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Utama</label>
                        <input type="text" id="gallery_hero_title" name="settings[gallery_hero_title][value]" 
                               value="{{ $settings->where('key', 'gallery_hero_title')->first()->value ?? 'Koleksi Karya Kami' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Koleksi Karya Kami">
                    </div>
                    <div>
                        <label for="gallery_hero_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" id="gallery_hero_subtitle" name="settings[gallery_hero_subtitle][value]" 
                               value="{{ $settings->where('key', 'gallery_hero_subtitle')->first()->value ?? 'Portfolio & Gallery' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Portfolio & Gallery">
                    </div>
                    <div>
                        <label for="gallery_hero_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="gallery_hero_description" name="settings[gallery_hero_description][value]" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                  placeholder="Jelajahi karya-karya terbaik kami dan lihat bagaimana kami membantu klien mencapai kesuksesan">{{ $settings->where('key', 'gallery_hero_description')->first()->value ?? 'Jelajahi karya-karya terbaik kami dan lihat bagaimana kami membantu klien mencapai kesuksesan' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <!-- SEO Tab Content -->
        <div id="tab-content-seo" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow p-6 space-y-8">
                <!-- SEO Umum Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-200">Pengaturan SEO Umum</h3>
                    <div class="space-y-6">
                    
                    <!-- Meta Title -->
                    <div>
                        <label for="seo_meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="seo_meta_title" 
                               name="seo_settings[meta_title]" 
                               value="{{ $defaultSeo->meta_title ?? '' }}"
                               maxlength="60"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Judul halaman untuk SEO (maks 60 karakter)">
                        <p class="text-xs text-gray-500 mt-1">
                            <span id="meta_title_count">0</span>/60 karakter
                        </p>
                    </div>
                    
                    <!-- Meta Description -->
                    <div>
                        <label for="seo_meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="seo_meta_description" 
                                  name="seo_settings[meta_description]" 
                                  rows="3"
                                  maxlength="160"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                  placeholder="Deskripsi halaman untuk SEO (maks 160 karakter)">{{ $defaultSeo->meta_description ?? '' }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            <span id="meta_description_count">0</span>/160 karakter
                        </p>
                    </div>
                    
                    <!-- Meta Keywords -->
                    <div>
                        <label for="seo_meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Keywords
                        </label>
                        <input type="text" 
                               id="seo_meta_keywords" 
                               name="seo_settings[meta_keywords]" 
                               value="{{ $defaultSeo->meta_keywords ?? '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="Kata kunci dipisahkan dengan koma (contoh: perusahaan, jasa, layanan)">
                        <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma. Catatan: Google tidak lagi menggunakan meta keywords, tetapi beberapa mesin pencari lain masih menggunakannya.</p>
                    </div>
                    
                    <!-- Meta Robots -->
                    <div>
                        <label for="seo_meta_robots" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Robots
                        </label>
                        <select id="seo_meta_robots" 
                                name="seo_settings[meta_robots]" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            <option value="index,follow" {{ ($defaultSeo->meta_robots ?? 'index,follow') == 'index,follow' ? 'selected' : '' }}>Index, Follow</option>
                            <option value="index,nofollow" {{ ($defaultSeo->meta_robots ?? '') == 'index,nofollow' ? 'selected' : '' }}>Index, No Follow</option>
                            <option value="noindex,follow" {{ ($defaultSeo->meta_robots ?? '') == 'noindex,follow' ? 'selected' : '' }}>No Index, Follow</option>
                            <option value="noindex,nofollow" {{ ($defaultSeo->meta_robots ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>No Index, No Follow</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Instruksi untuk mesin pencari tentang cara mengindeks halaman ini.</p>
                    </div>
                    
                    <!-- Canonical URL -->
                    <div>
                        <label for="seo_canonical_url" class="block text-sm font-medium text-gray-700 mb-2">
                            Canonical URL
                        </label>
                        <input type="url" 
                               id="seo_canonical_url" 
                               name="seo_settings[canonical_url]" 
                               value="{{ $defaultSeo->canonical_url ?? '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                               placeholder="https://example.com/page">
                        <p class="text-xs text-gray-500 mt-1">URL kanonik untuk menghindari konten duplikat. Biarkan kosong untuk menggunakan URL halaman saat ini.</p>
                    </div>
                    </div>
                </div>
                
                <!-- Media Sosial Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-3 border-b border-gray-200">Pengaturan Media Sosial (Open Graph & Twitter Card)</h3>
                    <div class="space-y-6">
                    
                    <!-- Open Graph Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Open Graph (Facebook, LinkedIn, dll)
                        </h4>
                        
                        <div class="space-y-4">
                            <!-- OG Title -->
                            <div>
                                <label for="seo_og_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    OG Title
                                </label>
                                <input type="text" 
                                       id="seo_og_title" 
                                       name="seo_settings[og_title]" 
                                       value="{{ $defaultSeo->og_title ?? '' }}"
                                       maxlength="60"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="Judul untuk share di media sosial">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menggunakan Meta Title</p>
                            </div>
                            
                            <!-- OG Description -->
                            <div>
                                <label for="seo_og_description" class="block text-sm font-medium text-gray-700 mb-2">
                                    OG Description
                                </label>
                                <textarea id="seo_og_description" 
                                          name="seo_settings[og_description]" 
                                          rows="3"
                                          maxlength="200"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                          placeholder="Deskripsi untuk share di media sosial">{{ $defaultSeo->og_description ?? '' }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menggunakan Meta Description</p>
                            </div>
                            
                            <!-- OG Image -->
                            <div>
                                <label for="seo_og_image" class="block text-sm font-medium text-gray-700 mb-2">
                                    OG Image
                                </label>
                                @if(isset($defaultSeo) && $defaultSeo->og_image)
                                    <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                                        <img src="{{ Storage::url($defaultSeo->og_image) }}" alt="OG Image" class="h-32 w-auto rounded">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="seo_og_image_upload" 
                                       name="seo_settings[og_image_upload]" 
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       onchange="previewImage(this, 'og_image_preview')">
                                <input type="hidden" name="seo_settings[og_image]" value="{{ $defaultSeo->og_image ?? '' }}">
                                <p class="text-xs text-gray-500 mt-1">Ukuran ideal: 1200x630px (rasio 1.91:1). Format: JPG atau PNG. Max: 5MB</p>
                                <div id="og_image_preview" class="mt-3 hidden p-4 bg-gray-50 rounded-lg inline-block">
                                    <img src="" alt="Preview" class="h-32 w-auto rounded">
                                </div>
                            </div>
                            
                            <!-- OG Type -->
                            <div>
                                <label for="seo_og_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    OG Type
                                </label>
                                <select id="seo_og_type" 
                                        name="seo_settings[og_type]" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    <option value="website" {{ ($defaultSeo->og_type ?? 'website') == 'website' ? 'selected' : '' }}>Website</option>
                                    <option value="article" {{ ($defaultSeo->og_type ?? '') == 'article' ? 'selected' : '' }}>Article</option>
                                    <option value="product" {{ ($defaultSeo->og_type ?? '') == 'product' ? 'selected' : '' }}>Product</option>
                                </select>
                            </div>
                            
                            <!-- OG Site Name -->
                            <div>
                                <label for="seo_og_site_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    OG Site Name
                                </label>
                                <input type="text" 
                                       id="seo_og_site_name" 
                                       name="seo_settings[og_site_name]" 
                                       value="{{ $defaultSeo->og_site_name ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="Nama website">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menggunakan nama perusahaan dari pengaturan umum</p>
                            </div>
                            
                            <!-- OG URL -->
                            <div>
                                <label for="seo_og_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    OG URL
                                </label>
                                <input type="url" 
                                       id="seo_og_url" 
                                       name="seo_settings[og_url]" 
                                       value="{{ $defaultSeo->og_url ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="https://example.com">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menggunakan URL halaman saat ini</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Twitter Card Section -->
                    <div class="pt-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter Card
                        </h4>
                        
                        <div class="space-y-4">
                            <!-- Twitter Card Type -->
                            <div>
                                <label for="seo_twitter_card" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Card Type
                                </label>
                                <select id="seo_twitter_card" 
                                        name="seo_settings[twitter_card]" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    <option value="summary_large_image" {{ ($defaultSeo->twitter_card ?? 'summary_large_image') == 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                                    <option value="summary" {{ ($defaultSeo->twitter_card ?? '') == 'summary' ? 'selected' : '' }}>Summary</option>
                                </select>
                            </div>
                            
                            <!-- Twitter Title -->
                            <div>
                                <label for="seo_twitter_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Title
                                </label>
                                <input type="text" 
                                       id="seo_twitter_title" 
                                       name="seo_settings[twitter_title]" 
                                       value="{{ $defaultSeo->twitter_title ?? '' }}"
                                       maxlength="70"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="Judul untuk Twitter Card">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menggunakan Meta Title</p>
                            </div>
                            
                            <!-- Twitter Description -->
                            <div>
                                <label for="seo_twitter_description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Description
                                </label>
                                <textarea id="seo_twitter_description" 
                                          name="seo_settings[twitter_description]" 
                                          rows="3"
                                          maxlength="200"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                          placeholder="Deskripsi untuk Twitter Card">{{ $defaultSeo->twitter_description ?? '' }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk menggunakan Meta Description</p>
                            </div>
                            
                            <!-- Twitter Image -->
                            <div>
                                <label for="seo_twitter_image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Image
                                </label>
                                @if(isset($defaultSeo) && $defaultSeo->twitter_image)
                                    <div class="mb-3 p-4 bg-gray-50 rounded-lg inline-block">
                                        <img src="{{ Storage::url($defaultSeo->twitter_image) }}" alt="Twitter Image" class="h-32 w-auto rounded">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="seo_twitter_image_upload" 
                                       name="seo_settings[twitter_image_upload]" 
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       onchange="previewImage(this, 'twitter_image_preview')">
                                <input type="hidden" name="seo_settings[twitter_image]" value="{{ $defaultSeo->twitter_image ?? '' }}">
                                <p class="text-xs text-gray-500 mt-1">Ukuran ideal: 1200x600px untuk Summary Large Image atau 120x120px untuk Summary. Format: JPG atau PNG. Max: 5MB</p>
                                <div id="twitter_image_preview" class="mt-3 hidden p-4 bg-gray-50 rounded-lg inline-block">
                                    <img src="" alt="Preview" class="h-32 w-auto rounded">
                                </div>
                            </div>
                            
                            <!-- Twitter Site -->
                            <div>
                                <label for="seo_twitter_site" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Site (@username)
                                </label>
                                <input type="text" 
                                       id="seo_twitter_site" 
                                       name="seo_settings[twitter_site]" 
                                       value="{{ $defaultSeo->twitter_site ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="@username">
                                <p class="text-xs text-gray-500 mt-1">Username Twitter website (tanpa @)</p>
                            </div>
                            
                            <!-- Twitter Creator -->
                            <div>
                                <label for="seo_twitter_creator" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Creator (@username)
                                </label>
                                <input type="text" 
                                       id="seo_twitter_creator" 
                                       name="seo_settings[twitter_creator]" 
                                       value="{{ $defaultSeo->twitter_creator ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="@username">
                                <p class="text-xs text-gray-500 mt-1">Username Twitter penulis/kreator konten (tanpa @)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-8">
        <button type="submit" 
                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-300">
            Simpan Pengaturan
        </button>
    </div>
</form>

<script>
// Tab switching - make sure it's in global scope
window.switchTab = function(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-primary', 'text-primary');
        button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    });
    
    // Show selected tab content
    const selectedContent = document.getElementById(`tab-content-${tabName}`);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    // Activate selected tab
    const selectedTab = document.getElementById(`tab-${tabName}`);
    if (selectedTab) {
        selectedTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        selectedTab.classList.add('border-primary', 'text-primary');
    }
};

// Character counters
document.addEventListener('DOMContentLoaded', function() {
    // Meta Title counter
    const metaTitleInput = document.getElementById('seo_meta_title');
    const metaTitleCount = document.getElementById('meta_title_count');
    if (metaTitleInput && metaTitleCount) {
        metaTitleCount.textContent = metaTitleInput.value.length;
        metaTitleInput.addEventListener('input', function() {
            metaTitleCount.textContent = this.value.length;
            if (this.value.length > 60) {
                metaTitleCount.classList.add('text-red-500');
            } else {
                metaTitleCount.classList.remove('text-red-500');
            }
        });
    }
    
    // Meta Description counter
    const metaDescInput = document.getElementById('seo_meta_description');
    const metaDescCount = document.getElementById('meta_description_count');
    if (metaDescInput && metaDescCount) {
        metaDescCount.textContent = metaDescInput.value.length;
        metaDescInput.addEventListener('input', function() {
            metaDescCount.textContent = this.value.length;
            if (this.value.length > 160) {
                metaDescCount.classList.add('text-red-500');
            } else {
                metaDescCount.classList.remove('text-red-500');
            }
        });
    }
    
    // Initialize first tab as active
    // Check if we're on SEO tab (from URL hash or default)
    const urlHash = window.location.hash;
    if (urlHash === '#seo') {
        switchTab('seo');
    } else {
        // Make sure general tab is visible
        const generalTab = document.getElementById('tab-content-general');
        if (generalTab) {
            generalTab.classList.remove('hidden');
        }
        // Set active state for general tab button
        const generalTabButton = document.getElementById('tab-general');
        if (generalTabButton) {
            generalTabButton.classList.add('border-primary', 'text-primary');
            generalTabButton.classList.remove('border-transparent', 'text-gray-500');
        }
    }
});

// Sync color inputs
document.querySelectorAll('input[type="color"]').forEach(colorInput => {
    const textInput = colorInput.parentElement.querySelector('input[type="text"]');
    
    colorInput.addEventListener('change', function() {
        textInput.value = this.value;
    });
    
    textInput.addEventListener('change', function() {
        colorInput.value = this.value;
    });
});

// Image preview function (robust to missing containers)
function previewImage(input, previewId) {
    if (!input || !input.files || !input.files[0]) return;

    let preview = document.getElementById(previewId);
    if (!preview) {
        // If the preview container doesn't exist, create it right after the input
        preview = document.createElement('div');
        preview.id = previewId;
        preview.className = 'mt-3 p-2 bg-gray-50 rounded-lg';
        input.parentElement.appendChild(preview);
    }

    let previewImg = preview.querySelector('img');
    if (!previewImg) {
        previewImg = document.createElement('img');
        previewImg.alt = 'Preview';
        // Use appropriate class based on preview container
        if (previewId.includes('og_image') || previewId.includes('twitter_image')) {
            previewImg.className = 'h-32 w-auto rounded';
        } else {
            previewImg.className = 'h-16 w-auto';
        }
        preview.appendChild(previewImg);
    }

    const file = input.files[0];
    const objectUrl = URL.createObjectURL(file);
    previewImg.src = objectUrl;
    preview.classList.remove('hidden');

    // Revoke object URL after image loads to free memory
    previewImg.onload = () => URL.revokeObjectURL(objectUrl);
}
</script>
@endsection
