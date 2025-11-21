@extends('layouts.admin')

@section('title', 'Detail Layanan')
@section('page-title', 'Layanan: ' . $service->name)

@section('content')
<div class="space-y-6">
    <!-- Service Header Card -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex items-start gap-8">
            @if($service->image)
                <div class="flex-shrink-0">
                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" 
                         class="w-32 h-32 rounded-2xl object-cover shadow-md">
                </div>
            @else
                <div class="flex-shrink-0 w-32 h-32 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-16 h-16 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-4">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $service->name }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $service->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <p class="text-lg text-gray-600 leading-relaxed">{{ $service->description }}</p>
                <div class="mt-6 flex items-center gap-4">
                    <a href="{{ route('admin.services.edit', $service) }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Layanan
                    </a>
                    <a href="{{ route('admin.services.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-secondary px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-white">Produk Layanan</h3>
                    <p class="text-white/80 mt-1">{{ $service->products->count() }} produk tersedia</p>
                </div>
                <a href="{{ route('admin.products.create', ['service_id' => $service->id]) }}" 
                   class="bg-white text-primary px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-200 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Produk
                </a>
            </div>
        </div>
        
        <div class="p-8">
            @if($service->products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($service->products as $product)
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:border-primary/30">
                        <div class="flex items-start gap-4 mb-4">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" 
                                     class="w-20 h-20 rounded-xl object-cover shadow-sm" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $product->name }}</h4>
                                    @if($product->show_price ?? true)
                                        <span class="text-xl font-bold text-primary">{{ $product->formatted_price }}</span>
                                    @else
                                        <span class="text-sm text-gray-500 italic">Harga disembunyikan</span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit($product->description, 100) }}</p>
                            </div>
                        </div>
                        
                        @php 
                            $features = $product->features ?? [];
                            // Handle backward compatibility: convert old string format to new array format
                            if (!empty($features) && is_string($features[0] ?? null)) {
                                $convertedFeatures = [];
                                foreach ($features as $feature) {
                                    $convertedFeatures[] = ['name' => $feature, 'description' => ''];
                                }
                                $features = $convertedFeatures;
                            }
                        @endphp
                        @if(is_array($features) && count($features))
                        <div class="mb-4">
                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Fitur:</h5>
                            <div class="space-y-2">
                                @foreach($features as $feat)
                                <div class="border-l-4 border-green-500 pl-3 py-1">
                                    <div class="font-medium text-gray-900 text-sm">{{ is_array($feat) ? ($feat['name'] ?? '') : $feat }}</div>
                                    @if(is_array($feat) && !empty($feat['description'] ?? ''))
                                        <div class="text-xs text-gray-600 mt-1">{{ $feat['description'] }}</div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="flex-1 text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-200 text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                                  onsubmit="return confirm('Hapus produk ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition duration-200 text-sm font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Produk</h3>
                    <p class="text-gray-600 mb-6">Mulai dengan menambahkan produk pertama untuk layanan ini.</p>
                    <a href="{{ route('admin.products.create', ['service_id' => $service->id]) }}" 
                       class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-200 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Produk Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


