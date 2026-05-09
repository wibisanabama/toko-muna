@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Tambah User Baru</h3></div>
        <div class="p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Lengkap <span class="text-error-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                        @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email <span class="text-error-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                        @error('email')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password <span class="text-error-500">*</span></label>
                        <input type="password" name="password" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                        @error('password')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Role <span class="text-error-500">*</span></label>
                        <select name="role" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                            <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Simpan</button>
                    <a href="{{ route('users.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
