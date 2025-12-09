@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden">
    <div class="text-center mb-16 bg-primary min-h-[180px] flex items-center justify-center w-full" style="min-height:180px;" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-bold text-white w-full">Layanan Kami</h1>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pb-12">

        <!-- Service Header -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            @if($service->image)
            <div class="order-2 lg:order-1">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl transform hover:scale-[1.02] transition-transform duration-300">
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="w-full h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            </div>
            @endif
            
            <div class="order-1 lg:order-2">
                <div class="inline-block px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-4">
                    Layanan Profesional
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">{{ $service->name }}</h1>
                <p class="text-xl text-gray-600 leading-relaxed mb-6">{{ $service->description }}</p>
                
                @if($service->products->count() > 0)
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-lg font-semibold text-gray-900">{{ $service->products->count() }} Paket Tersedia</span>
                    </div>
                </div>
                @endif

                <!-- CTA WhatsApp -->
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
                    $waText = 'Halo, saya tertarik dengan layanan *' . $service->name . '* dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut mengenai paket yang tersedia.';
                    $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . '?text=' . urlencode($waText)) : '#';
                @endphp
                @if($waNumber)
                <a href="{{ $waUrl }}" 
                   target="_blank" 
                   rel="noopener"
                   class="inline-flex items-center gap-2 px-5 py-2.5 text-white rounded-lg font-semibold text-base transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 group"
                   style="background-color: {{ $settings['primary_color'] ?? '#2563eb' }};"
                   onmouseover="this.style.backgroundColor='{{ $settings['primary_hover_color'] ?? '#1d4ed8' }}'"
                   onmouseout="this.style.backgroundColor='{{ $settings['primary_color'] ?? '#2563eb' }}'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
@if($service->products->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold mb-4">
                Paket Layanan
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Pilih Paket yang Tepat untuk Anda</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai paket yang dapat disesuaikan dengan kebutuhan bisnis Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($service->products as $productIndex => $product)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary/20 transform hover:-translate-y-2 flex flex-col h-full">
                <!-- Product Header -->
                <div class="p-6 bg-gradient-to-br from-primary/5 to-primary/10 border-b border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                    <div class="pricing-card-price" style="{{ !($product->show_price ?? true) ? 'display: none;' : '' }}">
                        <span class="price-amount text-4xl font-bold text-primary">{{ $product->formatted_price }}</span>
                    </div>
                </div>
                
                <!-- Product Body -->
                <div class="p-6 flex-1 flex flex-col">
                    @if($product->description)
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $product->description }}</p>
                    @endif
                    
                    <div class="pricing-features space-y-4 flex-1">
                        @php 
                            $features = $product->features ?? [];
                            if (!empty($features) && is_string($features[0] ?? null)) {
                                $convertedFeatures = [];
                                foreach ($features as $feature) {
                                    $convertedFeatures[] = ['name' => $feature, 'description' => ''];
                                }
                                $features = $convertedFeatures;
                            }
                        @endphp
                        @forelse($features as $index => $feature)
                        @php
                            $featureName = is_array($feature) ? ($feature['name'] ?? '') : $feature;
                            $featureDesc = is_array($feature) ? ($feature['description'] ?? '') : '';
                            $featureId = 'feature-' . $service->id . '-' . $productIndex . '-' . $index;
                            $hasDescription = !empty($featureDesc);
                            $descLength = strlen($featureDesc);
                            $maxLength = 100;
                            $isLong = $descLength > $maxLength;
                        @endphp
                        <div class="feature-item flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-gray-900">{{ $featureName }}</span>
                                @if($hasDescription)
                                    <div class="mt-1">
                                        @if($isLong)
                                            <p id="{{ $featureId }}-short" class="text-sm text-gray-600">
                                                {{ Str::limit($featureDesc, $maxLength) }}
                                                <button type="button" 
                                                        onclick="toggleFeatureDesc('{{ $featureId }}')" 
                                                        class="text-primary hover:underline ml-1 font-medium"
                                                        aria-label="Baca selengkapnya tentang {{ $featureName ?? 'fitur' }}">
                                                    Baca selengkapnya
                                                </button>
                                            </p>
                                            <p id="{{ $featureId }}-full" class="text-sm text-gray-600 hidden">
                                                {{ $featureDesc }}
                                                <button type="button" 
                                                        onclick="toggleFeatureDesc('{{ $featureId }}')" 
                                                        class="text-primary hover:underline ml-1 font-medium"
                                                        aria-label="Tampilkan lebih sedikit tentang {{ $featureName ?? 'fitur' }}">
                                                    Tampilkan lebih sedikit
                                                </button>
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-600">{{ $featureDesc }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="feature-item flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="2" />
                            </svg>
                            <span class="text-gray-500">Fitur belum ditambahkan</span>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Product Footer -->
                <div class="p-6 pt-0 mt-auto">
                    @php
                        $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
                        $waText = 'Halo, saya tertarik dengan paket *' . $product->name . '* dari layanan *' . $service->name . '* di ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut mengenai paket ini.';
                        $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . '?text=' . urlencode($waText)) : '#';
                    @endphp
                    <div class="flex flex-row gap-3 w-full">
                        @if($waNumber)
                        <a href="{{ $waUrl }}" 
                           target="_blank" 
                           rel="noopener"
                           class="flex-1 flex items-center justify-center py-4 px-6 bg-primary text-white rounded-xl font-bold text-lg hover:bg-primary/90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                           style="background-color: #25D366;"
                           onmouseover="this.style.backgroundColor='#20BA5A'"
                           onmouseout="this.style.backgroundColor='#25D366'"
                           title="Pilih Paket Ini via WhatsApp"
                           aria-label="Pilih Paket Ini via WhatsApp">
                            pilih paket ini
                        </a>
                        @else
                        <button disabled
                                class="flex-1 py-4 px-6 bg-gray-300 text-white rounded-xl font-bold text-lg transition-all duration-300 cursor-not-allowed opacity-60">
                            pilih paket ini
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<!-- Empty State -->
<section class="py-20 bg-gray-50">
    <div class="max-w-2xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Paket Sedang Disiapkan</h3>
        <p class="text-lg text-gray-600 mb-8">Paket untuk layanan ini sedang dalam persiapan. Silakan hubungi kami untuk informasi lebih lanjut.</p>
        @php
            $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
            $waText = 'Halo, saya tertarik dengan layanan *' . $service->name . '* dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut.';
            $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . '?text=' . urlencode($waText)) : '#';
        @endphp
        @if($waNumber)
        <a href="{{ $waUrl }}" 
           target="_blank" 
           rel="noopener"
           class="inline-flex items-center gap-3 px-8 py-4 text-white rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl"
           style="background-color: #25D366;"
           onmouseover="this.style.backgroundColor='#20BA5A'"
           onmouseout="this.style.backgroundColor='#25D366'">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span>Hubungi Kami via WhatsApp</span>
        </a>
        @endif
    </div>
</section>
@endif

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
                    $waText = 'Halo, saya tertarik dengan layanan *' . $service->name . '* dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut mengenai paket yang tersedia.';
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
            
            {{-- <!-- Additional Info -->
            <div class="mt-12 flex flex-wrap justify-center gap-8 text-white/80" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Respon Cepat</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Konsultasi Gratis</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Harga Terjangkau</span>
                </div>
            </div> --}}
        </div>
    </div>
</section>

<!-- Location Section -->
@if(($settings['gmaps_embed_url'] ?? null) || (($settings['gmaps_latitude'] ?? null) && ($settings['gmaps_longitude'] ?? null)) || ($settings['company_address'] ?? null))
<section class="py-20 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-aos="fade-up">
            <div class="section-eyebrow">Lokasi</div>
            <h2 class="section-title" style="color: {{ $settings['primary_color'] ?? '#D89B30' }};">Lokasi Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                Kunjungi kantor kami atau hubungi kami untuk konsultasi.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Address Info -->
            <div data-aos="fade-up" data-aos-delay="0">
                @if($settings['company_address'] ?? null)
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-start gap-4">
                        <div class="bg-primary/10 p-3 rounded-lg flex-shrink-0">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2">Alamat</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $settings['company_address'] }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Map -->
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="rounded-xl overflow-hidden border border-gray-200 shadow-lg h-[400px]">
                    @php
                        $lat = $settings['gmaps_latitude'] ?? null;
                        $lng = $settings['gmaps_longitude'] ?? null;
                        $zoom = $settings['gmaps_zoom'] ?? 15;
                        $src = $settings['gmaps_embed_url'] ?? null;
                        if (!$src && $lat && $lng) {
                            $src = 'https://www.google.com/maps?q=' . $lat . ',' . $lng . '&z=' . $zoom . '&output=embed';
                        }
                    @endphp
                    @if($src)
                        <iframe 
                            src="{{ $src }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi {{ $settings['company_name'] ?? 'Kantor Kami' }}">
                        </iframe>
                    @elseif($settings['company_address'] ?? null)
                        @php
                            $address = urlencode($settings['company_address']);
                            $mapSrc = 'https://www.google.com/maps?q=' . $address . '&output=embed';
                        @endphp
                        <iframe 
                            src="{{ $mapSrc }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi {{ $settings['company_name'] ?? 'Kantor Kami' }}">
                        </iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Contact & Location Section -->
<section class="py-20 bg-secondary text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="contact-bg-shape shape-1"></div>
        <div class="contact-bg-shape shape-2"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-aos="fade-up">
            <div class="section-eyebrow">Kontak</div>
            <h2 class="section-title" style="color: white;">Hubungi Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl max-w-3xl mx-auto mt-4">
                Siap membantu mewujudkan impian bisnis Anda. Hubungi kami sekarang!
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div data-aos="fade-up" data-aos-delay="0">
                <h2 class="text-2xl font-semibold mb-6">Informasi Kontak</h2>
                <div class="space-y-4">
                    @if($settings['company_email'] ?? null)
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <a href="mailto:{{ $settings['company_email'] }}" class="hover:text-primary transition-colors">
                            {{ $settings['company_email'] }}
                        </a>
                    </div>
                    @endif
                    
                    @if($settings['company_phone'] ?? null)
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['company_phone']) }}" class="hover:text-primary transition-colors">
                            {{ $settings['company_phone'] }}
                        </a>
                    </div>
                    @endif
                    
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="100">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Nama</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-3 text-gray-900 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 text-gray-900 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 text-gray-900 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 text-sm bg-primary text-white font-semibold rounded-lg hover:bg-opacity-90 shadow flex-1 transition-colors">
                            Kirim Pesan
                        </button>
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
                            $waText = trim($settings['whatsapp_template'] ?? '');
                            $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . ($waText !== '' ? ('?text=' . urlencode($waText)) : '')) : '#';
                        @endphp
                        @if($waNumber)
                        <a href="{{ $waUrl }}"
                            class="px-4 py-2 text-sm bg-green-500 text-white font-semibold hover:bg-green-600 rounded-lg shadow flex-1 flex items-center justify-center transition-colors"
                            target="_blank" rel="noopener"
                            style="background-color: #25D366;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Pesan Layanan</h3>
                <button onclick="closeOrderModal()" 
                        class="text-gray-400 hover:text-gray-600 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors"
                        aria-label="Tutup modal pesan layanan"
                        type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        
            <form id="orderForm" action="{{ route('order.store') }}" method="POST">
                @csrf
                <input type="hidden" id="serviceId" name="service_id">
                <input type="hidden" id="productId" name="product_id">
                
                <div id="selectedProduct" class="mb-6 p-4 bg-primary/5 rounded-xl border border-primary/20">
                    <p class="text-sm text-gray-600 mb-1">Paket yang dipilih:</p>
                    <p id="productName" class="font-bold text-primary"></p>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label for="orderName" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="orderName" name="name" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    </div>
                    <div>
                        <label for="orderEmail" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" id="orderEmail" name="email" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    </div>
                    <div>
                        <label for="orderPhone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                        <input type="tel" id="orderPhone" name="phone" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    </div>
                    <div>
                        <label for="orderMessage" class="block text-sm font-semibold text-gray-700 mb-2">Pesan (opsional)</label>
                        <textarea id="orderMessage" name="message" rows="3" 
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all"></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 bg-primary text-white py-3 px-6 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl">
                            Kirim Pesan
                        </button>
                        <button type="button" onclick="closeOrderModal()" 
                                class="px-6 py-3 border-2 border-gray-300 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Order Modal Functions
function openOrderModal(serviceId, productId = null, productName = '') {
    document.getElementById('serviceId').value = serviceId;
    if (productId) {
        document.getElementById('productId').value = productId;
        document.getElementById('productName').textContent = productName || 'Paket Terpilih';
        document.getElementById('selectedProduct').classList.remove('hidden');
    } else {
        document.getElementById('selectedProduct').classList.add('hidden');
    }
    document.getElementById('orderModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeOrderModal() {
    document.getElementById('orderModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('orderModal').addEventListener('click', function(e) {
    if (e.target === this) closeOrderModal();
});

// Toggle feature description
function toggleFeatureDesc(featureId) {
    const short = document.getElementById(featureId + '-short');
    const full = document.getElementById(featureId + '-full');
    if (short && full) {
        short.classList.toggle('hidden');
        full.classList.toggle('hidden');
    }
}
</script>
@endsection
