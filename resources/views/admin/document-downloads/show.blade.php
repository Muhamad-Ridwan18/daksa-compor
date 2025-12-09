@extends('layouts.admin')

@section('title', 'Detail Tracking')
@section('page-title', 'Detail Tracking Download')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.document-downloads.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Tracking
        </a>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Tracking</h3>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Document Info -->
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-3">Dokumen</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-lg font-semibold text-gray-900">{{ $documentDownload->document->title }}</p>
                    @if($documentDownload->document->document_number)
                        <p class="text-sm text-gray-600 mt-1">Nomor: {{ $documentDownload->document->document_number }}</p>
                    @endif
                    <a href="{{ route('documents.show', $documentDownload->document->slug) }}" 
                       target="_blank"
                       class="inline-flex items-center mt-2 text-sm text-primary hover:underline">
                        Lihat Dokumen
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- User Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Informasi Pengguna</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentDownload->nama_lengkap }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentDownload->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentDownload->no_telpon }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Perusahaan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $documentDownload->nama_perusahaan }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Informasi Tracking</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $documentDownload->created_at->format('d M Y, H:i') }} WIB
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID Tracking</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $documentDownload->id }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <form action="{{ route('admin.document-downloads.destroy', $documentDownload) }}" 
                  method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tracking ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Hapus Tracking
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

