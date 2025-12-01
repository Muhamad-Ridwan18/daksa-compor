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
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                </svg>
                Dokumen & Peraturan
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight px-2">
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
@endsection

