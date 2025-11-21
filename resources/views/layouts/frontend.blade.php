<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Tags Component --}}
    @php
        $seoData = $seoData ?? [];
        // Add Organization schema for homepage if not already set
        if (empty($seoData['schema_json']) && request()->routeIs('home')) {
            $seoData['schema_json'] = \App\Services\SeoService::getOrganizationSchema($settings);
        }
    @endphp
    <x-seo-tags :seoData="$seoData" />
    
    <!-- Favicon -->
    @if(isset($settings['favicon']) && $settings['favicon'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['favicon']) }}">
    @endif

    <!-- Resource Hints for Performance -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    
    <!-- Preload critical hero image if available -->
    @if(isset($settings['hero_image_1']) && $settings['hero_image_1'])
        <link rel="preload" as="image" href="{{ Storage::url($settings['hero_image_1']) }}" fetchpriority="high">
    @endif
    
    <!-- Preload critical font files for faster text rendering -->
    <link rel="preload" href="https://fonts.bunny.net/css?family=inter:400,500&family=poppins:400,500,600,700&display=swap" as="style">
    
    <!-- Critical CSS Inline for Above-the-Fold Content --> 
    <style>
        /* Critical CSS for Hero Section - Inlined to avoid render blocking */
        :root {
            --primary-color: {{ $settings['primary_color'] ?? '#D89B30' }};
            --secondary-color: {{ $settings['secondary_color'] ?? '#4B2E1A' }};
            --background-color: {{ $settings['background_color'] ?? '#F5F7FA' }};
        }
        body { margin: 0; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .bg-background { background-color: var(--background-color); }
        #home { position: relative; min-height: 70vh; display: flex; align-items: center; }
        .hero-full-carousel { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5; }
        .hero-full-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; visibility: hidden; }
        .hero-full-slide.active { opacity: 1; visibility: visible; z-index: 2; }
        .hero-content { position: relative; z-index: 2; }
        .hero-slide-title { font-size: clamp(1.25rem, 3vw, 1.75rem); font-weight: 700; color: white; margin-bottom: 1.5rem; }
        .hero-slide-description { font-size: clamp(1.125rem, 2vw, 1.5rem); color: rgba(255, 255, 255, 0.9); margin-bottom: 2rem; }
        nav { background: white; position: sticky; top: 0; z-index: 50; }
        /* Prevent layout shift */
        img { max-width: 100%; height: auto; }
    </style>
    
    <!-- Note: Fonts are loaded via CSS @import for better performance -->
    
    <!-- AOS (Animate On Scroll) - Loaded asynchronously to avoid blocking render -->
    <link rel="preload" href="https://unpkg.com/aos@2.3.1/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>
    <script>
        // Polyfill for async CSS loading
        !function(e){"use strict";var t=function(t,n,o){var i,r=e.document,a=r.createElement("link");if(n)i=n;else{var l=(r.body||r.getElementsByTagName("head")[0]).childNodes;i=l[l.length-1]}var d=r.styleSheets;a.rel="stylesheet",a.href=t,a.media="only x",function e(t){if(r.body)return t();setTimeout(function(){e(t)})}(function(){i.parentNode.insertBefore(a,n?i:i.nextSibling)});var f=function(e){for(var t=a.href,n=d.length;n--;)if(d[n].href===t)return e();setTimeout(function(){f(e)})};return a.addEventListener&&a.addEventListener("load",function(){this.media=o||"all"}),a.onloadcssdefined=f,f(function(){a.media!==o&&(a.media=o||"all")}),a};"undefined"!=typeof exports?exports.loadCSS=t:e.loadCSS=t}("undefined"!=typeof global?global:this);
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Make non-critical CSS non-blocking (Vite CSS loads after critical CSS)
        // Critical CSS is already inlined above, so Vite CSS can load asynchronously
        (function() {
            const links = document.querySelectorAll('link[rel="stylesheet"]');
            links.forEach(link => {
                // Skip if already processed or is critical
                if (link.getAttribute('data-critical') || link.href.includes('fonts.bunny.net')) return;
                
                // For Vite CSS, make it load with lower priority
                if (link.href.includes('/build/assets/')) {
                    link.media = 'print';
                    link.onload = function() { 
                        this.media = 'all';
                        this.onload = null;
                    };
                    // Fallback for browsers without onload support
                    setTimeout(function() { 
                        if (link.media === 'print') link.media = 'all';
                    }, 100);
                }
            });
        })();
    </script>

    <!-- Dynamic Theme CSS moved to critical CSS above -->
</head>
<body class="font-sans antialiased bg-background">
    <!-- Navigation -->
    <nav class="bg-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 group">
                        @if(isset($settings['logo']) && $settings['logo'])
                            <img class="h-12 w-auto transition-transform duration-300 group-hover:scale-105" 
                                 src="{{ Storage::url($settings['logo']) }}" 
                                 alt="{{ $settings['company_name'] ?? 'Logo' }}">
                        @else
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                    <span class="text-white font-bold text-xl">{{ substr($settings['company_name'] ?? 'D', 0, 1) }}</span>
                                </div>
                                <span class="text-2xl font-bold text-primary group-hover:text-secondary transition-colors duration-300">
                                    {{ $settings['company_name'] ?? 'Daksa' }}
                                </span>
                            </div>
                        @endif
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#about" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Tentang
                    </a>
                    <a href="{{ route('home') }}#services" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Layanan
                    </a>
                    <a href="{{ route('home') }}#testimonials" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        Testimonial
                    </a>
                    <a href="{{ route('blog.index') }}" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('blog.*') ? 'text-primary bg-primary/10' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('gallery.index') }}" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('gallery.*') ? 'text-primary bg-primary/10' : '' }}">
                        Gallery
                    </a>
                    <a href="{{ route('careers.index') }}" 
                       class="text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('careers.*') ? 'text-primary bg-primary/10' : '' }}">
                        Karier
                    </a>
                    <a href="{{ route('home') }}#contact" 
                       class="bg-primary text-white hover:bg-opacity-90 px-6 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:shadow-lg ml-2">
                        Hubungi Kami
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('home') }}" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('home') }}#about" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300">
                    Tentang
                </a>
                <a href="{{ route('home') }}#services" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300">
                    Layanan
                </a>
                <a href="{{ route('home') }}#testimonials" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300">
                    Testimonial
                </a>
                <a href="{{ route('blog.index') }}" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('blog.*') ? 'text-primary bg-primary/10' : '' }}">
                    Blog
                </a>
                <a href="{{ route('gallery.index') }}" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('gallery.*') ? 'text-primary bg-primary/10' : '' }}">
                    Gallery
                </a>
                <a href="{{ route('careers.index') }}" 
                   class="block text-gray-700 hover:text-primary hover:bg-primary/5 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->routeIs('careers.*') ? 'text-primary bg-primary/10' : '' }}">
                    Karier
                </a>
                <a href="{{ route('home') }}#contact" 
                   class="block bg-primary text-white text-center hover:bg-opacity-90 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-300">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ $settings['company_name'] ?? 'Daksa' }}</h3>
                    <p class="text-gray-300">{{ $settings['company_description'] ?? 'Perusahaan terpercaya untuk solusi bisnis Anda.' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                    <p class="text-gray-300">{{ $settings['company_phone'] ?? '+62 123 456 789' }}</p>
                    <p class="text-gray-300">{{ $settings['company_email'] ?? 'info@daksa.com' }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Media Sosial</h3>
                    <div class="flex space-x-4">
                        @if($settings['facebook_url'] ?? null)
                            <a href="{{ $settings['facebook_url'] }}" class="text-gray-300 hover:text-white">Facebook</a>
                        @endif
                        @if($settings['instagram_url'] ?? null)
                            <a href="{{ $settings['instagram_url'] }}" class="text-gray-300 hover:text-white">Instagram</a>
                        @endif
                        @if($settings['linkedin_url'] ?? null)
                            <a href="{{ $settings['linkedin_url'] }}" class="text-gray-300 hover:text-white">LinkedIn</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-600 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} {{ $settings['company_name'] ?? 'Daksa' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    @php
        $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?: null;
        $waText = trim($settings['whatsapp_template'] ?? '');
        $waUrl = $waNumber ? ('https://wa.me/' . $waNumber . ($waText !== '' ? ('?text=' . urlencode($waText)) : '')) : null;
    @endphp
    @if($waUrl)
    <a href="{{ $waUrl }}" target="_blank" rel="noopener"
        class="fixed bottom-6 right-6 z-50 shadow-lg rounded-full p-0.5"
        aria-label="WhatsApp">
        <div class="bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center transition-transform duration-200 hover:scale-110">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </div>
    </a>
    @endif

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Navbar scroll effect
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
            
            lastScroll = currentScroll;
        });
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });
        
        // Fallback: add loaded class after 2 seconds
        setTimeout(function() {
            document.body.classList.add('loaded');
        }, 2000);
    </script>
    <!-- SweetAlert2 - Loaded asynchronously to avoid blocking parser -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script>
        // Flash messages via SweetAlert (if any set in session)
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({ icon: 'success', title: 'Berhasil', text: @json(session('success')), timer: 2000, showConfirmButton: false });
            @endif
            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
            @endif
        });

        // Global confirm for forms with attribute or delete forms
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const isDelete = !!form.querySelector('input[name="_method"][value="DELETE"]');
            const needsConfirm = form.matches('[data-confirm], .swal-confirm') || isDelete;
            if (!needsConfirm) return;
            e.preventDefault();
            const message = form.getAttribute('data-confirm') || (isDelete ? 'Apakah Anda yakin ingin menghapus data ini?' : 'Apakah Anda yakin?');
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Links that need confirm
        document.addEventListener('click', function(e) {
            const el = e.target.closest('[data-confirm-href]');
            if (!el) return;
            e.preventDefault();
            const href = el.getAttribute('href');
            const message = el.getAttribute('data-confirm-href') || 'Apakah Anda yakin?';
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed && href) {
                    window.location.href = href;
                }
            });
        });
    </script>

    <!-- AOS (Animate On Scroll) - Loaded asynchronously -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script>
        // Initialize AOS after DOM is ready and always enabled
        document.addEventListener('DOMContentLoaded', function () {
            // Wait for AOS to load if deferred
            function initAOS() {
                if (window.AOS) {
                    AOS.init({
                        duration: 800,
                        easing: 'ease-out',
                        once: true,
                        offset: 0,
                        delay: 0,
                        anchorPlacement: 'top-bottom',
                        startEvent: 'DOMContentLoaded',
                        disable: false
                    });
                    // Force a refresh shortly after to account for late-rendered images
                    setTimeout(function(){ try { AOS.refreshHard(); } catch(e){} }, 300);
                } else {
                    // Retry if AOS not loaded yet (deferred)
                    setTimeout(initAOS, 100);
                }
            }
            initAOS();
        });
        window.addEventListener('load', function () {
            if (window.AOS) {
                AOS.refreshHard();
            }
        });
    </script>
</body>
</html>
