@extends('layouts.admin')

@section('title', 'Edit Testimoni')
@section('page-title', 'Edit Testimoni')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Posisi -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Posisi *</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $testimonial->position) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('position') border-red-500 @enderror" 
                           required>
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Testimoni -->
                <div class="md:col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Testimoni *</label>
                    <textarea name="message" id="message" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('message') border-red-500 @enderror" 
                              required>{{ old('message', $testimonial->message) }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Saat Ini -->
                @if($testimonial->photo)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}" 
                             class="h-20 w-20 rounded-full object-cover">
                        <div>
                            <p class="text-sm text-gray-600">Foto saat ini</p>
                            <p class="text-xs text-gray-500">Upload foto baru untuk mengganti</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Foto Baru -->
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $testimonial->photo ? 'Foto Baru (Opsional)' : 'Foto' }}
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('photo') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('sort_order') border-red-500 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Aktif
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.testimonials.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Update Testimoni
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
