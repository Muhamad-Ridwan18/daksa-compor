@extends('layouts.frontend')

@section('content')
<!-- Hero Section with Modern Gradient -->
<section class="relative min-h-[60vh] flex items-center justify-center bg-gradient-to-br from-primary via-secondary to-primary overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 pattern-dots"></div>
    </div>
    
    <!-- Floating Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none bg-primary">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16">
        <div class="max-w-4xl mx-auto text-center text-white">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-sm font-semibold mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                </svg>
                {{ \App\Models\Setting::getValue('gallery_hero_badge', 'Gallery & Portfolio') }}
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                {{ \App\Models\Setting::getValue('gallery_hero_title', 'Koleksi Karya Kami') }}
                <span class="block text-white/90 mt-2">{{ \App\Models\Setting::getValue('gallery_hero_subtitle', 'Portfolio & Gallery') }}</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-lg sm:text-xl lg:text-2xl mb-10 text-white/90 max-w-3xl mx-auto">
                {{ \App\Models\Setting::getValue('gallery_hero_description', 'Jelajahi karya-karya terbaik kami dan lihat bagaimana kami membantu klien mencapai kesuksesan') }}
            </p>
            
            <!-- Category Filter with Animation -->
            @if($categories->count() > 0)
            <div class="flex flex-wrap items-center justify-center gap-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('gallery.index') }}" 
                   class="gallery-filter-btn px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 {{ !request('category') ? 'bg-white text-primary shadow-2xl scale-105' : 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-sm border border-white/20' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                        </svg>
                        Semua
                    </span>
                </a>
                @foreach($categories as $index => $category)
                <a href="{{ route('gallery.index', ['category' => $category]) }}" 
                   class="gallery-filter-btn px-6 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 {{ request('category') === $category ? 'bg-white text-primary shadow-2xl scale-105' : 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-sm border border-white/20' }}"
                   data-aos="fade-up" 
                   data-aos-delay="{{ 250 + ($index * 50) }}">
                    {{ $category }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-12 lg:py-20 bg-gradient-to-b from-white via-gray-50/50 to-white relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            @if($galleries->count() > 0)
                <!-- Stats Section -->
                <div class="text-center mb-12 lg:mb-16" data-aos="fade-up">
                    <div class="inline-flex items-center gap-8 px-8 py-4 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-100">
                        <div>
                            <div class="text-3xl font-bold text-primary">{{ $galleries->count() }}</div>
                            <div class="text-xs text-gray-600 uppercase tracking-wider mt-1">Total Karya</div>
                        </div>
                        @if($categories->count() > 0)
                        <div class="h-12 w-px bg-gray-200"></div>
                        <div>
                            <div class="text-3xl font-bold text-secondary">{{ $categories->count() }}</div>
                            <div class="text-xs text-gray-600 uppercase tracking-wider mt-1">Kategori</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Masonry-Style Gallery Grid -->
                <div class="gallery-masonry grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6" id="gallery-grid">
                    @foreach($galleries as $gallery)
                        @php
                            // Variasi aspect ratio untuk visual interest
                            $aspectRatios = ['aspect-square', 'aspect-[4/5]', 'aspect-[3/4]', 'aspect-square', 'aspect-[5/4]'];
                            $aspectClass = $aspectRatios[$loop->index % 5];
                            // Setiap item ke-5 dan ke-8 lebih tinggi untuk variasi
                            $isTall = ($loop->index + 1) % 5 == 0 || ($loop->index + 1) % 8 == 0;
                            $aspectClass = $isTall ? 'aspect-[3/5]' : $aspectClass;
                        @endphp
                        
                        <div class="gallery-item group relative overflow-hidden rounded-xl lg:rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-[1.02]" 
                             data-aos="zoom-in" 
                             data-aos-delay="{{ $loop->index * 75 }}"
                             data-category="{{ $gallery->category ? strtolower(str_replace(' ', '-', $gallery->category)) : 'all' }}">
                            
                            <!-- Image Container with Parallax Effect -->
                            <div class="relative overflow-hidden {{ $aspectClass }} bg-gradient-to-br from-gray-100 to-gray-200">
                                <img src="{{ asset('storage/' . $gallery->image) }}" 
                                     alt="{{ $gallery->title }}"
                                     class="w-full h-full object-cover transition-all duration-700 group-hover:scale-125 group-hover:rotate-2"
                                     loading="eager">
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500">
                                    <div class="absolute inset-0 bg-primary/20 mix-blend-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                </div>
                                
                                <!-- Content Overlay -->
                                <div class="absolute inset-0 flex flex-col justify-end p-4 lg:p-6 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 opacity-0 group-hover:opacity-100">
                                    <div class="text-white">
                                        @if($gallery->category)
                                            <span class="inline-block mb-3 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider border border-white/30">
                                                {{ $gallery->category }}
                                            </span>
                                        @endif
                                        <h3 class="text-lg lg:text-xl font-bold mb-2 leading-tight">{{ $gallery->title }}</h3>
                                        @if($gallery->description)
                                            <p class="text-sm text-white/90 line-clamp-2 mb-3">{{ Str::limit($gallery->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Animated Border -->
                                <div class="absolute inset-0 border-2 border-primary/0 group-hover:border-primary/50 rounded-xl lg:rounded-2xl transition-all duration-500"></div>
                                
                                <!-- Zoom Icon with Animation -->
                                <div class="absolute top-4 right-4 transform translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500 delay-100">
                                    <div class="bg-white/95 backdrop-blur-md rounded-full p-3 shadow-xl transform group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Shine Effect -->
                                <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                            </div>
                            
                            <!-- Lightbox Trigger -->
                            <a href="{{ asset('storage/' . $gallery->image) }}" 
                               data-lightbox="gallery" 
                               data-title="{{ $gallery->title }}@if($gallery->description) - {{ $gallery->description }}@endif"
                               class="absolute inset-0 z-10 cursor-zoom-in"></a>
                        </div>
                    @endforeach
                </div>
                
            @else
                <!-- Empty State with Animation -->
                <div class="text-center py-20" data-aos="fade-up" data-aos-delay="100">
                    <div class="inline-block p-6 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-3xl mb-6">
                        <svg class="w-24 h-24 mx-auto text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Gallery Kosong</h3>
                    <p class="text-gray-600 mb-6">Belum ada gambar gallery yang ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Lightbox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">

<!-- jQuery (required for lightbox2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Lightbox Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<!-- Gallery Enhancement Scripts -->
<style>
    /* Smooth Gallery Item Animations */
    .gallery-item {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Masonry Grid Adjustments */
    .gallery-masonry {
        display: grid;
        grid-auto-rows: minmax(200px, auto);
    }
    
    /* Responsive adjustments */
    @media (min-width: 1024px) {
        .gallery-masonry {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 1280px) {
        .gallery-masonry {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    /* Filter Button Animation */
    .gallery-filter-btn {
        position: relative;
        overflow: hidden;
    }
    
    .gallery-filter-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .gallery-filter-btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    /* Image Loading State - Show by default, hide only if not loaded */
    .gallery-item img {
        opacity: 1;
        transition: opacity 0.3s ease-in;
    }
    
    /* Only hide images that are not yet marked as loaded */
    .gallery-item img:not(.loaded):not([data-loaded="true"]) {
        opacity: 0;
    }
    
    .gallery-item img.loaded,
    .gallery-item img[data-loaded="true"] {
        opacity: 1 !important;
    }
    
    /* Stagger Animation */
    .gallery-item:nth-child(1) { animation-delay: 0ms; }
    .gallery-item:nth-child(2) { animation-delay: 75ms; }
    .gallery-item:nth-child(3) { animation-delay: 150ms; }
    .gallery-item:nth-child(4) { animation-delay: 225ms; }
    .gallery-item:nth-child(5) { animation-delay: 300ms; }
    .gallery-item:nth-child(6) { animation-delay: 375ms; }
    .gallery-item:nth-child(7) { animation-delay: 450ms; }
    .gallery-item:nth-child(8) { animation-delay: 525ms; }
    .gallery-item:nth-child(n+9) { animation-delay: 600ms; }
</style>

<script>
    // Wait for jQuery and Lightbox to be ready
    (function($) {
        'use strict';
        
        // Initialize when DOM is ready
        $(document).ready(function() {
            // Initialize Lightbox with options
            if (typeof lightbox !== 'undefined') {
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'albumLabel': 'Gambar %1 dari %2',
                    'fadeDuration': 300,
                    'imageFadeDuration': 300
                });
            }
            
            // Load and show images immediately
            const images = document.querySelectorAll('.gallery-item img');
            
            // Function to mark image as loaded
            function markImageAsLoaded(img) {
                img.classList.add('loaded');
                img.setAttribute('data-loaded', 'true');
            }
            
            // Immediately check and show all images
            function initializeImages() {
                images.forEach(img => {
                    // Check if image is already loaded
                    if (img.complete && img.naturalHeight > 0) {
                        // Image already loaded - show immediately
                        markImageAsLoaded(img);
                    } else {
                        // Image not loaded yet - wait for load event
                        img.addEventListener('load', function() {
                            markImageAsLoaded(this);
                        }, { once: true });
                        
                        // Also listen for error (to show placeholder)
                        img.addEventListener('error', function() {
                            // Image failed to load, but still show it
                            markImageAsLoaded(this);
                        }, { once: true });
                    }
                });
            }
            
            // Run immediately
            initializeImages();
            
            // Double check after a short delay (for cached images where load event might not fire)
            setTimeout(() => {
                images.forEach(img => {
                    if (img.complete && img.naturalHeight > 0 && !img.classList.contains('loaded')) {
                        markImageAsLoaded(img);
                    }
                });
            }, 100);
            
            // Final fallback: Force show all images after window load (in case some images are missed)
            $(window).on('load', function() {
                setTimeout(() => {
                    images.forEach(img => {
                        markImageAsLoaded(img);
                    });
                }, 200);
            });
            
            // Smooth scroll for filter buttons
            const filterButtons = document.querySelectorAll('.gallery-filter-btn');
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        width: 20px;
                        height: 20px;
                        margin-top: -10px;
                        margin-left: -10px;
                        pointer-events: none;
                        animation: ripple 0.6s ease-out;
                    `;
                    
                    const rect = this.getBoundingClientRect();
                    ripple.style.left = (e.clientX - rect.left) + 'px';
                    ripple.style.top = (e.clientY - rect.top) + 'px';
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                });
            });
            
            // Add CSS for ripple animation
            if (!document.getElementById('gallery-ripple-style')) {
                const style = document.createElement('style');
                style.id = 'gallery-ripple-style';
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(20);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Refresh AOS after images load
            $(window).on('load', function() {
                if (typeof AOS !== 'undefined') {
                    setTimeout(function() {
                        AOS.refreshHard();
                    }, 500);
                }
            });
        });
    })(jQuery || window.jQuery || window.$);
</script>
@endsection


