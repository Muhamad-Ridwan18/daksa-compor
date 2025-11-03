@extends('layouts.admin')

@section('title', 'Manajemen Lowongan')
@section('page-title', 'Manajemen Lowongan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Daftar Lowongan</h2>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.job-applications.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Lamaran</a>
        <a href="{{ route('admin.jobs.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">Tambah Lowongan</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($jobs->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($jobs as $job)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $job->title }}</td>
                    <td class="px-6 py-4">{{ $job->department }}</td>
                    <td class="px-6 py-4">{{ $job->location }}</td>
                    <td class="px-6 py-4">{{ $job->employment_type }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $job->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.jobs.edit', $job) }}" class="text-primary hover:text-primary-dark">Edit</a>
                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Hapus lowongan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-12">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Lowongan</h3>
        <a href="{{ route('admin.jobs.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90">Tambah Lowongan</a>
    </div>
    @endif
</div>
@endsection


