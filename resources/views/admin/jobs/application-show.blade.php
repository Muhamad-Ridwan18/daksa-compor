@extends('layouts.admin')

@section('title', 'Detail Lamaran')
@section('page-title', 'Detail Lamaran')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left: Details Card -->
    <div class="bg-white rounded-lg shadow p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Posisi</h3>
                <div class="text-gray-900 font-medium">{{ $application->job->title }}</div>
            </div>
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Tanggal</h3>
                <div class="text-gray-900">{{ $application->created_at->format('d M Y H:i') }}</div>
            </div>
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Nama</h3>
                <div class="text-gray-900">{{ $application->name }}</div>
            </div>
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Email</h3>
                <div class="text-gray-900">{{ $application->email }}</div>
            </div>
            @if($application->phone)
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Telepon</h3>
                <div class="text-gray-900">{{ $application->phone }}</div>
            </div>
            @endif
            @if($application->portfolio_url)
            <div>
                <h3 class="text-sm text-gray-500 mb-1">Portfolio</h3>
                <a href="{{ $application->portfolio_url }}" target="_blank" rel="noopener" class="text-primary">{{ $application->portfolio_url }}</a>
            </div>
            @endif
            @if($application->cv_path)
            <div>
                <h3 class="text-sm text-gray-500 mb-1">CV</h3>
                <a href="{{ route('admin.job-applications.download-cv', $application) }}" class="text-primary">Unduh CV</a>
            </div>
            @endif
        </div>

        @if($application->cover_letter)
        <div>
            <h3 class="text-sm text-gray-500 mb-2">Cover Letter</h3>
            <div class="prose max-w-none">{!! nl2br(e($application->cover_letter)) !!}</div>
        </div>
        @endif

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.job-applications.update-status', $application) }}" method="POST" class="flex items-center gap-3">
                @csrf
                @method('PATCH')
                <label class="text-sm text-gray-700">Ubah Status</label>
                <select name="status" class="px-3 py-2 border rounded-lg">
                    @foreach(['received','reviewed','interviewed','rejected','offer'] as $st)
                        <option value="{{ $st }}" {{ $application->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Simpan</button>
            </form>
            <a href="{{ route('admin.job-applications.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Kembali</a>
        </div>
    </div>

    <!-- Right: CV Preview Card -->
    <div>
        @if($application->cv_path)
            @php
                $cvUrl = Storage::url($application->cv_path);
                $isPdf = \Illuminate\Support\Str::endsWith(strtolower($application->cv_path), '.pdf');
            @endphp
            <div class="bg-white rounded-lg shadow p-4 lg:sticky lg:top-20">
                <h3 class="text-sm text-gray-500 mb-3">Pratinjau CV</h3>
                @if($isPdf)
                    <div class="w-full h-[750px] border rounded-lg overflow-hidden">
                        <iframe src="{{ $cvUrl }}" class="w-full h-full" title="CV Preview"></iframe>
                    </div>
                @else
                    <p class="text-gray-600 text-sm">Format CV bukan PDF. Gunakan tombol "Unduh CV" pada kartu informasi untuk melihat berkas.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection


