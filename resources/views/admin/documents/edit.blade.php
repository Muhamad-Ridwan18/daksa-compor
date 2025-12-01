@extends('layouts.admin')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
        
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Dokumen *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $document->title) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="document_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Dokumen</label>
                <input type="text" id="document_number" name="document_number" value="{{ old('document_number', $document->document_number) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('document_number') border-red-500 @enderror"
                       placeholder="Contoh: 26/MK/EF.2/2025">
                @error('document_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror">{{ old('description', $document->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan (Opsional)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $document->excerpt) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Ringkasan singkat yang akan ditampilkan di halaman daftar dokumen.</p>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="published_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi *</label>
                    <input type="date" id="published_date" name="published_date" value="{{ old('published_date', $document->published_date->format('Y-m-d')) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('published_date') border-red-500 @enderror">
                    @error('published_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Dokumen</label>
                    <input type="text" id="document_type" name="document_type" value="{{ old('document_type', $document->document_type) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('document_type') border-red-500 @enderror"
                           placeholder="Contoh: Keputusan, Peraturan, Surat Edaran">
                    @error('document_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Sumber</label>
                <input type="text" id="source" name="source" value="{{ old('source', $document->source) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('source') border-red-500 @enderror"
                       placeholder="Contoh: Kementerian Keuangan">
                @error('source')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $commonCategories = ['PPh', 'PPN', 'Lainnya'];
                        $oldCategories = old('categories', $document->categories ?? []);
                    @endphp
                    @foreach($commonCategories as $category)
                        <label class="flex items-center">
                            <input type="checkbox" name="categories[]" value="{{ $category }}" 
                                   {{ in_array($category, $oldCategories) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">{{ $category }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="mt-2 text-sm text-gray-500">Pilih kategori yang sesuai dengan dokumen.</p>
            </div>

            <!-- Content Source Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Sumber Konten Dokumen</label>
                <div class="flex gap-4 mb-4">
                    <label class="flex items-center">
                        <input type="radio" name="content_source" value="pdf" id="content_source_pdf" 
                               {{ old('content_source', $document->document_file ? 'pdf' : 'manual') === 'pdf' ? 'checked' : '' }}
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300"
                               onchange="toggleContentSource()">
                        <span class="ml-2 text-sm text-gray-700">Upload PDF (Otomatis Extract)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="content_source" value="manual" id="content_source_manual"
                               {{ old('content_source', $document->document_file ? 'pdf' : 'manual') === 'manual' ? 'checked' : '' }}
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300"
                               onchange="toggleContentSource()">
                        <span class="ml-2 text-sm text-gray-700">Input Manual HTML</span>
                    </label>
                </div>
            </div>

            <!-- PDF Upload Section -->
            <div id="pdf_upload_section" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="document_file" class="block text-sm font-medium text-gray-700 mb-2">File PDF</label>
                        @if($document->document_file)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-700 mb-2">File saat ini:</p>
                                <a href="{{ asset('storage/' . $document->document_file) }}" target="_blank" 
                                   class="text-primary hover:underline text-sm">
                                    {{ basename($document->document_file) }}
                                </a>
                            </div>
                        @endif
                        <input type="file" id="document_file" name="document_file" accept=".pdf"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('document_file') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Format: PDF. Maksimal 10MB. Kosongkan jika tidak ingin mengubah file.</p>
                        @error('document_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="document_url" class="block text-sm font-medium text-gray-700 mb-2">URL Dokumen (Alternatif)</label>
                        <input type="url" id="document_url" name="document_url" value="{{ old('document_url', $document->document_url) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('document_url') border-red-500 @enderror"
                               placeholder="https://example.com/document.pdf">
                        <p class="mt-1 text-sm text-gray-500">Gunakan jika dokumen di-host di tempat lain.</p>
                        @error('document_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Manual HTML Input Section -->
            <div id="manual_html_section" class="hidden">
                <div>
                    <label for="content_html" class="block text-sm font-medium text-gray-700 mb-2">Konten HTML Dokumen</label>
                    <div class="mb-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800 font-semibold mb-1">💡 Tips Menggunakan Editor:</p>
                        <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                            <li><strong>List Berangka (1, 2, 3):</strong> Klik tombol <strong>"Ordered List"</strong> (ikon dengan angka 1, 2, 3) di toolbar</li>
                            <li><strong>List Bullet (•):</strong> Klik tombol <strong>"Unordered List"</strong> (ikon dengan titik-titik) di toolbar</li>
                            <li>Tombol list berada di grup <strong>"Paragraph"</strong> di toolbar editor</li>
                            <li>Untuk membuat sub-list, tekan <strong>Tab</strong> setelah membuat list item</li>
                        </ul>
                    </div>
                    <textarea id="content_html" name="content_html" rows="20"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('content_html') border-red-500 @enderror">{{ old('content_html', $document->content_html) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Input konten dokumen dalam format HTML. Gunakan editor di bawah untuk memformat teks.</p>
                    @error('content_html')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="checkbox" id="is_new" name="is_new" value="1" {{ old('is_new', $document->is_new) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="is_new" class="ml-2 block text-sm text-gray-900">
                        Tandai sebagai dokumen baru
                    </label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $document->is_published) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                        Publikasikan dokumen
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.documents.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-300 font-medium">
                    Update Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
    /* Ensure Summernote toolbar buttons are visible */
    .note-toolbar {
        background: #f8f9fa !important;
        border-bottom: 1px solid #dee2e6 !important;
    }
    .note-btn-group button {
        padding: 5px 10px !important;
    }
    /* Ensure lists are displayed correctly in Summernote editor */
    .note-editable ul,
    .note-editable ol {
        list-style-position: outside !important;
        margin-left: 1.5rem !important;
        margin-bottom: 1rem !important;
        padding-left: 1.5rem !important;
    }
    .note-editable ul {
        list-style-type: disc !important;
    }
    .note-editable ol {
        list-style-type: decimal !important;
    }
    .note-editable li {
        display: list-item !important;
        margin-bottom: 0.5rem !important;
    }
    .note-editable ul li,
    .note-editable ol li {
        padding-left: 0.5rem !important;
    }
    /* Nested lists */
    .note-editable ul ul,
    .note-editable ol ol,
    .note-editable ul ol,
    .note-editable ol ul {
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    /* Responsive editor list styling */
    @media (max-width: 640px) {
        .note-editable ul,
        .note-editable ol {
            margin-left: 1rem !important;
            padding-left: 1rem !important;
        }
        .note-editable li {
            padding-left: 0.75rem !important;
        }
        .note-editable li > ul,
        .note-editable li > ol {
            padding-left: 1rem !important;
        }
    }
</style>

<script>
    function toggleContentSource() {
        const pdfSection = document.getElementById('pdf_upload_section');
        const manualSection = document.getElementById('manual_html_section');
        const pdfRadio = document.getElementById('content_source_pdf');
        const manualRadio = document.getElementById('content_source_manual');
        
        if (pdfRadio.checked) {
            pdfSection.classList.remove('hidden');
            manualSection.classList.add('hidden');
            document.getElementById('document_file').required = false;
            document.getElementById('content_html').required = false;
            // Destroy Summernote if initialized
            if ($('#content_html').next('.note-editor').length) {
                $('#content_html').summernote('destroy');
            }
        } else if (manualRadio.checked) {
            pdfSection.classList.add('hidden');
            manualSection.classList.remove('hidden');
            document.getElementById('document_file').required = false;
            document.getElementById('content_html').required = true;
            // Initialize Summernote if not already initialized
            if (!$('#content_html').next('.note-editor').length) {
                $('#content_html').summernote({
                    height: 500,
                    toolbar: [
                        ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['misc', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                    ],
                    placeholder: 'Masukkan konten dokumen di sini...',
                    dialogsInBody: true,
                    disableDragAndDrop: false,
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                        ]
                    },
                    callbacks: {}
                });
            }
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleContentSource();
        // If manual is selected, initialize Summernote
        if (document.getElementById('content_source_manual').checked) {
            $('#content_html').summernote({
                height: 500,
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['misc', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                placeholder: 'Masukkan konten dokumen di sini...',
                dialogsInBody: true,
                disableDragAndDrop: false,
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                    ]
                },
                callbacks: {}
            });
        }
    });
</script>
@endsection

