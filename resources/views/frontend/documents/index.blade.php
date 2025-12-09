@extends('layouts.frontend')

@section('content')
<!-- Hero Section with Modern Gradient -->
<section class="relative min-h-[30vh] sm:min-h-[40vh] lg:min-h-[40vh] flex items-center justify-center bg-gradient-to-br from-primary via-secondary to-primary overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 pattern-dots"></div>
    </div>
    
    <!-- Floating Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none bg-primary">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-8 sm:py-12 lg:py-16">
        <div class="max-w-3xl mx-auto text-center text-white">
            <!-- Badge -->
            <div class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white/10 backdrop-blur-md rounded-full text-xs sm:text-sm font-semibold mb-4 sm:mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                </svg>
                Dokumen & Peraturan
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl font-bold mb-4 sm:mb-6 leading-tight px-2 max-w-2xl mx-auto">
                Dokumen & Peraturan
                <span class="block text-white/90 mt-1 sm:mt-2">Terbaru</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 lg:mb-10 text-white/90 max-w-3xl mx-auto px-4">
                Akses dokumen dan peraturan terbaru dari berbagai instansi pemerintah
            </p>
            
            <!-- Search Bar with Modern Design -->
            <form action="{{ route('documents.index') }}" method="GET" class="max-w-3xl mx-auto mb-6 sm:mb-8 px-4">
                <div class="relative flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                    <!-- Search Input Container -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="Cari dokumen, nomor peraturan..." 
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 bg-white/95 backdrop-blur-sm text-gray-900 placeholder-gray-500 text-sm sm:text-base rounded-lg focus:outline-none focus:ring-2 focus:ring-white shadow-2xl">
                    </div>
                    
                    <!-- Buttons Container -->
                    <div class="flex items-center gap-2">
                        @if(request('q'))
                            <a href="{{ route('documents.index') }}" 
                               class="text-gray-700 hover:text-gray-900 text-xs sm:text-sm px-3 sm:px-4 py-3 sm:py-4 bg-white/95 hover:bg-white rounded-lg shadow-xl font-semibold whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                        <button type="submit" 
                                class="bg-white text-primary font-bold px-6 sm:px-8 py-3 sm:py-4 rounded-lg hover:bg-gray-50 shadow-xl whitespace-nowrap border-2 border-white/20 text-sm sm:text-base">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Documents Section -->
<section class="py-8 sm:py-12 lg:py-16 xl:py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if($documents->count() > 0)
            <!-- Documents List -->
            <div class="max-w-6xl mx-auto">
                <div class="space-y-4 sm:space-y-6">
                    @foreach($documents as $document)
                        <article class="group bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300">
                            <div class="p-4 sm:p-6 lg:p-8">
                                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                                    <!-- Content -->
                                    <div class="flex-1">
                                        <!-- Title with NEW badge -->
                                        <div class="flex items-start gap-3 mb-3">
                                            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 flex-1">
                                                <a href="{{ route('documents.show', $document->slug) }}" class="hover:text-primary transition-colors">
                                                    {{ $document->title }}
                                                </a>
                                            </h3>
                                            @if($document->shouldShowAsNew())
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-[10px] sm:text-xs font-bold bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg whitespace-nowrap">
                                                    NEW
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-sm sm:text-base text-gray-600 mb-4 line-clamp-2">
                                            {{ $document->description }}
                                        </p>
                                        
                                        <!-- Meta Info -->
                                        <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-500">
                                            <!-- Date -->
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ $document->published_date->format('d M Y') }}</span>
                                            </div>
                                            
                                            <!-- Categories -->
                                            @if($document->categories && count($document->categories) > 0)
                                                <span class="text-gray-300 hidden sm:inline">•</span>
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                                    </svg>
                                                    <span>{{ implode(', ', $document->categories) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Share Button -->
                                    <div class="flex items-center gap-2 sm:flex-shrink-0">
                                        <a href="{{ route('documents.show', $document->slug) }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-opacity-90 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl text-sm sm:text-base">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($documents->hasPages())
                    <div class="mt-8 sm:mt-10 lg:mt-12">
                        {{ $documents->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto text-center py-12 sm:py-16 lg:py-20 px-4">
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-gray-100 p-6 sm:p-8 lg:p-12">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-3 sm:mb-4">
                        Belum Ada Dokumen
                    </h3>
                    <p class="text-gray-600 mb-6 sm:mb-8 text-base sm:text-lg px-2">
                        Dokumen akan segera hadir. Nantikan update terbaru dari kami!
                    </p>
                </div>
            </div>
        @endif
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
                    $waText = 'Halo, saya tertarik dengan *Dokumen & Peraturan* dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut.';
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

