<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['site_title'] ?? 'Daksa Company Profile' }}</title>
    <meta name="description" content="{{ $settings['site_description'] ?? 'Website Company Profile Daksa' }}">
    
    <!-- Favicon -->
    @if(isset($settings['favicon']) && $settings['favicon'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dynamic Theme CSS (only variables) -->
    <style>
        :root {
            --primary-color: {{ $settings['primary_color'] ?? '#D89B30' }};
            --secondary-color: {{ $settings['secondary_color'] ?? '#4B2E1A' }};
            --background-color: {{ $settings['background_color'] ?? '#F5F7FA' }};
        }
    </style>
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
            <svg viewBox="0 0 32 32" fill="currentColor" class="w-7 h-7">
                <path d="M19.11 17.39c-.27-.14-1.6-.79-1.85-.88-.25-.09-.43-.14-.62.14-.18.27-.71.88-.87 1.06-.16.18-.32.2-.59.07-.27-.14-1.13-.42-2.16-1.34-.8-.71-1.34-1.59-1.5-1.86-.16-.27-.02-.42.12-.56.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.14-.62-1.5-.85-2.05-.22-.53-.45-.46-.62-.46-.16 0-.34-.02-.52-.02-.18 0-.48.07-.73.34-.25.27-.96.94-.96 2.3 0 1.36.99 2.67 1.13 2.85.14.18 1.95 2.98 4.73 4.18.66.28 1.18.45 1.58.58.66.21 1.26.18 1.73.11.53-.08 1.6-.65 1.83-1.28.23-.64.23-1.19.16-1.3-.07-.11-.25-.18-.52-.32z"/>
                <path d="M26.89 5.11C24.1 2.31 20.66.85 17 .85 8.92.85 2.35 7.42 2.35 15.5c0 2.65.69 5.22 2 7.49L2 30l7.2-2.29c2.2 1.2 4.69 1.84 7.2 1.84 8.08 0 14.65-6.57 14.65-14.65 0-3.66-1.46-7.1-4.16-9.79zM17 27.46c-2.3 0-4.55-.62-6.52-1.79l-.47-.28-4.27 1.36 1.4-4.16-.3-.49c-1.23-1.97-1.88-4.25-1.88-6.6 0-6.93 5.64-12.57 12.57-12.57 3.36 0 6.52 1.31 8.9 3.69 2.38 2.38 3.69 5.54 3.69 8.9 0 6.93-5.64 12.57-12.57 12.57z"/>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <!-- AOS (Animate On Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS after DOM is ready and always enabled
        document.addEventListener('DOMContentLoaded', function () {
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
            }
        });
        window.addEventListener('load', function () {
            if (window.AOS) {
                AOS.refreshHard();
            }
        });
    </script>
</body>
</html>
