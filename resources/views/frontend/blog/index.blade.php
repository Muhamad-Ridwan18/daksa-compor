@extends('layouts.frontend')

@section('content')
<!-- Hero Section with Modern Gradient -->
<section class="relative min-h-[50vh] sm:min-h-[60vh] lg:min-h-[70vh] flex items-center justify-center bg-gradient-to-br from-primary via-secondary to-primary overflow-hidden">
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
        <div class="max-w-4xl mx-auto text-center text-white">
            <!-- Badge -->
            <div class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white/10 backdrop-blur-md rounded-full text-xs sm:text-sm font-semibold mb-4 sm:mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                </svg>
                {{ \App\Models\Setting::getValue('blog_hero_badge', 'Blog & Artikel') }}
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight px-2">
                {{ \App\Models\Setting::getValue('blog_hero_title', 'Inspirasi & Wawasan') }}
                <span class="block text-white/90 mt-1 sm:mt-2">{{ \App\Models\Setting::getValue('blog_hero_subtitle', 'untuk Bisnis Digital') }}</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 lg:mb-10 text-white/90 max-w-3xl mx-auto px-4">
                {{ \App\Models\Setting::getValue('blog_hero_description', 'Temukan tips, tren terkini, dan panduan lengkap seputar digital marketing, teknologi, dan strategi bisnis') }}
            </p>
            
            <!-- Search Bar with Modern Design -->
            <form action="{{ route('blog.index') }}" method="GET" class="max-w-3xl mx-auto mb-6 sm:mb-8 px-4">
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
                               placeholder="Cari artikel, topik, kata kunci..." 
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 bg-white/95 backdrop-blur-sm text-gray-900 placeholder-gray-500 text-sm sm:text-base rounded-lg focus:outline-none focus:ring-2 focus:ring-white shadow-2xl">
                    </div>
                    
                    <!-- Buttons Container -->
                    <div class="flex items-center gap-2">
                        @if(request('q'))
                            <a href="{{ route('blog.index') }}" 
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
            
            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 px-4">
                <a href="{{ route('blog.index') }}" 
                   class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold {{ !request('sort') ? 'bg-white text-primary shadow-lg' : 'bg-white/10 text-white hover:bg-white/20' }}">
                    <span class="flex items-center gap-1.5 sm:gap-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Terbaru
                    </span>
                </a>
                <a href="{{ route('blog.index', ['sort' => 'popular'] + request()->except(['page', 'sort'])) }}" 
                   class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold {{ request('sort') === 'popular' ? 'bg-white text-primary shadow-lg' : 'bg-white/10 text-white hover:bg-white/20' }}">
                    <span class="flex items-center gap-1.5 sm:gap-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Terpopuler
                    </span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    {{-- <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div> --}}
</section>

<!-- Articles Section -->
<section class="py-8 sm:py-12 lg:py-16 xl:py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if($articles->count() > 0)
            <!-- Active Filter Notice -->
            @if(request('q') || request('sort'))
                <div class="max-w-6xl mx-auto mb-6 sm:mb-8 lg:mb-10 bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Filter Aktif</p>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    @if(request('q'))
                                        <span class="inline-flex items-center px-3 py-1 bg-primary/10 text-primary rounded-lg text-sm font-semibold">
                                            "{{ request('q') }}"
                                        </span>
                                    @endif
                                    @if(request('sort'))
                                        <span class="inline-flex items-center px-3 py-1 bg-secondary/10 text-secondary rounded-lg text-sm font-semibold">
                                            {{ request('sort') === 'popular' ? 'Terpopuler' : 'Terbaru' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs sm:text-sm font-semibold transition w-full sm:w-auto">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reset Semua Filter
                        </a>
                    </div>
                </div>
            @endif

            <!-- Articles Grid with Modern Cards -->
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                    @foreach($articles as $article)
                        <article class="group bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                            <!-- Image Container -->
                            <div class="relative overflow-hidden aspect-[16/10]">
                                <!-- Badges -->
                                <div class="absolute top-2 sm:top-4 left-2 sm:left-4 z-10 flex flex-col gap-1.5 sm:gap-2">
                                    @if($article->published_at && $article->published_at->gt(now()->subDays(7)))
                                        <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-[10px] sm:text-xs font-bold bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg">
                                            <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 mr-0.5 sm:mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            Baru
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Views Badge -->
                                <div class="absolute top-2 sm:top-4 right-2 sm:right-4 z-10">
                                    <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-[10px] sm:text-xs font-semibold bg-black/60 backdrop-blur-md text-white">
                                        <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 mr-1 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ number_format($article->views) }}
                                    </span>
                                </div>
                                
                                <!-- Featured Image -->
                                <a href="{{ route('blog.show', $article->slug) }}" class="block h-full">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                             alt="{{ $article->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary via-secondary to-primary flex items-center justify-center">
                                            <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4 sm:p-5 lg:p-6 xl:p-7">
                                <!-- Meta Info -->
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 lg:gap-4 text-xs sm:text-sm text-gray-500 mb-3 sm:mb-4">
                                    <div class="flex items-center gap-1 sm:gap-1.5">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $article->published_at->format('d M Y') }}</span>
                                    </div>
                                    <span class="text-gray-300 hidden sm:inline">•</span>
                                    <div class="flex items-center gap-1 sm:gap-1.5">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $article->read_time ?? '5' }} min</span>
                                    </div>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 min-h-[3rem] sm:min-h-[3.5rem]">
                                    <a href="{{ route('blog.show', $article->slug) }}" class="hover:text-primary transition-colors">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                
                                <!-- Excerpt -->
                                <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-5 line-clamp-3 leading-relaxed">
                                    {{ $article->excerpt }}
                                </p>
                                
                                <!-- Divider -->
                                <div class="border-t border-gray-100 pt-3 sm:pt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                    <!-- Author (if available) -->
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white text-[10px] sm:text-xs font-bold">{{ substr($article->author->name ?? 'A', 0, 1) }}</span>
                                        </div>
                                        <span class="text-xs sm:text-sm font-medium text-gray-700 truncate">{{ $article->author->name ?? 'Admin' }}</span>
                                    </div>
                                    
                                    <!-- Read More Link -->
                                    <a href="{{ route('blog.show', $article->slug) }}" 
                                       class="inline-flex items-center gap-1.5 sm:gap-2 text-primary font-semibold text-sm sm:text-base hover:underline">
                                        Baca
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-8 sm:mt-10 lg:mt-12">
                        {{ $articles->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto text-center py-12 sm:py-16 lg:py-20 px-4">
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-gray-100 p-6 sm:p-8 lg:p-12">
                    <!-- Icon -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-3 sm:mb-4">
                        @if(request('q'))
                            Tidak Ada Hasil Ditemukan
                        @else
                            Belum Ada Artikel
                        @endif
                    </h3>
                    
                    <p class="text-gray-600 mb-6 sm:mb-8 text-base sm:text-lg px-2">
                        @if(request('q'))
                            Maaf, pencarian untuk "<span class="font-semibold text-primary">{{ request('q') }}</span>" tidak menemukan hasil. Coba kata kunci lain.
                        @else
                            Artikel akan segera hadir. Nantikan konten menarik dari kami!
                        @endif
                    </p>
                    
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center gap-2 bg-primary hover:bg-opacity-90 text-white font-semibold px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg transition shadow-lg hover:shadow-xl text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda Blog
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-12 sm:py-16 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pattern-dots"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6 text-black px-2">
                Kami siap bantu segala kebutuhan perpajakan dan akuntansi perusahaan anda
            </h2>
            <p class="text-base sm:text-lg lg:text-xl mb-6 sm:mb-8 text-black/90 px-4">
                Hubungi kami untuk konsultasi gratis
            </p>
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
                $waText = 'Halo, saya tertarik dengan layanan dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut.';
                $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . '?text=' . urlencode($waText)) : '#';
            @endphp
            <a href="{{ $waUrl }}" 
               class="inline-flex items-center gap-2 bg-primary text-white hover:bg-opacity-90 font-bold px-6 sm:px-8 py-3 sm:py-4 rounded-lg transition shadow-2xl hover:shadow-3xl text-base sm:text-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Hubungi Kami Sekarang
            </a>
        </div>
    </div>
</section>

@endsection
