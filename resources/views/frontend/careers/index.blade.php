@extends('layouts.frontend')

@section('content')
<section class="py-20 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Karier di {{ \App\Models\Setting::getValue('company_name', 'Perusahaan Kami') }}</h1>
            <p class="text-lg text-gray-600">Temukan peluang bergabung dengan tim kami.</p>
        </div>

        @if($jobs->count() > 0)
        <div class="space-y-4">
            @foreach($jobs as $job)
            <a href="{{ route('careers.show', $job->slug) }}" class="block bg-white rounded-xl shadow p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h2>
                        <div class="mt-1 text-sm text-gray-600 flex flex-wrap gap-2">
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
                        </div>
                        @if($job->short_description)
                        <p class="text-gray-600 mt-3">{{ \Illuminate\Support\Str::limit($job->short_description, 150) }}</p>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500">
                        @if($job->deadline)
                        Tutup: {{ $job->deadline->format('d M Y') }}
                        @else
                        Dibuka
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada lowongan</h3>
            <p class="text-gray-600">Silakan cek kembali di lain waktu.</p>
        </div>
        @endif
    </div>
</section>
@endsection


