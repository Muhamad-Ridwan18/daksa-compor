@extends('layouts.admin')

@section('title', 'Edit Klien')
@section('page-title', 'Edit Klien')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Klien -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Klien *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div class="md:col-span-2">
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $client->website) }}" 
                           placeholder="https://example.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('website') border-red-500 @enderror">
                    @error('website')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo Saat Ini -->
                @if($client->logo)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Saat Ini</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" 
                             class="h-20 w-20 rounded-lg object-contain">
                        <div>
                            <p class="text-sm text-gray-600">Logo saat ini</p>
                            <p class="text-xs text-gray-500">Upload logo baru untuk mengganti</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Logo Baru -->
                <div class="md:col-span-2">
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $client->logo ? 'Logo Baru (Opsional)' : 'Logo' }}
                    </label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('logo') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB</p>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $client->sort_order) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('sort_order') border-red-500 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', $client->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Aktif
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.clients.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Update Klien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
