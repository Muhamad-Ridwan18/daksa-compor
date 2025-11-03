@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Pesanan</h2>
                <p class="text-gray-600">Pesanan #{{ $order->id }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}
                </p>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $order->status_badge_class }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="mb-6 bg-gray-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status Pesanan</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center space-x-4">
                @csrf
                @method('PATCH')
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Processed</option>
                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Done</option>
                </select>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Order Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Product Information -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-4">Informasi Produk</h4>
                <div class="flex items-start space-x-4">
                    @if($order->product->image)
                        <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}" 
                             class="h-16 w-16 rounded-lg object-cover">
                    @else
                        <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h5 class="font-medium text-gray-900">{{ $order->product->name }}</h5>
                        <p class="text-sm text-gray-600">{{ $order->product->service->name }}</p>
                        <p class="text-lg font-semibold text-primary">{{ $order->product->formatted_price }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($order->product->description, 100) }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-4">Informasi Pelanggan</h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <a href="mailto:{{ $order->email }}" 
                               class="text-primary hover:text-primary-dark">{{ $order->email }}</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <a href="tel:{{ $order->phone }}" 
                               class="text-primary hover:text-primary-dark">{{ $order->phone }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($order->notes)
        <div class="mb-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Catatan Pelanggan
                </h4>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Order Details -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-4">Detail Pesanan</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">ID Pesanan</p>
                    <p class="font-medium text-gray-900">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->status_badge_class }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                    <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Terakhir Diperbarui</p>
                    <p class="font-medium text-gray-900">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 mt-8">
            <a href="{{ route('admin.orders.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                Kembali ke Daftar
            </a>
            <a href="mailto:{{ $order->email }}" 
               class="px-4 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Kirim Email
            </a>
        </div>
    </div>
</div>
@endsection
