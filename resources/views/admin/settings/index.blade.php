@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    
    <div class="space-y-8">
        <!-- Site Information -->
        <div class="bg-white rounded-lg shadow p-6">
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
        <div class="bg-white rounded-lg shadow p-6">
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
        <div class="bg-white rounded-lg shadow p-6">
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
        <div class="bg-white rounded-lg shadow p-6">
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
        <div class="bg-white rounded-lg shadow p-6">
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

        <!-- About Section -->
        <div class="bg-white rounded-lg shadow p-6">
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
        <div class="bg-white rounded-lg shadow p-6">
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

        <!-- Social Media -->
        <div class="bg-white rounded-lg shadow p-6">
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
    </div>

    <div class="flex justify-end mt-8">
        <button type="submit" 
                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-300">
            Simpan Pengaturan
        </button>
    </div>
</form>

<script>
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
        previewImg.className = 'h-16 w-auto';
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
