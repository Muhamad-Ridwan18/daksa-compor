@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" id="password" name="password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
            </div>
        </div>

        <p class="text-sm text-gray-500">Password minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</p>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition duration-300 font-medium">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

