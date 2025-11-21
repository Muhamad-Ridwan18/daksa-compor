@extends('layouts.frontend')

@section('content')
<!-- Hero Section with Parallax -->
<section id="home" class="relative min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh] flex items-center justify-center overflow-hidden {{ isset($settings['hero_background_image']) && $settings['hero_background_image'] ? 'hero-section-with-bg' : '' }}">
    <!-- Animated Background (full height background) -->
    @if(isset($settings['hero_background_image']) && $settings['hero_background_image'])
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('{{ Storage::url($settings['hero_background_image']) }}');"></div>
        <!-- Overlay for text readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/70 to-primary/90"></div>
    @endif
    
    <!-- Decorative Parallax Background -->
    <div aria-hidden="true">
        <div class="parallax-bg bg-1"></div>
        <div class="parallax-bg bg-2"></div>
        <div class="parallax-bg bg-3"></div>
        <div class="floating-particle particle-1"></div>
        <div class="floating-particle particle-2"></div>
        <div class="floating-particle particle-3"></div>
        <div class="floating-particle particle-4"></div>
        <div class="floating-particle particle-5"></div>
        <div class="floating-particle particle-6"></div>
    </div>

        <!-- Hero Carousel Full -->
        <div class="hero-full-carousel" id="heroCarousel" role="region" aria-roledescription="carousel" aria-label="Hero">
            <div class="hero-carousel-track-full" id="heroCarouselTrackFull">
                <!-- Slide 1 -->
                <div class="hero-full-slide active">
                    <div class="hero-full-slide-bg">
                        @if(isset($settings['hero_slide_bg_1']) && $settings['hero_slide_bg_1'])
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                 style="background-image: url('{{ Storage::url($settings['hero_slide_bg_1']) }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
                        @elseif(isset($settings['hero_background_image']) && $settings['hero_background_image'])
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                 style="background-image: url('{{ Storage::url($settings['hero_background_image']) }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/70 to-primary/90"></div>
                        @endif
                    </div>
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center hero-overlap">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 lg:gap-10 items-center w-full">
                        <!-- Right: Image floats and overlaps -->
                        <div class="hero-slide-image-wrapper hero-image-float order-2 h-full">
                            @if(isset($settings['hero_image_1']) && $settings['hero_image_1'])
                                <div class="hero-slide-image h-full min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh]">
                                    <img src="{{ Storage::url($settings['hero_image_1']) }}" 
                                         alt="Hero Slide 1" 
                                         class="object-contain">
                                </div>
                            @else
                                <div class="hero-slide-image hero-placeholder h-full min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh] flex items-center justify-center">
                                    <svg class="w-32 h-32 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Left: Content -->
                        <div class="hero-slide-content hero-content text-center order-1 active" data-stagger data-stagger-base="0" data-stagger-step="120">
                            <h3 class="hero-slide-title" data-animate="fadeInUp" data-delay="0ms">{{ $settings['hero_title'] ?? 'Selamat Datang di Daksa' }}</h3>
                            <p class="hero-slide-description" data-animate="fadeInUp" data-delay="160ms">{{ $settings['hero_description'] ?? 'Kami menyediakan solusi terbaik untuk kebutuhan bisnis Anda dengan layanan berkualitas tinggi dan tim profesional.' }}</p>
                            <div class="hero-slide-buttons" data-animate="fadeInUp" data-delay="280ms">
                                <a href="#services" class="hero-btn-primary">
                                    Lihat Layanan
                                </a>
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: '6281234567890';
                                    $waText = trim($settings['whatsapp_template'] ?? '');
                                    $waUrl = 'https://wa.me/' . $waNumber . ($waText !== '' ? ('?text=' . urlencode($waText)) : '');
                                @endphp
                                <a href="{{ $waUrl }}" class="hero-btn-secondary" target="_blank" rel="noopener">
                                    Hubungi Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                <!-- Slide 2 -->
                <div class="hero-full-slide">
                    <div class="hero-full-slide-bg">
                        @if(isset($settings['hero_slide_bg_2']) && $settings['hero_slide_bg_2'])
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                 style="background-image: url('{{ Storage::url($settings['hero_slide_bg_2']) }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
                        @elseif(isset($settings['hero_background_image']) && $settings['hero_background_image'])
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                 style="background-image: url('{{ Storage::url($settings['hero_background_image']) }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/70 to-primary/90"></div>
                        @endif
                    </div>
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center hero-overlap">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 items-center w-full">
                        <!-- Right: Image floats and overlaps -->
                        <div class="hero-slide-image-wrapper hero-image-float order-2 h-full">
                            @if(isset($settings['hero_image_2']) && $settings['hero_image_2'])
                                <div class="hero-slide-image h-full min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh]">
                                    <img src="{{ Storage::url($settings['hero_image_2']) }}" 
                                         alt="Hero Slide 2" 
                                         class="object-contain">
                                </div>
                            @else
                                <div class="hero-slide-image hero-placeholder h-full min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh] flex items-center justify-center">
                                    <svg class="w-32 h-32 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Left: Content -->
                        <div class="hero-slide-content hero-content text-center order-1" data-stagger data-stagger-base="0" data-stagger-step="120">
                            <h3 class="hero-slide-title" data-animate="fadeInUp" data-delay="0ms">Solusi Profesional untuk Bisnis Anda</h3>
                            <p class="hero-slide-description" data-animate="fadeInUp" data-delay="160ms">Dengan pengalaman bertahun-tahun, kami siap membantu mengembangkan bisnis Anda dengan layanan terpercaya dan berkualitas tinggi.</p>
                            <div class="hero-slide-buttons" data-animate="fadeInUp" data-delay="280ms">
                                <a href="#services" class="hero-btn-primary">
                                    Layanan Kami
                                </a>
                                <a href="#about" class="hero-btn-secondary">
                                    Tentang Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                <!-- Slide 3 -->
                <div class="hero-full-slide">
                    <div class="hero-full-slide-bg">
                        @if(isset($settings['hero_slide_bg_3']) && $settings['hero_slide_bg_3'])
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                 style="background-image: url('{{ Storage::url($settings['hero_slide_bg_3']) }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
                        @elseif(isset($settings['hero_background_image']) && $settings['hero_background_image'])
                            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                 style="background-image: url('{{ Storage::url($settings['hero_background_image']) }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/70 via-primary/50 to-primary/70"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/70 to-primary/90"></div>
                        @endif
                    </div>
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center hero-overlap">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 items-center w-full">
                        <!-- Right: Image floats and overlaps -->
                        <div class="hero-slide-image-wrapper hero-image-float order-2 h-full">
                            @if(isset($settings['hero_image_3']) && $settings['hero_image_3'])
                                <div class="hero-slide-image h-full min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh]">
                                    <img src="{{ Storage::url($settings['hero_image_3']) }}" 
                                         alt="Hero Slide 3" 
                                         class="object-contain">
                                </div>
                            @else
                                <div class="hero-slide-image hero-placeholder h-full min-h-[70vh] md:min-h-[65vh] lg:min-h-[60vh] flex items-center justify-center">
                                    <svg class="w-32 h-32 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Left: Content -->
                        <div class="hero-slide-content hero-content text-center order-1" data-stagger data-stagger-base="0" data-stagger-step="120">
                            <h3 class="hero-slide-title" data-animate="fadeInUp" data-delay="0ms">Kepercayaan dan Kualitas adalah Prioritas</h3>
                            <p class="hero-slide-description" data-animate="fadeInUp" data-delay="160ms">Ratusan klien telah mempercayai kami. Bergabunglah dengan mereka dan rasakan layanan terbaik untuk mencapai kesuksesan bisnis Anda.</p>
                            <div class="hero-slide-buttons" data-animate="fadeInUp" data-delay="280ms">
                                <a href="#testimonials" class="hero-btn-primary">
                                    Testimoni
                                </a>
                                <a href="#contact" class="hero-btn-secondary">
                                    Konsultasi Gratis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carousel Navigation - Hidden -->
        <button class="hero-full-carousel-prev" type="button" aria-label="Slide sebelumnya">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="hero-full-carousel-next" type="button" aria-label="Slide berikutnya">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        <!-- Carousel Indicators - Hidden -->
        <div class="hero-full-carousel-indicators" id="heroCarouselIndicators" role="tablist" aria-label="Navigasi slide">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </div>
</section>



<!-- About Section -->
<section id="about" class="py-20 bg-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="pattern-dots"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-animate="fadeInUp">
            <div class="section-eyebrow">Profil</div>
            <h2 class="section-title">Tentang Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                {{ $settings['about_description'] ?? 'Kami adalah perusahaan yang berkomitmen untuk memberikan solusi terbaik bagi klien kami dengan pengalaman bertahun-tahun di industri ini.' }}
            </p>
        </div>
        
        <!-- About Content with Image -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16 items-center">
            <!-- Image Section -->
            <div class="relative" data-animate="fadeInUp" data-delay="0ms">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    @if(isset($settings['about_image']) && $settings['about_image'])
                        <img src="{{ Storage::url($settings['about_image']) }}" alt="Tentang Kami" class="w-full h-[500px] object-cover">
                    @else
                        <!-- Placeholder Image -->
                        <div class="w-full h-[500px] bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-24 h-24 mx-auto text-primary/40 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-gray-500 text-lg">Tim Kami</p>
                            </div>
                        </div>
                    @endif
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-secondary/20 rounded-full blur-2xl"></div>
                </div>
                
                <!-- Stats Cards -->
                {{-- <div class="absolute -bottom-8 left-8 right-8 grid grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow-lg p-4 text-center">
                        <div class="text-2xl font-bold text-primary">10+</div>
                        <div class="text-xs text-gray-600">Tahun</div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-4 text-center">
                        <div class="text-2xl font-bold text-primary">500+</div>
                        <div class="text-xs text-gray-600">Klien</div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-4 text-center">
                        <div class="text-2xl font-bold text-primary">100+</div>
                        <div class="text-xs text-gray-600">Proyek</div>
                    </div>
                </div> --}}
            </div>
            
            <!-- Content Section -->
            <div class="lg:pl-8" data-animate="fadeInUp" data-delay="160ms">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    {{ $settings['about_title'] ?? 'Mengapa Memilih Kami?' }}
                </h3>
                <div class="prose prose-lg text-gray-600 mb-8">
                    <p class="leading-relaxed text-justify">
                        {{ $settings['about_content'] ?? 'Dengan pengalaman lebih dari 10 tahun di industri, kami telah membantu ratusan klien mencapai tujuan bisnis mereka. Tim profesional kami berkomitmen untuk memberikan solusi terbaik yang disesuaikan dengan kebutuhan unik setiap klien.' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16" data-stagger data-stagger-base="0" data-stagger-step="120">
            <div class="text-center feature-card" data-animate="fadeInUp" data-delay="0ms">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Berpengalaman & Teruji</h3>
                <p class="text-gray-600">Menghadapi berbagai kasus dan sektor industri sejak 2016</p>
            </div>
            <div class="text-center feature-card" data-animate="fadeInUp" data-delay="120ms">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Legalitas Terjamin</h3>
                <p class="text-gray-600">Memberikan Keamanan dan kepastian hukum dalam setiap layanan</p>
            </div>
            <div class="text-center feature-card" data-animate="fadeInUp" data-delay="240ms">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Solusi Terbaik untuk Bisnis Anda</h3>
                <p class="text-gray-600">Pendekatan yang disesuaikan dengan karakter dan kebutuhan perusahaan</p>
            </div>
            <div class="text-center feature-card" data-animate="fadeInUp" data-delay="360ms">
                <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Harga Kompetitif & Fleksibel</h3>
                <p class="text-gray-600">Menyesuaikan dengan kualifikasi usaha dan kebutuhan klien</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-background relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="service-bg-shape shape-1"></div>
        <div class="service-bg-shape shape-2"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-animate="fadeInUp">
            <div class="section-eyebrow">Layanan</div>
            <h2 class="section-title">Layanan Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                Kami menyediakan berbagai layanan profesional untuk memenuhi kebutuhan bisnis Anda.
            </p>
        </div>

        <!-- Services Accordion -->
        <div class="services-accordion max-w-5xl mx-auto">
            @foreach($services as $index => $service)
            <div class="accordion-item" data-animate="fadeInUp">
                <!-- Accordion Header -->
                <div class="accordion-header">
                    <div class="flex items-center gap-4 flex-1">
                        @if($service->image)
                        <div class="accordion-image">
                            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                        </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="accordion-title">{{ $service->name }}</h3>
                                @if($service->products->count() > 0)
                                    <span class="product-badge">{{ $service->products->count() }} Produk</span>
                                @endif
                            </div>
                            <p class="accordion-description">{{ $service->description }}</p>
                        </div>
                    </div>
                    @if($service->products->count() > 0)
                    <button onclick="toggleAccordion('{{ $service->id }}')" class="accordion-button">
                        <span class="accordion-button-text">Lihat</span>
                        <div class="accordion-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    @endif
                </div>
                
                <!-- Accordion Content -->
                @if($service->products->count() > 0)
                <div id="accordion-{{ $service->id }}" class="accordion-content">
                    <div class="accordion-inner">
                        <div class="products-scroll-wrapper" id="products-{{ $service->id }}">
                            @if($service->products->count() > 1)
                            <div class="scroll-hint">Geser →</div>
                            @endif
                            <div class="products-grid">
                                @foreach($service->products as $productIndex => $product)
                                <div class="pricing-card" data-service-id="{{ $service->id }}" data-product-idx="{{ $productIndex }}" @if(isset($product->image) && $product->image) data-image="{{ Storage::url($product->image) }}" @endif>
                                    <div class="pricing-card-header">
                                        <h4 class="pricing-card-title">{{ $product->name }}</h4>
                                        <div class="pricing-card-price" style="{{ !($product->show_price ?? true) ? 'display: none;' : '' }}">
                                            <span class="price-amount">{{ $product->formatted_price }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="pricing-card-body">
                                        @if($product->description)
                                            <p class="pricing-card-description">{{ $product->description }}</p>
                                        @endif
                                        
                                        <div class="pricing-features">
                                            @php 
                                                $features = $product->features ?? [];
                                                // Handle backward compatibility: convert old string format to new array format
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
                                                $maxLength = 80;
                                                $isLong = $descLength > $maxLength;
                                            @endphp
                                            <div class="feature-item">
                                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <div class="flex-1">
                                                    <span class="font-medium">{{ $featureName }}</span>
                                                    @if($hasDescription)
                                                        <div class="mt-1">
                                                            @if($isLong)
                                                                <p id="{{ $featureId }}-short" class="text-sm text-gray-600">
                                                                    {{ Str::limit($featureDesc, $maxLength) }}
                                                                    <button type="button" onclick="toggleFeatureDesc('{{ $featureId }}')" class="text-primary hover:underline ml-1 font-medium">
                                                                        Baca selengkapnya
                                                                    </button>
                                                                </p>
                                                                <p id="{{ $featureId }}-full" class="text-sm text-gray-600 hidden">
                                                                    {{ $featureDesc }}
                                                                    <button type="button" onclick="toggleFeatureDesc('{{ $featureId }}')" class="text-primary hover:underline ml-1 font-medium">
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
                                            <div class="feature-item">
                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <circle cx="10" cy="10" r="2" />
                                                </svg>
                                                <span class="text-gray-500">Fitur belum ditambahkan</span>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                    
                                    <div class="pricing-card-footer">
                                        <button onclick="openOrderModal('{{ $service->id }}', '{{ $product->id }}')" class="pricing-card-button">
                                            Pilih Paket
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Desktop Carousel Navigation - Small buttons below carousel, only when accordion is open -->
                        @if($service->products->count() > 1)
                        <div class="desktop-carousel-nav" id="desktop-carousel-nav-{{ $service->id }}">
                            <button class="carousel-nav-btn carousel-nav-prev" onclick="scrollProducts('{{ $service->id }}', 'left')" aria-label="Sebelumnya">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>Sebelumnya</span>
                            </button>
                            <button class="carousel-nav-btn carousel-nav-next" onclick="scrollProducts('{{ $service->id }}', 'right')" aria-label="Selanjutnya">
                                <span>Selanjutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        @endif
                        
                        @if($service->products->count() > 1)
                        <div class="products-dots" data-service-id="{{ $service->id }}">
                            @for($i = 0; $i < $service->products->count(); $i++)
                                <button class="products-dot {{ $i === 0 ? 'active' : '' }}" data-idx="{{ $i }}" aria-label="Produk {{ $i + 1 }}"></button>
                            @endfor
                        </div>
                        @endif
                        
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="py-20 bg-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0">
        <div class="testimonial-bg-pattern"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-animate="fadeInUp">
            <div class="section-eyebrow">Cerita Klien</div>
            <h2 class="section-title">Testimonial Klien</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                Apa kata klien kami tentang layanan yang kami berikan.
            </p>
        </div>

        <!-- Testimonial Carousel -->
        <div class="testimonial-carousel-container">
            <div class="testimonial-carousel-wrapper">
                <div class="testimonial-carousel-track" id="testimonialTrack">
                    @foreach($testimonials as $testimonialIndex => $testimonial)
                    <div class="testimonial-slide" data-animate="fadeInUp">
                        <div class="testimonial-card">
                            <!-- Quote Icon -->
                            <div class="testimonial-quote-icon">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>
                            </div>
                            
                            <!-- Message -->
                            <div class="testimonial-message">
                                <p>"{{ $testimonial->message }}"</p>
                            </div>
                            
                            <!-- Rating Stars -->
                            <div class="testimonial-rating">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            
                            <!-- Author Info -->
                            <div class="testimonial-author">
                                <div class="testimonial-avatar">
                                    @if($testimonial->photo)
                                        <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}">
                                    @else
                                        <div class="testimonial-avatar-placeholder">
                                            <span>{{ substr($testimonial->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="testimonial-info">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->position }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Carousel Controls -->
            <div class="testimonial-controls">
                <button class="testimonial-prev-btn" onclick="prevTestimonial()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="testimonial-next-btn" onclick="nextTestimonial()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            
            <!-- Carousel Indicators -->
            <div class="testimonial-indicators">
                @for($i = 0; $i < max(1, $testimonials->count() - 2); $i++)
                <button class="testimonial-indicator {{ $i === 0 ? 'active' : '' }}" onclick="goToTestimonial({{ $i }})"></button>
                @endfor
            </div>
        </div>
    </div>
</section>

<!-- Client Logos Section -->
@if($clients->count() > 0)
<section class="py-16 bg-background relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-stagger data-stagger-base="0" data-stagger-step="140">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4" data-animate="fadeInUp" data-delay="0ms">Klien Kami</h2>
            <p class="text-lg text-gray-600" data-animate="fadeInUp" data-delay="160ms">Perusahaan-perusahaan yang mempercayai layanan kami</p>
        </div>
        
        <div class="client-marquee-container">
            <!-- First row - moving left -->
            <div class="client-marquee-row marquee-left">
                <div class="client-marquee-content">
                    @foreach($clients as $client)
                    <div class="client-logo-item">
                        <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="w-auto object-contain opacity-80 hover:opacity-100 client-logo-img h-24 md:h-28 lg:h-32 xl:h-40">
                    </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($clients as $client)
                    <div class="client-logo-item">
                        <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="w-auto object-contain opacity-80 hover:opacity-100 client-logo-img h-24 md:h-28 lg:h-32 xl:h-40">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Second row - moving right -->
            <div class="client-marquee-row marquee-right">
                <div class="client-marquee-content">
                    @foreach($clients->reverse() as $client)
                    <div class="client-logo-item">
                        <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="w-auto object-contain opacity-80 hover:opacity-100 client-logo-img h-24 md:h-28 lg:h-32 xl:h-40">
                    </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($clients->reverse() as $client)
                    <div class="client-logo-item">
                        <img src="{{ Storage::url($client->logo) }}" alt="{{ $client->name }}" loading="lazy" class="w-auto object-contain opacity-80 hover:opacity-100 client-logo-img h-24 md:h-28 lg:h-32 xl:h-40">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
@if(isset($galleries) && $galleries->count() > 0)
<section class="py-16 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-stagger data-stagger-base="0" data-stagger-step="140">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4" data-animate="fadeInUp" data-delay="0ms">Galeri Kami</h2>
            <p class="text-lg text-gray-600" data-animate="fadeInUp" data-delay="160ms">Momen-momen terbaik dari aktivitas kami</p>
        </div>
        
        <div class="gallery-marquee-container">
            <!-- First row - moving left -->
            <div class="gallery-marquee-row marquee-left">
                <div class="gallery-marquee-content">
                    @foreach($galleries as $gallery)
                    <div class="gallery-image-item">
                        <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" class="gallery-marquee-img">
                    </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($galleries as $gallery)
                    <div class="gallery-image-item">
                        <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" class="gallery-marquee-img">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Second row - moving right -->
            <div class="gallery-marquee-row marquee-right">
                <div class="gallery-marquee-content">
                    @foreach($galleries->reverse() as $gallery)
                    <div class="gallery-image-item">
                        <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" class="gallery-marquee-img">
                    </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($galleries->reverse() as $gallery)
                    <div class="gallery-image-item">
                        <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" class="gallery-marquee-img">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-semibold transition">
                <span>Lihat Semua Galeri</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Our Team Section -->
@if(isset($teamMembers) && $teamMembers->count() > 0)
<section id="team" class="py-20 bg-background relative overflow-hidden">
    <div class="absolute inset-0 opacity-40">
        <div class="pattern-dots"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-animate="fadeInUp">
            <div class="section-eyebrow">People</div>
            <h2 class="section-title">Tim Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mt-4">
                Berkenalan dengan profesional di balik layanan kami.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-stagger data-stagger-base="0" data-stagger-step="120">
            @foreach($teamMembers as $memberIndex => $member)
            <div class="bg-white rounded-2xl shadow overflow-hidden" data-animate="fadeInUp">
                <div class="h-56 bg-gray-100 relative">
                    @if($member->photo)
                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $member->name }}</h3>
                    <p class="text-primary font-medium">{{ $member->role }}</p>
                    @if($member->bio)
                    <p class="text-gray-600 text-sm mt-3">{{ Str::limit($member->bio, 120) }}</p>
                    @endif
                    <div class="flex items-center justify-center gap-3 mt-4">
                        @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-primary">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.763 0 5-2.239 5-5v-14c0-2.761-2.237-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 11.268h-3v-5.604c0-1.336-.027-3.055-1.861-3.055-1.861 0-2.146 1.452-2.146 2.954v5.705h-3v-10h2.881v1.367h.041c.401-.759 1.379-1.559 2.838-1.559 3.037 0 3.6 2.001 3.6 4.604v5.588z"/></svg>
                        </a>
                        @endif
                        @if($member->twitter)
                        <a href="{{ $member->twitter }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-primary">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.487 11.24h-6.644l-5.196-6.79-5.95 6.79h-3.31l7.73-8.82-8.28-10.88h6.8l4.7 6.18 5.582-6.18zm-1.158 19.5h1.833l-11.79-15.68h-1.97l11.927 15.68z"/></svg>
                        </a>
                        @endif
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="text-gray-500 hover:text-primary">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Contact Section -->
<section id="contact" class="py-20 bg-secondary text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="contact-bg-shape shape-1"></div>
        <div class="contact-bg-shape shape-2"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 section-heading" data-animate="fadeInUp">
            <div class="section-eyebrow">Kontak</div>
            <h2 class="section-title">Hubungi Kami</h2>
            <div class="section-underline"></div>
            <p class="text-xl max-w-3xl mx-auto mt-4">
                Siap membantu mewujudkan impian bisnis Anda. Hubungi kami sekarang!
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12" data-stagger data-stagger-base="0" data-stagger-step="160">
            <div data-animate="fadeInUp" data-delay="0ms">
                <h3 class="text-2xl font-semibold mb-6">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <span>{{ $settings['company_email'] ?? 'info@daksa.com' }}</span>
                    </div>
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <span>{{ $settings['company_phone'] ?? '+62 123 456 789' }}</span>
                    </div>
                    <div class="flex items-center contact-info-item">
                        <div class="bg-primary/20 p-3 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span>{{ $settings['company_address'] ?? 'Jl. Contoh No. 123, Jakarta' }}</span>
                    </div>
                </div>
            </div>

            <div data-animate="fadeInUp" data-delay="160ms">
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
                        <button type="submit" class="px-4 py-2 text-sm bg-primary text-white font-semibold rounded-lg hover:bg-opacity-90 shadow flex-1">
                            Kirim Pesan
                        </button>
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: '6281234567890';
                            $waText = trim($settings['whatsapp_template'] ?? '');
                            $waUrl = 'https://wa.me/' . $waNumber . ($waText !== '' ? ('?text=' . urlencode($waText)) : '');
                        @endphp
                        <a href="{{ $waUrl }}"
                            class="px-4 py-2 text-sm bg-green-500 text-white font-semibold hover:bg-green-600 rounded-lg shadow flex-1 flex items-center justify-center"
                            target="_blank" rel="noopener"
                            style="background-color: #25D366; color: #fff; text-align: center;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="white" viewBox="0 0 24 24" style="color:#fff;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span class="text-white w-full text-center">Hubungi via WhatsApp</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        @if(($settings['gmaps_embed_url'] ?? null) || (($settings['gmaps_latitude'] ?? null) && ($settings['gmaps_longitude'] ?? null)) || ($settings['company_address'] ?? null))
        <div class="mt-16">
            <h3 class="text-2xl font-semibold mb-6 text-center lg:text-left">Lokasi Kami</h3>
            <div class="rounded-xl overflow-hidden border border-white/20 shadow-lg">
                @php
                    $lat = $settings['gmaps_latitude'] ?? null;
                    $lng = $settings['gmaps_longitude'] ?? null;
                    $zoom = $settings['gmaps_zoom'] ?? 15;
                    $src = $settings['gmaps_embed_url'] ?? null;
                    if (!$src && $lat && $lng) {
                        $src = 'https://www.google.com/maps?q=' . $lat . ',' . $lng . '&z=' . $zoom . '&output=embed';
                    }
                    if (!$src) {
                        $src = 'https://www.google.com/maps?q=' . urlencode($settings['company_address'] ?? '') . '&output=embed';
                    }
                @endphp
                <iframe
                    src="{{ $src }}"
                    width="100%"
                    height="420"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Pesan Layanan</h3>
                    <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            
            <form id="orderForm" action="{{ route('order.store') }}" method="POST">
                @csrf
                <input type="hidden" id="serviceId" name="service_id">
                <input type="hidden" id="productId" name="product_id">
                
                <div class="space-y-4">
                    <div>
                        <label for="orderName" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" id="orderName" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="orderEmail" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="orderEmail" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="orderPhone" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                        <input type="tel" id="orderPhone" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="orderNotes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                        <textarea id="orderNotes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeOrderModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90">
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Order Modal Functions (kept inline for simplicity)
function openOrderModal(serviceId, productId = null) {
    document.getElementById('serviceId').value = serviceId;
    if (productId) {
        document.getElementById('productId').value = productId;
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
// Accordion and products scroll functions used by buttons
function toggleAccordion(serviceId) {
    const accordionContent = document.getElementById(`accordion-${serviceId}`);
    const accordionItem = event.currentTarget.closest('.accordion-item');
    const icon = accordionItem.querySelector('.accordion-icon svg');
    const buttonText = accordionItem.querySelector('.accordion-button-text');
    document.querySelectorAll('.accordion-item').forEach(item => {
        if (item !== accordionItem) {
            const content = item.querySelector('.accordion-content');
            const otherIcon = item.querySelector('.accordion-icon svg');
            const otherButtonText = item.querySelector('.accordion-button-text');
            if (content && content.classList.contains('active')) {
                content.classList.remove('active');
                item.classList.remove('active');
                if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                if (otherButtonText) otherButtonText.textContent = 'Lihat';
            }
        }
    });
    if (accordionContent.classList.contains('active')) {
        accordionContent.classList.remove('active');
        accordionItem.classList.remove('active');
        if (icon) icon.style.transform = 'rotate(0deg)';
        if (buttonText) buttonText.textContent = 'Lihat';
        // Hide carousel navigation when accordion closes
        const carouselNav = document.getElementById(`desktop-carousel-nav-${serviceId}`);
        if (carouselNav) {
            carouselNav.style.opacity = '0';
            setTimeout(() => {
                carouselNav.style.display = 'none';
            }, 300);
        }
    } else {
        accordionContent.classList.add('active');
        accordionItem.classList.add('active');
        if (icon) icon.style.transform = 'rotate(180deg)';
        if (buttonText) buttonText.textContent = 'Tutup';
        setTimeout(() => { 
            accordionItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); 
            // Update carousel navigation buttons after accordion opens
            setTimeout(() => {
                updateCarouselNav(serviceId);
                equalizeCardHeights();
            }, 400);
        }, 300);
    }
}

// Function to update carousel navigation buttons based on scroll state
function updateCarouselNav(serviceId) {
    const productsWrapper = document.querySelector(`#accordion-${serviceId} .products-scroll-wrapper`);
    const carouselNav = document.getElementById(`desktop-carousel-nav-${serviceId}`);
    const accordionContent = document.getElementById(`accordion-${serviceId}`);
    
    if (!productsWrapper || !carouselNav || !accordionContent) return;
    
    // Only check on desktop and when accordion is active
    if (window.innerWidth < 769 || !accordionContent.classList.contains('active')) {
        carouselNav.style.display = 'none';
        carouselNav.style.opacity = '0';
        return;
    }
    
    // Check if scrolling is needed
    const isScrollable = productsWrapper.scrollWidth > productsWrapper.clientWidth;
    const scrollLeft = productsWrapper.scrollLeft;
    const maxScroll = productsWrapper.scrollWidth - productsWrapper.clientWidth;
    const isAtStart = scrollLeft <= 10;
    const isAtEnd = scrollLeft >= maxScroll - 10;
    
    // Show navigation buttons on desktop if scrollable
    if (isScrollable) {
        carouselNav.style.display = 'flex';
        carouselNav.style.opacity = '1';
        
        // Enable/disable buttons based on scroll position
        const prevBtn = carouselNav.querySelector('.carousel-nav-prev');
        const nextBtn = carouselNav.querySelector('.carousel-nav-next');
        
        if (prevBtn) {
            prevBtn.disabled = isAtStart;
        }
        if (nextBtn) {
            nextBtn.disabled = isAtEnd;
        }
    } else {
        carouselNav.style.opacity = '0';
        setTimeout(() => {
            if (carouselNav.style.opacity === '0') {
                carouselNav.style.display = 'none';
            }
        }, 300);
    }
}

function scrollProducts(serviceId, direction) {
    const productsWrapper = document.querySelector(`#accordion-${serviceId} .products-scroll-wrapper`);
    const scrollAmount = 350;
    if (!productsWrapper) return;
    productsWrapper.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
    
    // Update carousel navigation buttons after scrolling
    setTimeout(() => updateCarouselNav(serviceId), 300);
}

// Function to equalize card heights
function equalizeCardHeights() {
    document.querySelectorAll('.products-grid').forEach(grid => {
        const cards = grid.querySelectorAll('.pricing-card');
        if (cards.length === 0) return;
        
        // Reset heights first to allow natural expansion
        cards.forEach(card => {
            card.style.height = 'auto';
        });
        
        // Wait for layout to update
        setTimeout(() => {
            // Find the tallest card
            let maxHeight = 0;
            cards.forEach(card => {
                const height = card.offsetHeight;
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });
            
            // Set all cards to the same height only if there's a significant difference
            // This allows cards to expand naturally
            cards.forEach(card => {
                if (card.offsetHeight < maxHeight) {
                    card.style.height = maxHeight + 'px';
                }
            });
        }, 10);
    });
}

// Add scroll event listeners to all product wrappers when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Equalize card heights
    equalizeCardHeights();
    
    // Re-equalize when accordions open
    const observer = new MutationObserver(() => {
        setTimeout(equalizeCardHeights, 100);
    });
    
    document.querySelectorAll('.accordion-content').forEach(content => {
        observer.observe(content, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
    
    document.querySelectorAll('.products-scroll-wrapper').forEach(wrapper => {
        const serviceId = wrapper.id.replace('products-', '');
        wrapper.addEventListener('scroll', () => updateCarouselNav(serviceId));
        
        // Also check on resize
        window.addEventListener('resize', () => {
            const accordionContent = wrapper.closest('.accordion-content');
            if (accordionContent && accordionContent.classList.contains('active')) {
                updateCarouselNav(serviceId);
                equalizeCardHeights();
            }
        });
    });
});

// Testimonial carousel functions (global scope)
let testimonialCurrent = 0;
let testimonialMaxSlides = 1;
function prevTestimonial() {
    const track = document.getElementById('testimonialTrack');
    if (!track) return;
    const slides = Array.from(document.querySelectorAll('.testimonial-slide'));
    if (slides.length === 0) return;
    const slidesToShow = window.innerWidth <= 768 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
    testimonialMaxSlides = Math.max(1, slides.length - slidesToShow + 1);
    testimonialCurrent = (testimonialCurrent - 1 + testimonialMaxSlides) % testimonialMaxSlides;
    updateTestimonial();
}
function nextTestimonial() {
    const track = document.getElementById('testimonialTrack');
    if (!track) return;
    const slides = Array.from(document.querySelectorAll('.testimonial-slide'));
    if (slides.length === 0) return;
    const slidesToShow = window.innerWidth <= 768 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
    testimonialMaxSlides = Math.max(1, slides.length - slidesToShow + 1);
    testimonialCurrent = (testimonialCurrent + 1) % testimonialMaxSlides;
    updateTestimonial();
}
function goToTestimonial(idx) {
    testimonialCurrent = idx;
    updateTestimonial();
}
function updateTestimonial() {
    const track = document.getElementById('testimonialTrack');
    if (!track) return;
    const slides = Array.from(document.querySelectorAll('.testimonial-slide'));
    if (slides.length === 0) return;
    const slideWidth = slides[0].offsetWidth;
    track.style.transform = `translateX(${-testimonialCurrent * slideWidth}px)`;
    const indicators = Array.from(document.querySelectorAll('.testimonial-indicator'));
    indicators.forEach((el, idx) => el.classList.toggle('active', idx === testimonialCurrent));
}

// Toggle feature description (read more/less)
function toggleFeatureDesc(featureId) {
    const shortEl = document.getElementById(featureId + '-short');
    const fullEl = document.getElementById(featureId + '-full');
    
    if (shortEl && fullEl) {
        shortEl.classList.toggle('hidden');
        fullEl.classList.toggle('hidden');
        
        // Re-equalize card heights after toggle to allow card to expand
        setTimeout(() => {
            equalizeCardHeights();
        }, 50);
    }
}
</script>
@endsection
