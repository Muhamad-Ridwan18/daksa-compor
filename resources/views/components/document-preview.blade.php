@props([
    'visibleHeight' => '30%', // Tinggi bagian yang terlihat (bisa dalam % atau px)
    'content' => '', // Konten HTML dokumen
    'onCTAClick' => '', // JavaScript function untuk CTA button
    'ctaText' => 'Lihat Dokumen', // Teks tombol CTA
    'promoText' => 'Dokumen ini hanya tersedia dan bisa di download jika ada klik lihat dokumen', // Teks promo
    'illustration' => null, // Path ke gambar ilustrasi (optional)
])

@php
    // Convert visibleHeight to pixels if percentage
    $visibleHeightPx = is_numeric($visibleHeight) ? $visibleHeight . 'px' : $visibleHeight;
    if (strpos($visibleHeight, '%') !== false) {
        // For percentage, we'll use CSS calc or viewport units
        $visibleHeightPx = $visibleHeight;
    }
@endphp

<div class="document-preview-wrapper relative bg-white rounded-lg shadow-sm overflow-hidden">
    <style>
        .document-preview-wrapper {
            position: relative;
            min-height: 600px;
        }
        
        /* Bagian konten yang terlihat */
        .document-preview-visible {
            position: relative;
            z-index: 1;
            overflow: hidden;
            background: white;
        }
        
        /* Bagian konten yang di-blur - DITUTUPI OLEH OVERLAY */
        .document-preview-blurred {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            filter: blur(20px) brightness(0.7);
            opacity: 0.25;
            user-select: none;
            pointer-events: none;
            z-index: 2;
        }
        
        /* Overlay yang menutupi bagian blur */
        .document-preview-overlay {
            position: absolute;
            top: {{ $visibleHeightPx }};
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 10;
            background: white;
            pointer-events: auto;
        }
        
        /* Gradient fade di bagian atas overlay untuk transisi smooth */
        .document-preview-overlay::before {
            content: '';
            position: absolute;
            top: -30px;
            left: 0;
            right: 0;
            height: 30px;
            background: linear-gradient(to bottom, 
                transparent 0%,
                rgba(255,255,255,0.5) 50%,
                rgba(255,255,255,0.9) 100%
            );
            pointer-events: none;
        }
        
        /* Prevent text selection and inspection */
        .document-preview-blurred,
        .document-preview-overlay {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
        }
        
        /* Hide content from screen readers in blurred area */
        .document-preview-blurred {
            aria-hidden: true;
        }
    </style>
    
    <!-- Bagian konten yang terlihat (atas) -->
    <div class="document-preview-visible prose prose-lg max-w-none p-6 sm:p-8 lg:p-12" 
         style="max-height: {{ $visibleHeightPx }}; overflow: hidden; position: relative; z-index: 1;">
        {!! $content !!}
    </div>
    
    <!-- Bagian konten yang di-blur (seluruh konten) - DITUTUPI OLEH OVERLAY -->
    <div class="document-preview-blurred prose prose-lg max-w-none p-6 sm:p-8 lg:p-12">
        {!! $content !!}
    </div>
    
    <!-- Overlay dengan ilustrasi dan CTA -->
    <div class="document-preview-overlay w-full">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col items-center gap-8">
                    <!-- Ilustrasi di atas -->
                    <div class="w-full flex items-center justify-center">
                        @if($illustration)
                            <img src="{{ $illustration }}" 
                                 alt="Document Preview" 
                                 class="w-full max-w-md h-auto object-contain">
                        @else
                            <!-- Placeholder ilustrasi -->
                            <div class="w-full max-w-md aspect-square bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl flex items-center justify-center p-8">
                                <svg class="w-full h-full text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Teks promo dan CTA di bawah -->
                    <div class="w-full text-center">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
                                    Akses Dokumen Lengkap
                                </h3>
                                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                                    {{ $promoText }}
                                </p>
                            </div>
                            
                            <!-- Tombol CTA -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button onclick="{{ $onCTAClick }}" 
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-opacity-90 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $ctaText }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional security: Block any attempts to inspect or copy -->
    <div class="document-preview-overlay-block absolute inset-0 z-20 pointer-events-none" 
         style="display: none;">
    </div>
</div>

<script>
    // Additional security measures
    (function() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSecurity);
        } else {
            initSecurity();
        }
        
        function initSecurity() {
            const wrappers = document.querySelectorAll('.document-preview-wrapper');
            wrappers.forEach(function(wrapper) {
                // Prevent right-click context menu
                wrapper.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Prevent common keyboard shortcuts
                wrapper.addEventListener('keydown', function(e) {
                    // Ctrl+U (View Source), Ctrl+S (Save), Ctrl+Shift+I (DevTools), F12
                    if ((e.ctrlKey || e.metaKey) && 
                        (e.key === 'u' || e.key === 'U' || 
                         e.key === 's' || e.key === 'S' ||
                         e.key === 'i' || e.key === 'I')) {
                        e.preventDefault();
                        return false;
                    }
                    if (e.key === 'F12') {
                        e.preventDefault();
                        return false;
                    }
                });
                
                // Prevent text selection in blurred area
                const blurredArea = wrapper.querySelector('.document-preview-blurred');
                if (blurredArea) {
                    blurredArea.addEventListener('selectstart', function(e) {
                        e.preventDefault();
                        return false;
                    });
                    
                    // Prevent drag
                    blurredArea.addEventListener('dragstart', function(e) {
                        e.preventDefault();
                        return false;
                    });
                }
            });
        }
    })();
</script>

