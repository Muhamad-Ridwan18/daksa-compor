@extends('layouts.frontend')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('careers.index') }}" class="text-primary">&larr; Kembali ke Karier</a>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
            <div class="mt-2 text-sm text-gray-600 flex flex-wrap gap-2">
                @if($job->department)
                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $job->department }}</span>
                @endif
                @if($job->location)
                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $job->location }}</span>
                @endif
                @if($job->employment_type)
                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $job->employment_type }}</span>
                @endif
                @if($job->salary_range)
                    <span class="px-2 py-1 bg-gray-100 rounded">{{ $job->salary_range }}</span>
                @endif
                @if($job->deadline)
                    <span class="px-2 py-1 bg-gray-100 rounded">Tutup: {{ $job->deadline->format('d M Y') }}</span>
                @endif
            </div>
        </div>

        @if($job->short_description)
        <p class="text-gray-700 mt-6">{{ $job->short_description }}</p>
        @endif

        @if($job->description)
        <div class="prose max-w-none mt-8">{!! nl2br(e($job->description)) !!}</div>
        @endif

        @if($job->requirements)
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-2">Kualifikasi</h3>
            <div class="prose max-w-none">{!! nl2br(e($job->requirements)) !!}</div>
        </div>
        @endif

        @if($job->benefits)
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-2">Benefit</h3>
            <div class="prose max-w-none">{!! nl2br(e($job->benefits)) !!}</div>
        </div>
        @endif

        <div class="mt-12 bg-background p-6 rounded-xl">
            <h3 class="text-xl font-semibold mb-4">Lamar Posisi Ini</h3>
            <form action="{{ route('careers.apply', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon (opsional)</label>
                        <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Portfolio URL (opsional)</label>
                        <input type="url" name="portfolio_url" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CV (PDF/Doc, maks 5MB)</label>
                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cover Letter (opsional)</label>
                    <textarea name="cover_letter" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Kirim Lamaran</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection


