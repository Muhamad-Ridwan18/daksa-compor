@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Produk -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if(isset($service) && $service)
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md text-gray-700">
                            {{ $service->name }}
                        </div>
                    </div>
                @else
                    <!-- Layanan -->
                    <div class="md:col-span-2">
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Layanan *</label>
                        <select name="service_id" id="service_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('service_id') border-red-500 @enderror" 
                                required>
                            <option value="">Pilih Layanan</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $product->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                    <textarea name="description" id="description" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror" 
                              required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fitur Produk -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fitur Produk</label>
                    <div id="featuresWrapper" class="space-y-4">
                        @php 
                            $oldFeatures = old('features', $product->features ?? []);
                            // Handle backward compatibility: convert old string format to new array format
                            if (!empty($oldFeatures) && is_string($oldFeatures[0] ?? null)) {
                                $convertedFeatures = [];
                                foreach ($oldFeatures as $feature) {
                                    $convertedFeatures[] = ['name' => $feature, 'description' => ''];
                                }
                                $oldFeatures = $convertedFeatures;
                            }
                            if (empty($oldFeatures)) {
                                $oldFeatures = [['name' => '', 'description' => '']];
                            }
                        @endphp
                        @foreach($oldFeatures as $i => $feature)
                        <div class="feature-item border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Fitur {{ $i + 1 }}</span>
                                <button type="button" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 text-sm" onclick="this.closest('.feature-item').remove()">Hapus</button>
                            </div>
                            <div class="space-y-2">
                                <input type="text" name="features[{{ $i }}][name]" value="{{ is_array($feature) ? ($feature['name'] ?? '') : $feature }}" placeholder="Nama Fitur (Contoh: Harga Terjangkau)" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <textarea name="features[{{ $i }}][description]" rows="2" placeholder="Deskripsi Fitur (Contoh: Harga yang terjangkau untuk semua kalangan)" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">{{ is_array($feature) ? ($feature['description'] ?? '') : '' }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="mt-2 text-sm text-primary font-semibold" onclick="addFeatureRow()">+ Tambah Fitur</button>
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('price') border-red-500 @enderror" 
                           required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $product->sort_order) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('sort_order') border-red-500 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Saat Ini -->
                @if($product->image)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="h-20 w-20 rounded-lg object-cover">
                        <div>
                            <p class="text-sm text-gray-600">Gambar saat ini</p>
                            <p class="text-xs text-gray-500">Upload gambar baru untuk mengganti</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Gambar Baru -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $product->image ? 'Gambar Baru (Opsional)' : 'Gambar' }}
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('image') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 5MB</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Aktif
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="show_price" id="show_price" value="1" 
                                   {{ old('show_price', $product->show_price ?? true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="show_price" class="ml-2 block text-sm text-gray-700">
                                Tampilkan Harga
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ isset($service) && $service ? route('admin.services.show', $service) : route('admin.products.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function addFeatureRow() {
    const wrapper = document.getElementById('featuresWrapper');
    const index = wrapper.children.length;
    const div = document.createElement('div');
    div.className = 'feature-item border border-gray-200 rounded-lg p-4 bg-gray-50';
    div.innerHTML = `
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Fitur ${index + 1}</span>
            <button type="button" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 text-sm" onclick="this.closest('.feature-item').remove()">Hapus</button>
        </div>
        <div class="space-y-2">
            <input type="text" name="features[${index}][name]" placeholder="Nama Fitur (Contoh: Support 24/7)" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            <textarea name="features[${index}][description]" rows="2" placeholder="Deskripsi Fitur (Contoh: Dukungan pelanggan 24 jam)" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
        </div>
    `;
    wrapper.appendChild(div);
}
</script>
@endsection
