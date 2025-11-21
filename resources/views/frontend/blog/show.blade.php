@extends('layouts.frontend')

@section('content')
<!-- Article Header with Modern Gradient -->
<section class="relative bg-primary py-12 sm:py-16 lg:py-20 xl:py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 pattern-dots"></div>
    </div>
    
    <!-- Floating Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <div class="mb-4 sm:mb-6 lg:mb-8">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center gap-1.5 sm:gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 rounded-lg transition group border border-white/20 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-semibold">Kembali ke Blog</span>
                </a>
            </div>
            
            <!-- Article Meta -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                @if($article->published_at && $article->published_at->gt(now()->subDays(7)))
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg text-[10px] sm:text-xs font-bold bg-white text-black shadow-lg">
                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 mr-0.5 sm:mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Artikel Baru
                    </span>
                @endif
                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg text-[10px] sm:text-xs font-semibold bg-white/20 backdrop-blur-md text-white">
                    Blog
                </span>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 sm:mb-8 leading-tight px-2 sm:px-0">
                {{ $article->title }}
            </h1>
            
            <!-- Article Info -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 lg:gap-4 xl:gap-6">
                <!-- Author -->
                <div class="flex items-center gap-2 sm:gap-3 bg-white/10 backdrop-blur-md px-3 sm:px-4 py-2 sm:py-3 rounded-lg border border-white/20 flex-1 sm:flex-none min-w-[140px] sm:min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white backdrop-blur-md rounded-full flex items-center justify-center ring-2 ring-primary flex-shrink-0">
                        <span class="text-primary font-bold text-sm sm:text-lg">{{ substr($article->author->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-xs text-white/70 font-medium">Penulis</p>
                        <p class="font-bold text-white text-xs sm:text-sm truncate">{{ $article->author->name ?? 'Admin' }}</p>
                    </div>
                </div>
                
                <!-- Date -->
                <div class="flex items-center gap-1.5 sm:gap-2 bg-white/10 backdrop-blur-md px-3 sm:px-4 py-2 sm:py-3 rounded-lg border border-white/20 flex-1 sm:flex-none min-w-[140px] sm:min-w-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-xs text-white/70 font-medium">Dipublikasi</p>
                        <p class="font-bold text-white text-xs sm:text-sm">{{ $article->published_at->format('d M Y') }}</p>
                    </div>
                </div>
                
                <!-- Views -->
                <div class="flex items-center gap-1.5 sm:gap-2 bg-white/10 backdrop-blur-md px-3 sm:px-4 py-2 sm:py-3 rounded-lg border border-white/20 flex-1 sm:flex-none min-w-[140px] sm:min-w-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-xs text-white/70 font-medium">Dilihat</p>
                        <p class="font-bold text-white text-xs sm:text-sm">{{ number_format($article->views) }}x</p>
                    </div>
                </div>
                
                <!-- Reading Time -->
                <div class="flex items-center gap-1.5 sm:gap-2 bg-white/10 backdrop-blur-md px-3 sm:px-4 py-2 sm:py-3 rounded-lg border border-white/20 flex-1 sm:flex-none min-w-[140px] sm:min-w-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="min-w-0">
                        <p class="text-[10px] sm:text-xs text-white/70 font-medium">Waktu Baca</p>
                        <p class="font-bold text-white text-xs sm:text-sm" id="reading-time">Menghitung...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-8 sm:py-12 lg:py-16 xl:py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-8 order-2 lg:order-1 min-w-0">
                    <!-- Featured Image -->
                    @if($article->featured_image)
                        <div class="mb-6 sm:mb-8 lg:mb-10 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="{{ $article->title }}"
                                 class="w-full h-auto">
                        </div>
                    @endif
                    
                    <!-- Article Body -->
                    <div id="article-content" class="prose prose-sm sm:prose-base lg:prose-lg max-w-none break-words">
                        {!! $article->content !!}
                    </div>
                    
                    <!-- Share Section -->
                    <div class="mt-8 sm:mt-10 lg:mt-12 p-4 sm:p-6 lg:p-8 bg-primary via-secondary/5 to-primary/5 rounded-lg border-2 border-primary/10">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-6">
                            <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto justify-center sm:justify-start">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-white">Bagikan Artikel</h3>
                                    <p class="text-xs sm:text-sm text-white">Bantu sebarkan informasi ini</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 justify-center sm:justify-end w-full sm:w-auto">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $article->slug)) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 sm:gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 rounded-lg font-semibold transition shadow-lg hover:shadow-xl text-xs sm:text-sm flex-1 sm:flex-none justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $article->slug)) }}&text={{ urlencode($article->title) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 sm:gap-2 bg-sky-500 hover:bg-sky-600 text-white px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 rounded-lg font-semibold transition shadow-lg hover:shadow-xl text-xs sm:text-sm flex-1 sm:flex-none justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Twitter</span>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . route('blog.show', $article->slug)) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 sm:gap-2 bg-green-600 hover:bg-green-700 text-white px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 rounded-lg font-semibold transition shadow-lg hover:shadow-xl text-xs sm:text-sm flex-1 sm:flex-none justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">WhatsApp</span>
                                </a>
                                <button type="button" 
                                        id="copy-link" 
                                        class="inline-flex items-center gap-1.5 sm:gap-2 bg-gray-700 hover:bg-gray-800 text-white px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 rounded-lg font-semibold transition shadow-lg hover:shadow-xl text-xs sm:text-sm flex-1 sm:flex-none justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Salin Link</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <aside class="lg:col-span-4 order-1 lg:order-2">
                    <div class="sticky top-20 lg:top-24 space-y-6 sm:space-y-8">
                        <!-- Table of Contents -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Daftar Isi</h3>
                            </div>
                            <nav id="toc" class="space-y-2 text-sm"></nav>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl shadow-lg p-6 text-white">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold">Butuh Bantuan?</h3>
                            </div>
                            <p class="text-white/90 mb-5 text-sm leading-relaxed">Konsultasikan kebutuhan digital marketing bisnis Anda dengan tim kami</p>
                            <a href="{{ route('home') }}#contact" 
                               class="flex items-center justify-center gap-2 w-full text-center bg-white text-primary hover:bg-gray-50 font-bold px-5 py-3 rounded-lg transition shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<!-- Comments Section -->
<section class="py-8 sm:py-12 lg:py-16 xl:py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Comments Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 mb-6 sm:mb-8 lg:mb-10 bg-gradient-to-r from-primary/5 to-secondary/5 p-4 sm:p-6 rounded-2xl border border-primary/10">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center shadow-lg flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
                        Komentar <span class="text-primary">({{ $article->approvedComments->count() }})</span>
                    </h2>
                    <p class="text-gray-600 text-xs sm:text-sm mt-1">Bagikan pendapat Anda tentang artikel ini</p>
                </div>
            </div>
            
            <!-- Comment Form -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 lg:mb-10">
                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">Tinggalkan Komentar</h3>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-lg mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('blog.comment.store', $article) }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        <div>
                            <label for="name" class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama Lengkap *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror transition text-sm sm:text-base"
                                   placeholder="Masukkan nama Anda">
                            @error('name')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror transition text-sm sm:text-base"
                                   placeholder="nama@email.com">
                            @error('email')
                                <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="comment" class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Komentar *
                        </label>
                        <textarea id="comment" 
                                  name="comment" 
                                  rows="5" 
                                  required
                                  class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('comment') border-red-500 @enderror transition resize-none text-sm sm:text-base"
                                  placeholder="Tulis komentar Anda di sini...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-2 text-xs sm:text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-secondary hover:opacity-90 text-white font-bold px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg transition shadow-lg hover:shadow-xl text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Komentar
                    </button>
                </form>
            </div>
            
            <!-- Comments List -->
            @if($article->approvedComments->count() > 0)
                <div class="space-y-4 sm:space-y-5">
                    @foreach($article->approvedComments as $comment)
                        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md border border-gray-100 p-4 sm:p-5 lg:p-6 xl:p-7 hover:shadow-lg transition">
                            <div class="flex items-start gap-3 sm:gap-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold text-lg sm:text-xl shadow-lg">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-2 sm:gap-3 mb-2 sm:mb-3">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $comment->name }}</h4>
                                            <p class="text-xs sm:text-sm text-gray-500 flex items-center gap-1.5 mt-0.5">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $comment->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed break-words">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 p-8 sm:p-10 lg:p-12 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-5">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Belum Ada Komentar</h3>
                    <p class="text-sm sm:text-base text-gray-600">Jadilah yang pertama berkomentar di artikel ini!</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Related Articles -->
@if($relatedArticles->count() > 0)
<section class="py-8 sm:py-12 lg:py-16 xl:py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-10 lg:mb-12">
                <div class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-primary/10 rounded-full text-primary font-semibold text-xs sm:text-sm mb-3 sm:mb-4">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Rekomendasi
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4 px-2">
                    Artikel Terkait
                </h2>
                <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto px-4">
                    Baca juga artikel menarik lainnya yang mungkin Anda suka
                </p>
            </div>
            
            <!-- Articles Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @foreach($relatedArticles as $related)
                    <article class="group bg-white rounded-xl sm:rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                        <!-- Image -->
                        <div class="relative overflow-hidden aspect-[16/10]">
                            <a href="{{ route('blog.show', $related->slug) }}" class="block h-full">
                                @if($related->featured_image)
                                    <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                         alt="{{ $related->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-4 sm:p-5 lg:p-6">
                            <p class="text-xs sm:text-sm text-gray-500 font-medium mb-2 sm:mb-3">
                                {{ $related->published_at->format('d M Y') }}
                            </p>
                            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 mb-2 sm:mb-3 line-clamp-2 min-h-[2.5rem] sm:min-h-[3.5rem]">
                                <a href="{{ route('blog.show', $related->slug) }}" class="hover:text-primary transition-colors">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2 leading-relaxed">
                                {{ $related->excerpt }}
                            </p>
                            <a href="{{ route('blog.show', $related->slug) }}" 
                               class="inline-flex items-center gap-1.5 sm:gap-2 text-primary font-semibold text-xs sm:text-sm hover:underline">
                                Baca Artikel
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Enhanced Prose Styles -->
<style>
    .prose {
        color: #374151;
        line-height: 1.75;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
    }
    
    .prose * {
        max-width: 100%;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .prose h2 {
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        line-height: 1.3;
        color: #111827;
        scroll-margin-top: 6rem;
    }
    
    .prose h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        line-height: 1.4;
        color: #111827;
        scroll-margin-top: 6rem;
    }
    
    .prose h4 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
        line-height: 1.5;
        color: #111827;
    }
    
    .prose p {
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
    }
    
    .prose ul, .prose ol {
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        padding-left: 1.75rem;
    }
    
    /* Fix nested lists - remove extra padding when ul/ol is inside li */
    .prose li > ul,
    .prose li > ol {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        padding-left: 1.5rem;
    }
    
    .prose li {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        padding-left: 0.5rem;
    }
    
    /* Fix improper nested structure: ul > li > ol (should be flattened - remove parent li styling) */
    .prose ul > li:only-child {
        padding-left: 0;
        margin-left: 0;
        list-style: none;
    }
    
    /* Make ol inside ul > li display as normal ordered list */
    .prose ul > li > ol {
        padding-left: 1.5rem;
        margin-left: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
    
    .prose ul > li > ol > li {
        padding-left: 0.5rem;
        list-style: decimal;
        margin-left: 0;
    }
    
    /* Remove extra indentation from pagelayer elements */
    .prose .pagelayer-text ul,
    .prose .pagelayer-text ol {
        padding-left: 1.5rem;
    }
    
    .prose .pagelayer-text ul > li {
        padding-left: 0.5rem;
    }
    
    /* Fix improper nested structure in pagelayer: ul > li > ol */
    .prose .pagelayer-text ul > li > ol {
        padding-left: 1.5rem;
        margin-left: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
    
    /* Remove padding and list style from parent li in pagelayer when it only contains ol */
    .prose .pagelayer-text ul > li:only-child {
        padding-left: 0;
        margin-left: 0;
        list-style: none;
    }
    
    .prose .pagelayer-text ul > li > ol > li {
        padding-left: 0.5rem;
        list-style: decimal;
        margin-left: 0;
    }
    
    .prose ul li::marker {
        color: var(--primary-color);
    }
    
    .prose strong {
        color: #111827;
        font-weight: 600;
    }
    
    .prose a {
        color: var(--primary-color);
        text-decoration: underline;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .prose a:hover {
        color: var(--secondary-color);
    }
    
    .prose img {
        margin-top: 2rem;
        margin-bottom: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .prose blockquote {
        font-style: italic;
        border-left: 4px solid var(--primary-color);
        padding-left: 1.5rem;
        margin: 2rem 0;
        color: #6b7280;
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.5rem;
    }
    
    .prose code {
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.875em;
        color: #ef4444;
        font-weight: 600;
    }
    
    .prose pre {
        background: #1f2937;
        color: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 2rem 0;
    }
    
    .prose pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }
    
    /* TOC Styles */
    #toc a {
        display: block;
        padding: 0.625rem 0.875rem;
        color: #6b7280;
        border-radius: 0.5rem;
        transition: all 0.3s;
        border-left: 3px solid transparent;
    }
    
    #toc a:hover {
        background: #f9fafb;
        color: var(--primary-color);
        border-left-color: var(--primary-color);
        padding-left: 1.25rem;
    }
    
    #toc a.ml-3 {
        margin-left: 1rem;
        font-size: 0.875rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .prose {
            font-size: 0.875rem;
        }
        
        .prose h2 {
            font-size: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        
        .prose h3 {
            font-size: 1.25rem;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .prose h4 {
            font-size: 1.125rem;
        }
        
        .prose p {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        
        .prose img {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0.75rem;
        }
        
        .prose pre {
            padding: 1rem;
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 640px) {
        .prose {
            font-size: 0.8125rem;
        }
        
        .prose h2 {
            font-size: 1.25rem;
        }
        
        .prose h3 {
            font-size: 1.125rem;
        }
        
        .prose blockquote {
            padding: 1rem;
            margin: 1.5rem 0;
        }
    }
</style>

<script>
    // Clean improper nested list structure (ul > li > ol)
    function cleanNestedListsInContent() {
        const contentEl = document.getElementById('article-content');
        if (!contentEl) return;
        
        // Find all ul > li > ol structures
        const ulElements = contentEl.querySelectorAll('ul');
        ulElements.forEach(ul => {
            const liElements = ul.querySelectorAll(':scope > li');
            
            // Check if ul has only one li
            if (liElements.length === 1) {
                const li = liElements[0];
                const olElements = li.querySelectorAll(':scope > ol');
                const otherElements = Array.from(li.childNodes).filter(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        return node.tagName !== 'OL';
                    }
                    return node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '';
                });
                
                // If li contains only ol and no other content, replace ul with ol
                if (olElements.length === 1 && otherElements.length === 0) {
                    const ol = olElements[0].cloneNode(true);
                    ul.parentNode.replaceChild(ol, ul);
                }
            }
        });
    }

    // Enhanced reading time and TOC generator
    (function() {
        const contentEl = document.getElementById('article-content');
        if (!contentEl) return;

        // Clean improper nested lists first
        cleanNestedListsInContent();

        // Reading time calculation
        const text = contentEl.innerText || '';
        const words = text.trim().split(/\s+/).length;
        const minutes = Math.max(1, Math.round(words / 200));
        const rtEl = document.getElementById('reading-time');
        if (rtEl) rtEl.textContent = minutes + ' menit';

        // Generate Table of Contents
        const headings = contentEl.querySelectorAll('h2, h3');
        const toc = document.getElementById('toc');
        
        if (toc && headings.length) {
            const frag = document.createDocumentFragment();
            headings.forEach((h, i) => {
                if (!h.id) h.id = 'heading-' + (i + 1);
                const a = document.createElement('a');
                a.href = '#' + h.id;
                a.textContent = h.textContent;
                a.className = 'toc-link ' + (h.tagName === 'H3' ? 'ml-3' : '');
                frag.appendChild(a);
            });
            toc.appendChild(frag);
            
            // Smooth scroll for TOC links
            toc.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        // Adjust for fixed header
                        window.scrollBy(0, -100);
                    }
                });
            });
        }

        // Copy link functionality
        const copyBtn = document.getElementById('copy-link');
        if (copyBtn) {
            copyBtn.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(window.location.href);
                    const originalHTML = copyBtn.innerHTML;
                    copyBtn.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Link Disalin!
                    `;
                    setTimeout(() => {
                        copyBtn.innerHTML = originalHTML;
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy:', err);
                }
            });
        }
    })();
</script>
@endsection
