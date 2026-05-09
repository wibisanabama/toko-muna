@extends('layouts.app')
@section('title', 'Ubah Kategori')
@section('page-title', 'Ubah Kategori')
@section('content')
<div class="w-full">
 <div class="rounded-2xl border border-gray-200 bg-white ">
 <div class="border-b border-gray-200 px-6 py-4 ">
 <h3 class="text-lg font-semibold text-gray-800 ">Ubah Kategori: {{ $category->name }}</h3>
 </div>
 <div class="p-6">
 <form action="{{ route('categories.update', $category) }}" method="POST">
 @csrf @method('PUT')
 <div class="mb-5">
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Nama Kategori <span class="text-error-500">*</span></label>
 <input type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div class="mb-6">
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Deskripsi</label>
 <textarea name="description" rows="4" class=" w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">{{ old('description', $category->description) }}</textarea>
 @error('description')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div class="flex items-center gap-3">
 <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Simpan Perubahan</button>
 <a href="{{ route('categories.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Kembali</a>
 </div>
 </form>
 </div>
 </div>
</div>
@endsection
