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

<style>
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
    $(document).ready(function() {
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
    });
</script>
@endsection

