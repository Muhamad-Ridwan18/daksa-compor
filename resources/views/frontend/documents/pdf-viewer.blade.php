@extends('layouts.frontend')

@section('content')
<!-- PDF Viewer Section -->
<section class="min-h-screen bg-gray-100 py-4 sm:py-6 lg:py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 mb-2">{{ $document->title }}</h1>
                    <p class="text-sm text-gray-600">{{ $document->published_date->format('d M Y') }}</p>
                </div>
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('documents.show', $document->slug) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    @if($document->document_file)
                        <a href="{{ route('documents.download-pdf', $document->slug) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-opacity-90 text-white font-semibold rounded-lg transition shadow-lg text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- PDF Viewer Container -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="w-full" style="height: calc(100vh - 200px); min-height: 600px;">
                @if($document->document_file)
                    <iframe src="{{ asset('storage/' . $document->document_file) }}#toolbar=1" 
                            class="w-full h-full border-0"
                            type="application/pdf">
                        <p class="p-8 text-center text-gray-600">
                            Browser Anda tidak mendukung PDF viewer. 
                            <a href="{{ route('documents.download-pdf', $document->slug) }}" 
                               class="text-primary hover:underline font-semibold">
                                Klik di sini untuk mengunduh PDF
                            </a>
                        </p>
                    </iframe>
                @elseif($document->document_url)
                    <iframe src="{{ $document->document_url }}#toolbar=1" 
                            class="w-full h-full border-0"
                            type="application/pdf">
                        <p class="p-8 text-center text-gray-600">
                            Browser Anda tidak mendukung PDF viewer. 
                            <a href="{{ $document->document_url }}" 
                               target="_blank"
                               class="text-primary hover:underline font-semibold">
                                Klik di sini untuk membuka PDF di tab baru
                            </a>
                        </p>
                    </iframe>
                @else
                    <div class="flex items-center justify-center h-full p-8">
                        <div class="text-center">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600 text-lg font-semibold mb-2">Dokumen tidak tersedia</p>
                            <p class="text-gray-500">File PDF belum diunggah untuk dokumen ini.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Fallback for browsers that don't support PDF in iframe
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.querySelector('iframe[type="application/pdf"]');
        if (iframe) {
            iframe.onerror = function() {
                const container = iframe.parentElement;
                container.innerHTML = `
                    <div class="flex items-center justify-center h-full p-8">
                        <div class="text-center">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600 text-lg font-semibold mb-2">Tidak dapat memuat PDF</p>
                            <p class="text-gray-500 mb-4">Silakan unduh file untuk melihat dokumen.</p>
                            @if($document->document_file)
                                <a href="{{ route('documents.download-pdf', $document->slug) }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-opacity-90 text-white font-semibold rounded-lg transition shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download PDF
                                </a>
                            @endif
                        </div>
                    </div>
                `;
            };
        }
    });
</script>
@endpush
@endsection

