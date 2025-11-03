@extends('layouts.admin')

@section('title', 'Edit Anggota Tim')
@section('page-title', 'Edit Anggota Tim')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.team-members.update', $member) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                <input type="text" name="role" value="{{ old('role', $member->role) }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email (opsional)</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL (opsional)</label>
                <input type="url" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('linkedin')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Twitter/X URL (opsional)</label>
                <input type="url" name="twitter" value="{{ old('twitter', $member->twitter) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('twitter')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">
                @error('sort_order')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Bio (opsional)</label>
            <textarea name="bio" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary">{{ old('bio', $member->bio) }}</textarea>
            @error('bio')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto (opsional)</label>
                <input type="file" name="photo" accept="image/*" class="w-full">
                @error('photo')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                @if($member->photo)
                    <div class="mt-3">
                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="h-16 w-16 rounded-full object-cover">
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-3 mt-6">
                <input type="hidden" name="is_active" value="0">
                <input id="is_active" type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-700">Aktif</label>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.team-members.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90">Simpan Perubahan</button>
        </div>
    </form>
    </div>
@endsection


