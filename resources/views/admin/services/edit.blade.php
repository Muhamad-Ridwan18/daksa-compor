@extends('layouts.admin')

@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan</label>
            <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="4" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror">{{ old('description', $service->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
            @if($service->image)
                <div class="mb-4">
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" 
                         class="h-32 w-32 object-cover rounded-lg">
                    <p class="mt-1 text-sm text-gray-500">Gambar saat ini</p>
                </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('image') border-red-500 @enderror">
            <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('sort_order') border-red-500 @enderror">
                @error('sort_order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Aktif
                </label>
            </div>
        </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.services.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-300 font-medium">
                    Update Layanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
