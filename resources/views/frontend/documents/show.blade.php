@extends('layouts.frontend')

@section('content')
<!-- Document HTML Viewer -->
<section class="min-h-screen bg-gray-50">
    <!-- Toolbar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-4 py-3">
                <!-- Left Side: Search and Tools -->
                <div class="flex flex-wrap items-center gap-3 flex-1">
                    <!-- Search -->
                    <div class="relative flex-1 min-w-[200px]">
                        <input type="text" 
                               id="searchInput" 
                               placeholder="Cari kata..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                        <div id="searchResults" class="hidden text-xs text-gray-500 mt-1">
                            <span id="currentMatch">0</span>/<span id="totalMatches">0</span>
                        </div>
                    </div>
                    
                    <!-- Search Navigation -->
                    <div class="flex items-center gap-1">
                        <button id="prevSearch" 
                                class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                title="Previous">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <button id="nextSearch" 
                                class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                title="Next">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Right Side: Actions -->
                <div class="flex flex-wrap items-center gap-2">
                    <!-- Font Size -->
                    <div class="flex items-center gap-2">
                        <button id="decreaseFont" 
                                class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg"
                                title="Kecilkan Font">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <span id="fontSizeDisplay" class="text-sm text-gray-700 min-w-[3rem] text-center">100%</span>
                        <button id="increaseFont" 
                                class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg"
                                title="Besarkan Font">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Download -->
                    @if($document->document_file)
                        <button onclick="openDownloadModal('{{ $document->id }}', '{{ $document->slug }}', '{{ addslashes($document->title) }}')" 
                                class="inline-flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium"
                                title="Download">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span class="hidden sm:inline">Download</span>
                        </button>
                    @endif
                    
                    <!-- Share -->
                    <button id="shareBtn" 
                            class="inline-flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium"
                            title="Share">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        <span class="hidden sm:inline">Share</span>
                    </button>
                    
                    <!-- Back Button -->
                    <a href="{{ route('documents.index') }}" 
                       class="inline-flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Document Header -->
    <div class="bg-primary py-8 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4">
                    @if($document->shouldShowAsNew())
                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-[10px] sm:text-xs font-bold bg-white text-black shadow-lg">
                            NEW
                        </span>
                    @endif
                    @if($document->document_type)
                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-lg text-[10px] sm:text-xs font-semibold bg-white/20 backdrop-blur-md text-white">
                            {{ $document->document_type }}
                        </span>
                    @endif
                </div>
                
                <!-- Title -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4">
                    {{ $document->title }}
                </h1>
                
                <!-- Document Info -->
                <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                    <!-- Date -->
                    <div class="flex items-center gap-1.5 bg-white/10 backdrop-blur-md px-3 py-2 rounded-lg border border-white/20">
                        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-[10px] text-white/70 font-medium">Tanggal</p>
                            <p class="font-bold text-white text-xs">{{ $document->published_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    @if($document->categories && count($document->categories) > 0)
                        <div class="flex items-center gap-1.5 bg-white/10 backdrop-blur-md px-3 py-2 rounded-lg border border-white/20">
                            <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <div>
                                <p class="text-[10px] text-white/70 font-medium">Kategori</p>
                                <p class="font-bold text-white text-xs">{{ implode(', ', $document->categories) }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($document->document_number)
                        <div class="flex items-center gap-1.5 bg-white/10 backdrop-blur-md px-3 py-2 rounded-lg border border-white/20">
                            <div>
                                <p class="text-[10px] text-white/70 font-medium">Nomor</p>
                                <p class="font-bold text-white text-xs">{{ $document->document_number }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Document Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- HTML Content with Scribd-like Preview Component -->
            @if($document->content_html)
                <x-document-preview 
                    :visibleHeight="'25%'"
                    :content="$document->content_html"
                    onCTAClick="openViewDocumentModal('{{ $document->id }}', '{{ $document->slug }}', '{{ addslashes($document->title) }}')"
                    ctaText="Lihat Dokumen"
                    promoText="Dokumen ini hanya tersedia dan bisa di download jika ada klik lihat dokumen"
                />
            @else
                <div class="bg-white rounded-lg shadow-sm p-6 sm:p-8 lg:p-12">
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-600 mb-4">Konten HTML belum tersedia.</p>
                        @if($document->description)
                            <div class="bg-gray-50 rounded-lg p-6 text-left">
                                <p class="text-gray-700 leading-relaxed">{{ $document->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            
            <!-- Related Documents -->
            @if($relatedDocuments->count() > 0)
                <div class="mt-12 sm:mt-16">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">Dokumen Terkait</h2>
                    <div class="space-y-4">
                        @foreach($relatedDocuments as $related)
                            <a href="{{ route('documents.show', $related->slug) }}" 
                               class="block bg-white hover:bg-gray-50 rounded-lg p-4 sm:p-6 transition shadow-sm">
                                <div class="flex items-start gap-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ $related->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $related->published_date->format('d M Y') }}</p>
                                    </div>
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
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
                    $waText = 'Halo, saya tertarik dengan layanan *' . $service->name . '* dari ' . ($settings['company_name'] ?? 'Daksa') . '. Mohon informasi lebih lanjut mengenai paket yang tersedia.';
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
            
            {{-- <!-- Additional Info -->
            <div class="mt-12 flex flex-wrap justify-center gap-8 text-white/80" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Respon Cepat</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Konsultasi Gratis</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-medium">Harga Terjangkau</span>
                </div>
            </div> --}}
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Font Size Control
    let currentFontSize = 100;
    const content = document.getElementById('documentContent');
    const fontSizeDisplay = document.getElementById('fontSizeDisplay');
    
    document.getElementById('increaseFont').addEventListener('click', function() {
        if (currentFontSize < 200) {
            currentFontSize += 10;
            content.style.fontSize = currentFontSize + '%';
            fontSizeDisplay.textContent = currentFontSize + '%';
            localStorage.setItem('documentFontSize', currentFontSize);
        }
    });
    
    document.getElementById('decreaseFont').addEventListener('click', function() {
        if (currentFontSize > 50) {
            currentFontSize -= 10;
            content.style.fontSize = currentFontSize + '%';
            fontSizeDisplay.textContent = currentFontSize + '%';
            localStorage.setItem('documentFontSize', currentFontSize);
        }
    });
    
    // Load saved font size
    const savedFontSize = localStorage.getItem('documentFontSize');
    if (savedFontSize) {
        currentFontSize = parseInt(savedFontSize);
        content.style.fontSize = currentFontSize + '%';
        fontSizeDisplay.textContent = currentFontSize + '%';
    }
    
    // Search Functionality
    let searchMatches = [];
    let currentMatchIndex = -1;
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const currentMatchSpan = document.getElementById('currentMatch');
    const totalMatchesSpan = document.getElementById('totalMatches');
    const prevBtn = document.getElementById('prevSearch');
    const nextBtn = document.getElementById('nextSearch');
    
    function highlightSearch(text) {
        if (!text) {
            // Remove all highlights
            const highlights = content.querySelectorAll('.search-highlight');
            highlights.forEach(el => {
                const parent = el.parentNode;
                parent.replaceChild(document.createTextNode(el.textContent), el);
                parent.normalize();
            });
            searchMatches = [];
            currentMatchIndex = -1;
            searchResults.classList.add('hidden');
            return;
        }
        
        // Remove previous highlights
        const previousHighlights = content.querySelectorAll('.search-highlight');
        previousHighlights.forEach(el => {
            const parent = el.parentNode;
            parent.replaceChild(document.createTextNode(el.textContent), el);
            parent.normalize();
        });
        
        // Find all matches
        const walker = document.createTreeWalker(
            content,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );
        
        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }
        
        searchMatches = [];
        const regex = new RegExp(text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'gi');
        
        textNodes.forEach(textNode => {
            const matches = [...textNode.textContent.matchAll(regex)];
            matches.forEach(match => {
                searchMatches.push({
                    node: textNode,
                    index: match.index,
                    length: match[0].length
                });
            });
        });
        
        // Highlight matches
        searchMatches.forEach((match, index) => {
            const range = document.createRange();
            range.setStart(match.node, match.index);
            range.setEnd(match.node, match.index + match.length);
            
            const highlight = document.createElement('mark');
            highlight.className = 'search-highlight bg-yellow-300';
            if (index === 0) {
                highlight.classList.add('current-match', 'bg-yellow-400');
            }
            
            try {
                range.surroundContents(highlight);
            } catch (e) {
                // If surroundContents fails, try a different approach
                const contents = range.extractContents();
                highlight.appendChild(contents);
                range.insertNode(highlight);
            }
        });
        
        // Update UI
        if (searchMatches.length > 0) {
            currentMatchIndex = 0;
            scrollToMatch(0);
            searchResults.classList.remove('hidden');
            totalMatchesSpan.textContent = searchMatches.length;
            updateMatchDisplay();
        } else {
            searchResults.classList.add('hidden');
            currentMatchIndex = -1;
        }
    }
    
    function scrollToMatch(index) {
        if (index < 0 || index >= searchMatches.length) return;
        
        const highlights = content.querySelectorAll('.search-highlight');
        if (highlights[index]) {
            // Remove current-match class from all
            highlights.forEach(h => h.classList.remove('current-match', 'bg-yellow-400'));
            highlights.forEach(h => h.classList.add('bg-yellow-300'));
            
            // Add to current
            highlights[index].classList.add('current-match', 'bg-yellow-400');
            highlights[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    function updateMatchDisplay() {
        if (currentMatchIndex >= 0 && currentMatchIndex < searchMatches.length) {
            currentMatchSpan.textContent = currentMatchIndex + 1;
            prevBtn.disabled = currentMatchIndex === 0;
            nextBtn.disabled = currentMatchIndex === searchMatches.length - 1;
        } else {
            prevBtn.disabled = true;
            nextBtn.disabled = true;
        }
    }
    
    searchInput.addEventListener('input', function() {
        highlightSearch(this.value);
    });
    
    prevBtn.addEventListener('click', function() {
        if (currentMatchIndex > 0) {
            currentMatchIndex--;
            scrollToMatch(currentMatchIndex);
            updateMatchDisplay();
        }
    });
    
    nextBtn.addEventListener('click', function() {
        if (currentMatchIndex < searchMatches.length - 1) {
            currentMatchIndex++;
            scrollToMatch(currentMatchIndex);
            updateMatchDisplay();
        }
    });
    
    // Share Functionality
    document.getElementById('shareBtn').addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $document->title }}',
                text: '{{ $document->description }}',
                url: window.location.href
            }).catch(err => console.log('Error sharing', err));
        } else {
            // Fallback: Copy to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link berhasil disalin ke clipboard!');
            });
        }
    });
    
    // Blur removal function
    function removeBlur() {
        // Find document preview wrapper (new component)
        const wrapper = document.querySelector('.document-preview-wrapper');
        
        if (wrapper) {
            // Remove blur from blurred content
            const blurredContent = wrapper.querySelector('.document-preview-blurred');
            if (blurredContent) {
                blurredContent.style.display = 'none';
            }
            
            // Hide overlay
            const overlay = wrapper.querySelector('.document-preview-overlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
            
            // Show full content in visible area
            const visibleContent = wrapper.querySelector('.document-preview-visible');
            if (visibleContent) {
                visibleContent.style.maxHeight = 'none';
                visibleContent.style.overflow = 'visible';
            }
        } else {
            // Fallback for old structure (if any)
            const oldWrapper = document.getElementById('documentContentWrapper');
            const oldContent = document.getElementById('documentContent');
            const oldOverlay = document.getElementById('blurOverlay');
            
            if (oldContent) {
                oldContent.classList.remove('blurred');
                oldContent.style.filter = 'none';
                oldContent.style.opacity = '1';
            }
            
            if (oldOverlay) {
                oldOverlay.style.display = 'none';
            }
        }
        
        // Store in localStorage that user has viewed
        localStorage.setItem('document_viewed_{{ $document->id }}', 'true');
    }
    
    // Open view document modal
    function openViewDocumentModal(documentId, slug, title) {
        document.getElementById('viewDocumentModal').classList.remove('hidden');
        document.getElementById('viewDocumentId').value = documentId;
        document.getElementById('viewDocumentForm').action = '{{ route("documents.view", ":slug") }}'.replace(':slug', slug);
        document.getElementById('viewModalTitle').textContent = 'Lihat Dokumen: ' + title;
        document.body.style.overflow = 'hidden';
        
        // Reset form
        document.getElementById('viewDocumentForm').reset();
        document.querySelectorAll('[id^="view_error_"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        
        // Remove error classes
        document.querySelectorAll('#viewDocumentForm input').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }
    
    function closeViewDocumentModal() {
        document.getElementById('viewDocumentModal').classList.add('hidden');
        document.body.style.overflow = '';
        
        // Reset form
        document.getElementById('viewDocumentForm').reset();
        document.querySelectorAll('[id^="view_error_"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        
        // Remove error classes
        document.querySelectorAll('#viewDocumentForm input').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }
    
    // Check if user has already viewed this document
    if (localStorage.getItem('document_viewed_{{ $document->id }}') === 'true') {
        removeBlur();
    }
</script>
@endpush

<!-- View Document Modal -->
<div id="viewDocumentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="viewModalBackdrop" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeViewDocumentModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="viewDocumentForm" method="POST">
                @csrf
                <input type="hidden" id="viewDocumentId" name="document_id" value="">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="viewModalTitle">
                                Lihat Dokumen
                            </h3>
                            
                            <p class="text-sm text-gray-500 mb-6 text-left">
                                Silakan lengkapi data di bawah ini untuk melihat dokumen.
                            </p>
                            
                            <div class="space-y-4">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="view_nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1 text-left">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="view_nama_lengkap" 
                                           name="nama_lengkap" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="Masukkan nama lengkap">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="view_error_nama_lengkap"></p>
                                </div>
                                
                                <!-- Email -->
                                <div>
                                    <label for="view_email" class="block text-sm font-medium text-gray-700 mb-1 text-left">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="view_email" 
                                           name="email" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="nama@example.com">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="view_error_email"></p>
                                </div>
                                
                                <!-- No Telpon -->
                                <div>
                                    <label for="view_no_telpon" class="block text-sm font-medium text-gray-700 mb-1 text-left">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           id="view_no_telpon" 
                                           name="no_telpon" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="081234567890">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="view_error_no_telpon"></p>
                                </div>
                                
                                <!-- Nama Perusahaan -->
                                <div>
                                    <label for="view_nama_perusahaan" class="block text-sm font-medium text-gray-700 mb-1 text-left">
                                        Nama Perusahaan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="view_nama_perusahaan" 
                                           name="nama_perusahaan" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="Masukkan nama perusahaan">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="view_error_nama_perusahaan"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            id="viewDocumentSubmitBtn"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Lihat Dokumen
                    </button>
                    <button type="button" 
                            onclick="closeViewDocumentModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Download Modal -->
<div id="downloadModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="modalBackdrop" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeDownloadModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="downloadForm" method="POST">
                @csrf
                <input type="hidden" id="downloadDocumentId" name="document_id" value="">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modalTitle">
                                Download Dokumen
                            </h3>
                            
                            <p class="text-sm text-gray-500 mb-6">
                                Silakan lengkapi data di bawah ini untuk mengunduh dokumen.
                            </p>
                            
                            <div class="space-y-4">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="nama_lengkap" 
                                           name="nama_lengkap" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="Masukkan nama lengkap">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="error_nama_lengkap"></p>
                                </div>
                                
                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="nama@example.com">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="error_email"></p>
                                </div>
                                
                                <!-- No Telpon -->
                                <div>
                                    <label for="no_telpon" class="block text-sm font-medium text-gray-700 mb-1">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           id="no_telpon" 
                                           name="no_telpon" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="081234567890">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="error_no_telpon"></p>
                                </div>
                                
                                <!-- Nama Perusahaan -->
                                <div>
                                    <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Perusahaan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="nama_perusahaan" 
                                           name="nama_perusahaan" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           placeholder="Masukkan nama perusahaan">
                                    <p class="mt-1 text-xs text-red-600 hidden" id="error_nama_perusahaan"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            id="downloadSubmitBtn"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                        Download
                    </button>
                    <button type="button" 
                            onclick="closeDownloadModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openDownloadModal(documentId, slug, title) {
        document.getElementById('downloadModal').classList.remove('hidden');
        document.getElementById('downloadDocumentId').value = documentId;
        document.getElementById('downloadForm').action = '{{ route("documents.download-pdf", ":slug") }}'.replace(':slug', slug);
        document.getElementById('modalTitle').textContent = 'Download: ' + title;
        document.body.style.overflow = 'hidden';
        
        // Reset form
        document.getElementById('downloadForm').reset();
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        
        // Remove error classes
        document.querySelectorAll('#downloadForm input').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }
    
    function closeDownloadModal() {
        document.getElementById('downloadModal').classList.add('hidden');
        document.body.style.overflow = '';
        
        // Reset form
        document.getElementById('downloadForm').reset();
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        
        // Remove error classes
        document.querySelectorAll('#downloadForm input').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }
    
    // Handle form submission
    document.getElementById('downloadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('downloadSubmitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
        
        // Clear previous errors
        document.querySelectorAll('[id^="error_"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        
        document.querySelectorAll('#downloadForm input').forEach(el => {
            el.classList.remove('border-red-500');
        });
        
        // Submit form
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.blob().then(blob => {
                    // Create download link
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = formData.get('nama_lengkap') + '_' + new Date().getTime() + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    
                    // Close modal and show success
                    closeDownloadModal();
                    alert('Dokumen berhasil diunduh!');
                });
            } else {
                return response.json().then(data => {
                    throw data;
                });
            }
        })
        .catch(error => {
            if (error.errors) {
                // Show validation errors
                Object.keys(error.errors).forEach(field => {
                    const errorElement = document.getElementById('error_' + field);
                    const inputElement = document.getElementById(field);
                    
                    if (errorElement && inputElement) {
                        errorElement.textContent = error.errors[field][0];
                        errorElement.classList.remove('hidden');
                        inputElement.classList.add('border-red-500');
                    }
                });
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDownloadModal();
            closeViewDocumentModal();
        }
    });
    
    // Handle view document form submission
    document.getElementById('viewDocumentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('viewDocumentSubmitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
        
        // Clear previous errors
        document.querySelectorAll('[id^="view_error_"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        
        document.querySelectorAll('#viewDocumentForm input').forEach(el => {
            el.classList.remove('border-red-500');
        });
        
        // Submit form
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/pdf'
            }
        })
        .then(response => {
            if (response.ok && response.headers.get('content-type')?.includes('application/pdf')) {
                // Download PDF file
                return response.blob().then(blob => {
                    // Create download link
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = formData.get('nama_lengkap') + '_' + new Date().getTime() + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    
                    // Close modal and show success
                    closeViewDocumentModal();
                    alert('Dokumen berhasil diunduh!');
                });
            } else if (response.status === 422) {
                // Validation errors
                return response.json().then(data => {
                    throw data;
                });
            } else {
                throw new Error('Terjadi kesalahan saat mengunduh dokumen.');
            }
        })
        .catch(error => {
            if (error.errors) {
                // Show validation errors
                Object.keys(error.errors).forEach(field => {
                    const errorElement = document.getElementById('view_error_' + field);
                    const inputElement = document.getElementById('view_' + field);
                    
                    if (errorElement && inputElement) {
                        errorElement.textContent = error.errors[field][0];
                        errorElement.classList.remove('hidden');
                        inputElement.classList.add('border-red-500');
                    }
                });
            } else {
                alert(error.message || 'Terjadi kesalahan. Silakan coba lagi.');
            }
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>
@endpush
@endsection
