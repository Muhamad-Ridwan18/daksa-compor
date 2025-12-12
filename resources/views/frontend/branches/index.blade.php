@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
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
                Cabang
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight px-2">
                Cabang Kami
            </h1>
            
            <!-- Subtitle -->
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 text-white/90 max-w-3xl mx-auto px-4">
                Temukan lokasi cabang kami di berbagai kota dan hubungi cabang terdekat untuk konsultasi dan layanan
            </p>
            
        </div>
    </div>
</section>

<!-- Branches Section -->
<section class="py-12 lg:py-20 bg-gradient-to-b from-white via-gray-50/50 to-white relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            @if($branches->count() > 0)

                <!-- Branches Grid - Always Centered -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8 justify-items-center">
                    @foreach($branches as $index => $branch)
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden w-full max-w-md"
                             data-aos="fade-up" 
                             data-aos-delay="{{ $index * 100 }}">
                            
                            <!-- Branch Header - Compact Maps -->
                            @if($branch->map_url || ($branch->latitude && $branch->longitude))
                            <div class="h-[500px] lg:h-[600px] overflow-hidden">
                                @php
                                    $lat = $branch->latitude;
                                    $lng = $branch->longitude;
                                    $zoom = 15;
                                    $mapUrl = $branch->map_url;
                                    $src = null;
                                    
                                    // Priority 1: Use latitude/longitude if available (most reliable for embed)
                                    if ($lat && $lng) {
                                        $src = 'https://www.google.com/maps?q=' . $lat . ',' . $lng . '&z=' . $zoom . '&output=embed';
                                    }
                                    // Priority 2: Use map_url if it's already in embed format
                                    elseif ($mapUrl) {
                                        // Check if it's a Google Maps short URL (maps.app.goo.gl) - these can't be embedded directly
                                        if (strpos($mapUrl, 'maps.app.goo.gl') !== false || strpos($mapUrl, 'goo.gl/maps') !== false) {
                                            $src = null;
                                        }
                                        // Check if it's already an embed URL
                                        elseif (strpos($mapUrl, '/embed') !== false || strpos($mapUrl, 'output=embed') !== false) {
                                            $src = $mapUrl;
                                        }
                                        // Check if it's a regular Google Maps URL - try to convert to embed
                                        elseif (strpos($mapUrl, 'google.com/maps') !== false) {
                                            $separator = strpos($mapUrl, '?') !== false ? '&' : '?';
                                            $src = $mapUrl . $separator . 'output=embed';
                                        }
                                        else {
                                            $src = $mapUrl;
                                        }
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
                                        title="Lokasi {{ $branch->name }}">
                                    </iframe>
                                    <!-- Overlay with Branch Name -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                        <div class="p-4 text-white w-full">
                                            <h3 class="text-xl font-bold mb-1">{{ $branch->name }}</h3>
                                            <p class="text-sm text-white/90">{{ $branch->city }}, {{ $branch->province }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-secondary">
                                        <div class="text-center text-white">
                                            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <p class="text-lg font-semibold mb-1">{{ $branch->name }}</p>
                                            <p class="text-sm text-white/80">{{ $branch->city }}, {{ $branch->province }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @else
                            <!-- Fallback Header if no map -->
                            <div class="bg-gradient-to-r from-primary to-secondary p-6 text-white h-[200px] flex items-center justify-center">
                                <div class="text-center">
                                    <h3 class="text-xl font-bold mb-2">{{ $branch->name }}</h3>
                                    <p class="text-white/90 text-sm">{{ $branch->city }}, {{ $branch->province }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Branch Content -->
                            <div class="p-5">
                                <!-- Branch Name and Location -->
                                <div class="mb-5">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $branch->name ?? '-' }}</h3>
                                    <p class="text-gray-600 text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $branch->city ?? '-' }}, {{ $branch->province ?? '-' }}
                                    </p>
                                </div>
    
                                <!-- Address - Compact -->
                                <div class="mb-4 pb-4 border-b border-gray-100">
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $branch->address ?? '-' }}</p>
                                    <p class="text-gray-500 text-xs mt-1">Kode Pos: {{ $branch->postal_code ?? '-' }}</p>
                                </div>
                                
                                <!-- Contact Information - Compact -->
                                <div class="space-y-3 mb-5">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-primary/10 p-2 rounded-lg flex-shrink-0">
                                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                        </div>
                                        @if($branch->phone)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $branch->phone) }}" 
                                           class="text-sm text-gray-700 hover:text-primary transition-colors">
                                            {{ $branch->phone }}
                                        </a>
                                        @else
                                        <span class="text-sm text-gray-700">-</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <div class="bg-primary/10 p-2 rounded-lg flex-shrink-0">
                                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                            </svg>
                                        </div>
                                        @if($branch->email)
                                        <a href="mailto:{{ $branch->email }}" 
                                           class="text-sm text-gray-700 hover:text-primary transition-colors truncate">
                                            {{ $branch->email }}
                                        </a>
                                        @else
                                        <span class="text-sm text-gray-700">-</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <div class="bg-green-100 p-2 rounded-lg flex-shrink-0">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                            </svg>
                                        </div>
                                        @php
                                            $waNumber = preg_replace('/[^0-9]/', '', $branch->whatsapp_number ?? '');
                                            $displayWa = $branch->whatsapp_number ?? '-';
                                            $waUrl = $waNumber ? 'https://wa.me/' . $waNumber : null;
                                        @endphp
                                        @if($waUrl)
                                        <a href="{{ $waUrl }}" 
                                           target="_blank" 
                                           rel="noopener"
                                           class="text-sm text-gray-700 hover:text-green-600 transition-colors">
                                            {{ $displayWa }}
                                        </a>
                                        @else
                                        <span class="text-sm text-gray-700">-</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Action Buttons - Compact -->
                                <div class="flex gap-2">
                                    @php
                                        $waNumber = preg_replace('/[^0-9]/', '', $branch->whatsapp_number ?? '');
                                        $waUrl = $waNumber ? 'https://wa.me/' . $waNumber : null;
                                    @endphp
                                    @if($waUrl)
                                    <a href="{{ $waUrl }}" 
                                       target="_blank" 
                                       rel="noopener"
                                       class="flex-1 px-3 py-2.5 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600 shadow-md transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2"
                                       style="background-color: #25D366;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        Chat
                                    </a>
                                    @else
                                    <button 
                                        class="flex-1 px-3 py-2.5 bg-green-500 text-white text-sm font-semibold rounded-lg opacity-50 cursor-not-allowed flex items-center justify-center gap-2"
                                        style="background-color: #25D366;" disabled>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        Chat
                                    </button>
                                    @endif
                                    
                                    @if($branch->map_url || ($branch->latitude && $branch->longitude))
                                    <a href="{{ $branch->map_url ?: ('https://www.google.com/maps?q=' . ($branch->latitude ?? '-') . ',' . ($branch->longitude ?? '-')) }}" 
                                       target="_blank" 
                                       rel="noopener"
                                       class="flex-1 px-3 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-opacity-90 shadow-md transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Directions
                                    </a>
                                    @else
                                    <button 
                                        class="flex-1 px-3 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg opacity-50 cursor-not-allowed flex items-center justify-center gap-2"
                                        disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Directions
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            @else
                <!-- Empty State -->
                <div class="text-center py-20" data-aos="fade-up" data-aos-delay="100">
                    <div class="inline-block p-6 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-3xl mb-6">
                        <svg class="w-24 h-24 mx-auto text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Cabang</h3>
                    <p class="text-gray-600 mb-6">Belum ada data cabang yang ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>
</section>

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
                    $waText = 'Halo, saya tertarik dengan layanan dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut mengenai cabang terdekat.';
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
@endsection

