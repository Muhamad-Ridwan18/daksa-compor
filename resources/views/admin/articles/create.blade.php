@extends('layouts.admin')

@section('title', 'Tambah Artikel')
@section('page-title', 'Tambah Artikel')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Artikel</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('title') border-red-500 @enderror">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan (Opsional)</label>
            <textarea id="excerpt" name="excerpt" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
            <p class="mt-1 text-sm text-gray-500">Ringkasan singkat artikel yang akan ditampilkan di halaman daftar artikel.</p>
            @error('excerpt')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Artikel</label>
            <textarea id="content" name="content" rows="20" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Unggulan</label>
            <input type="file" id="featured_image" name="featured_image" accept="image/*"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('featured_image') border-red-500 @enderror">
            <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
            @error('featured_image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                Publikasikan artikel
            </label>
        </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.articles.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-300 font-medium">
                    Simpan Artikel
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

<script>
    $(document).ready(function() {
        let isCleaning = false;
        let changeTimeout = null;
        
        // Clean improper nested list structure and remove unnecessary wrappers/styles
        function cleanNestedLists() {
            if (isCleaning) return;
            isCleaning = true;
            
            let content = $('#content').summernote('code');
            if (!content) {
                isCleaning = false;
                return;
            }
            
            let originalContent = content;
            
            // Remove pagelayer divs and unnecessary wrappers
            content = content.replace(/<div[^>]*pagelayer[^>]*>/gi, '');
            content = content.replace(/<\/div>\s*(<\/div>\s*)?(<\/div>\s*)?$/gi, '');
            content = content.replace(/<div[^>]*>\s*(<div[^>]*>\s*)?(<div[^>]*>)/gi, '');
            
            // Remove pagelayer classes and IDs
            content = content.replace(/\s*class="[^"]*pagelayer[^"]*"/gi, '');
            content = content.replace(/\s*pagelayer-id="[^"]*"/gi, '');
            
            // Remove all inline styles that contain Tailwind CSS variables or unnecessary styles
            content = content.replace(/style="[^"]*"/gi, function(match) {
                let styleContent = match.replace(/style="([^"]*)"/i, '$1');
                // Remove Tailwind CSS variables
                styleContent = styleContent.replace(/--tw-[^;"]*;?/gi, '');
                // Remove transition
                styleContent = styleContent.replace(/transition:\s*[^;"]*;?/gi, '');
                // Remove other unnecessary styles (keep only essential ones like font-family, font-size, text-align, etc.)
                styleContent = styleContent.replace(/width:\s*[^;"]*;?/gi, '');
                styleContent = styleContent.replace(/--[^;"]*;?/gi, '');
                // Clean up
                styleContent = styleContent.replace(/;\s*;/g, ';').trim();
                styleContent = styleContent.replace(/^;|;$/g, '');
                
                // If style is empty or only contains whitespace, remove the attribute
                if (!styleContent || styleContent.trim() === '') {
                    return '';
                }
                return 'style="' + styleContent + '"';
            });
            
            // Clean up empty style attributes
            content = content.replace(/\s*style="\s*"/gi, '');
            
            // Remove unnecessary div wrappers
            content = content.replace(/^<div[^>]*>\s*(<div[^>]*>\s*)?/gi, '');
            content = content.replace(/\s*<\/div>\s*(<\/div>\s*)?$/gi, '');
            
            // Remove <ol><li> at the beginning of content - unwrap the content
            // Pattern: <ol><li>content</li></ol> at start -> just content
            content = content.replace(/^<ol[^>]*>\s*<li[^>]*>(.*?)<\/li>\s*<\/ol>/is, '$1');
            
            // Also handle multiple <li> in <ol> at the beginning - unwrap all content
            if (/^<ol[^>]*>/i.test(content)) {
                const liMatches = content.match(/<li[^>]*>([\s\S]*?)<\/li>/gi);
                if (liMatches) {
                    let unwrappedContent = '';
                    liMatches.forEach(function(liTag) {
                        const liContent = liTag.replace(/<li[^>]*>|<\/li>/gi, '');
                        unwrappedContent += liContent.trim();
                    });
                    // Remove the <ol> wrapper and replace with unwrapped content
                    content = content.replace(/^<ol[^>]*>[\s\S]*?<\/ol>/i, unwrappedContent);
                }
            }
            
            // Remove ul > li > ol structure and replace with ol
            content = content.replace(/<ul[^>]*>\s*<li[^>]*>\s*(<ol[^>]*>[\s\S]*?<\/ol>)\s*<\/li>\s*<\/ul>/gi, '$1');
            
            // Also handle cases where ol is wrapped in ul > li with other content
            content = content.replace(/<ul[^>]*>\s*<li[^>]*>([^<]*)(<ol[^>]*>[\s\S]*?<\/ol>)\s*<\/li>\s*<\/ul>/gi, '$2');
            
            // Remove empty ul > li structures
            content = content.replace(/<ul[^>]*>\s*<li[^>]*>\s*<\/li>\s*<\/ul>/gi, '');
            
            // Clean up multiple consecutive divs
            content = content.replace(/<div[^>]*>\s*<div[^>]*>/gi, '');
            content = content.replace(/<\/div>\s*<\/div>/gi, '');
            
            // Only update if content changed
            if (content !== originalContent) {
                $('#content').summernote('code', content);
            }
            
            isCleaning = false;
        }
        
        $('#content').summernote({
            height: 400,
            minHeight: 300,
            maxHeight: 600,
            placeholder: 'Tulis konten artikel Anda di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                },
                onChange: function(contents, $editable) {
                    // Debounce cleaning to avoid interfering with toolbar
                    if (changeTimeout) {
                        clearTimeout(changeTimeout);
                    }
                    changeTimeout = setTimeout(function() {
                        cleanNestedLists();
                    }, 500);
                },
                onBlur: function() {
                    // Clean when editor loses focus
                    if (changeTimeout) {
                        clearTimeout(changeTimeout);
                    }
                    cleanNestedLists();
                }
            }
        });

        function uploadImage(file) {
            let data = new FormData();
            data.append("file", file);
            
            $.ajax({
                data: data,
                type: "POST",
                url: "/admin/upload-image",
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#content').summernote('insertImage', response.location);
                },
                error: function(data) {
                    console.error('Image upload error');
                }
            });
        }
        
        // Clean before form submit
        $('form').on('submit', function(e) {
            e.preventDefault();
            cleanNestedLists();
            // Small delay to ensure cleaning is done
            setTimeout(function() {
                this.submit();
            }.bind(this), 100);
        });
    });
</script>
@endsection

