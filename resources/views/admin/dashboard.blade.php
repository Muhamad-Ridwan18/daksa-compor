@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Total Layanan</p>
                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['services'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Total Produk</p>
                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['products'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['orders'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center">
            <div class="p-2 md:p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <div class="ml-3 md:ml-4">
                <p class="text-xs md:text-sm font-medium text-gray-600">Pesan Kontak</p>
                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['contact_messages'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-600">Pesan Belum Dibaca</p>
                <p class="text-xl md:text-2xl font-semibold text-red-600">{{ $stats['unread_messages'] }}</p>
            </div>
            <div class="p-2 md:p-3 rounded-full bg-red-100 text-red-600 flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-600">Pesanan Pending</p>
                <p class="text-xl md:text-2xl font-semibold text-yellow-600">{{ $stats['pending_orders'] }}</p>
            </div>
            <div class="p-2 md:p-3 rounded-full bg-yellow-100 text-yellow-600 flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 md:p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm font-medium text-gray-600">Total Testimonial</p>
                <p class="text-xl md:text-2xl font-semibold text-gray-900">{{ $stats['testimonials'] }}</p>
            </div>
            <div class="p-2 md:p-3 rounded-full bg-gray-100 text-gray-600 flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base md:text-lg font-medium text-gray-900">Pesanan Terbaru</h3>
        </div>
        <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
            @forelse($recentOrders as $order)
                <div class="px-4 md:px-6 py-3 md:py-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $order->name }}</p>
                            <p class="text-xs md:text-sm text-gray-500 truncate">{{ $order->product->name }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $order->status_badge_class }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:text-primary-dark p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 md:px-6 py-8 text-center text-gray-500">
                    <svg class="w-10 h-10 md:w-12 md:h-12 mx-auto mb-3 md:mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p class="text-sm">Belum ada pesanan</p>
                </div>
            @endforelse
        </div>
        @if($recentOrders->count() > 0)
            <div class="px-4 md:px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.orders.index') }}" class="text-xs md:text-sm text-primary hover:text-primary-dark font-medium inline-flex items-center">
                    Lihat semua pesanan 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Messages -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base md:text-lg font-medium text-gray-900">Pesan Kontak Terbaru</h3>
        </div>
        <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
            @forelse($recentMessages as $message)
                <div class="px-4 md:px-6 py-3 md:py-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $message->name }}</p>
                            <p class="text-xs md:text-sm text-gray-500 truncate">{{ $message->email }}</p>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ Str::limit($message->message, 60) }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$message->is_read)
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 md:px-6 py-8 text-center text-gray-500">
                    <svg class="w-10 h-10 md:w-12 md:h-12 mx-auto mb-3 md:mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-sm">Belum ada pesan</p>
                </div>
            @endforelse
        </div>
        @if($recentMessages->count() > 0)
            <div class="px-4 md:px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs md:text-sm text-primary hover:text-primary-dark font-medium inline-flex items-center">
                    Lihat semua pesan 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
