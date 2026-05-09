@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit Kategori: {{ $category->name }}</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-5">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Kategori <span class="text-error-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                    @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi</label>
                    <textarea name="description" rows="4" class="dark:bg-gray-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">{{ old('description', $category->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Update</button>
                    <a href="{{ route('categories.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
