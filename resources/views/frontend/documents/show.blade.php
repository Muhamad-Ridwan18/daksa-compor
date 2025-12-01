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
                        <a href="{{ route('documents.download-pdf', $document->slug) }}" 
                           class="inline-flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg text-sm font-medium"
                           title="Download">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span class="hidden sm:inline">Download</span>
                        </a>
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
            <!-- HTML Content -->
            <div id="documentContent" class="bg-white rounded-lg shadow-sm p-6 sm:p-8 lg:p-12 prose prose-lg max-w-none">
                <style>
                    /* Text alignment */
                    #documentContent p.text-center {
                        text-align: center !important;
                    }
                    #documentContent p.text-right {
                        text-align: right !important;
                    }
                    #documentContent h2.text-center {
                        text-align: center !important;
                    }
                    #documentContent h2.text-right {
                        text-align: right !important;
                    }
                    /* List styling - Ensure lists are displayed correctly */
                    #documentContent ul,
                    #documentContent ol {
                        list-style-position: outside !important;
                        margin-top: 1.25rem !important;
                        margin-bottom: 1.25rem !important;
                        margin-left: 1.5rem !important;
                        padding-left: 1.5rem !important;
                    }
                    #documentContent ul {
                        list-style-type: disc !important;
                    }
                    #documentContent ol {
                        list-style-type: decimal !important;
                    }
                    #documentContent li {
                        display: list-item !important;
                        margin-top: 0.5rem !important;
                        margin-bottom: 0.5rem !important;
                        padding-left: 0.5rem !important;
                        line-height: 1.75 !important;
                    }
                    /* Nested lists */
                    #documentContent li > ul,
                    #documentContent li > ol {
                        margin-top: 0.5rem !important;
                        margin-bottom: 0.5rem !important;
                        padding-left: 1.5rem !important;
                    }
                    #documentContent ul ul {
                        list-style-type: circle !important;
                    }
                    #documentContent ul ul ul {
                        list-style-type: square !important;
                    }
                    #documentContent ol ol {
                        list-style-type: lower-alpha !important;
                    }
                    #documentContent ol ol ol {
                        list-style-type: lower-roman !important;
                    }
                    
                    /* Responsive list styling */
                    @media (max-width: 640px) {
                        #documentContent ul,
                        #documentContent ol {
                            margin-left: 1rem !important;
                            padding-left: 1rem !important;
                            margin-top: 1rem !important;
                            margin-bottom: 1rem !important;
                        }
                        #documentContent li {
                            padding-left: 0.75rem !important;
                            font-size: 0.9rem !important;
                        }
                        #documentContent li > ul,
                        #documentContent li > ol {
                            padding-left: 1rem !important;
                        }
                    }
                    
                    @media (min-width: 641px) and (max-width: 1024px) {
                        #documentContent ul,
                        #documentContent ol {
                            margin-left: 1.25rem !important;
                            padding-left: 1.25rem !important;
                        }
                    }
                </style>
                @if($document->content_html)
                    {!! $document->content_html !!}
                @else
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
                @endif
            </div>
            
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
</script>
@endpush
@endsection
