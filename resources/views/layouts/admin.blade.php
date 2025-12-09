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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dynamic Theme CSS -->
    <style>
        :root {
            --primary-color: {{ \App\Models\Setting::getValue('primary_color', '#D89B30') }};
            --secondary-color: {{ \App\Models\Setting::getValue('secondary_color', '#4B2E1A') }};
            --background-color: {{ \App\Models\Setting::getValue('background_color', '#F5F7FA') }};
        }
        
        .bg-primary { background-color: var(--primary-color) !important; }
        .text-primary { color: var(--primary-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }
        .bg-secondary { background-color: var(--secondary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .bg-background { background-color: var(--background-color) !important; }
        
        /* Sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 loaded">
    <div class="flex relative min-h-screen">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar fixed md:static inset-y-0 left-0 z-30 w-64 bg-white shadow-lg md:shadow-lg overflow-y-auto h-screen md:h-auto">
            <div class="p-6 border-b border-gray-100">
                @php
                    $logo = \App\Models\Setting::getValue('logo');
                    $companyName = \App\Models\Setting::getValue('company_name', 'Daksa');
                @endphp
                
                @if($logo)
                    <div class="flex flex-col items-center">
                        <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-12 w-auto mb-2">
                        {{-- <span class="text-xs text-gray-600 font-medium">Admin Panel</span> --}}
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-lg">{{ substr($companyName, 0, 1) }}</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-primary">{{ $companyName }}</h2>
                            <span class="text-xs text-gray-600">Admin Panel</span>
                        </div>
                    </div>
                @endif
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.services.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.services.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Layanan
                </a>
                
                <a href="{{ route('admin.testimonials.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.testimonials.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Testimoni
                </a>
                
                <a href="{{ route('admin.clients.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.clients.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Klien
                </a>

                <a href="{{ route('admin.team-members.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.team-members.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Anggota Tim
                </a>
                
                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.articles.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Artikel
                </a>
                
                <a href="{{ route('admin.documents.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.documents.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Peraturan
                </a>
                
                <a href="{{ route('admin.document-downloads.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.document-downloads.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Tracking Downloads
                </a>
                
                <a href="{{ route('admin.galleries.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.galleries.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Gallery
                </a>
                
                <a href="{{ route('admin.jobs.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.jobs.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-7 8h8a2 2 0 002-2V9a2 2 0 00-2-2h-3V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h2" />
                    </svg>
                    Lowongan
                </a>

                <a href="{{ route('admin.job-applications.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.job-applications.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Lamaran
                </a>

                <a href="{{ route('admin.comments.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.comments.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    Komentar
                </a>
                
                <a href="{{ route('admin.contact-messages.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.contact-messages.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Pesan Kontak
                </a>
                
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.orders.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Pesanan
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    User
                </a>

                <!-- Kalkulator Pajak Section -->
                <div class="px-6 py-2 mt-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kalkulator Pajak</h3>
                </div>
                
                <a href="{{ route('admin.pph21-settings.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.pph21-settings.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    PPh 21 Settings
                </a>
                
                <a href="{{ route('admin.ter-tables.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.ter-tables.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Tabel TER
                </a>
                
                <a href="{{ route('admin.pph-badan-settings.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.pph-badan-settings.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    PPh Badan Settings
                </a>
                
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary {{ request()->routeIs('admin.settings.*') ? 'bg-primary text-white border-r-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full md:w-auto min-h-screen">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b sticky top-0 z-10 bg-white">
                <div class="flex items-center justify-between px-4 md:px-6 py-3 md:py-4">
                    <div class="flex items-center space-x-3">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="text-lg md:text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-2 md:space-x-4">
                        <a href="{{ route('home') }}" target="_blank" 
                           class="text-gray-600 hover:text-primary items-center hidden sm:flex">
                            <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            <span class="hidden sm:inline">Lihat Website</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600 flex items-center p-2 rounded-lg hover:bg-red-50 transition duration-200">
                                <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 overflow-x-hidden">
                @if(session('success'))
                    <div class="mb-4 md:mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 md:mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 md:mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('hidden');
        }
        
        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.add('hidden');
        }
        
        mobileMenuButton.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
        
        // Close sidebar when clicking a link (mobile)
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });
        
        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Flash messages via SweetAlert
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({ icon: 'success', title: 'Berhasil', text: @json(session('success')), timer: 2000, showConfirmButton: false });
            @endif
            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
            @endif
        });

        // Global confirm for forms and links
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

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
</body>
</html>
