@extends('layouts.admin')

@section('title', 'Tambah Lowongan')
@section('page-title', 'Tambah Lowongan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.jobs.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug (opsional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('slug')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                <input type="text" name="department" value="{{ old('department') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('department')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('location')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pekerjaan</label>
                <input type="text" name="employment_type" value="{{ old('employment_type') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" placeholder="Full-time / Contract / Intern">
                @error('employment_type')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Range Gaji (opsional)</label>
                <input type="text" name="salary_range" value="{{ old('salary_range') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary" placeholder="Rp xx - Rp yy">
                @error('salary_range')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deadline (opsional)</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('deadline')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('sort_order')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
            <textarea name="short_description" rows="2" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">{{ old('short_description') }}</textarea>
            @error('short_description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="5" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kualifikasi</label>
            <textarea name="requirements" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">{{ old('requirements') }}</textarea>
            @error('requirements')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Benefit</label>
            <textarea name="benefits" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">{{ old('benefits') }}</textarea>
            @error('benefits')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="hidden" name="is_active" value="0">
            <input id="is_active" type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="text-sm text-gray-700">Aktif</label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90">Simpan</button>
        </div>
    </form>
</div>
@endsection


