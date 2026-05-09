@extends('layouts.app')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Edit: {{ $product->name }}</h3></div>
        <div class="p-6">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Produk <span class="text-error-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                        @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">SKU <span class="text-error-500">*</span></label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                        @error('sku')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori</label>
                        <select name="category_id" class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Harga <span class="text-error-500">*</span></label>
                        <div class="relative"><span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">Rp</span>
                        <input type="number" min="0" name="price" value="{{ old('price', round($product->price)) }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800"></div>
                        @error('price')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Stok <span class="text-error-500">*</span></label>
                        <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                        @error('stock')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Gambar</label>
                        @if($product->image)<div class="mb-2"><img src="{{ asset('storage/' . $product->image) }}" class="h-20 rounded-lg object-cover"><p class="mt-1 text-theme-xs text-gray-500">Upload baru untuk mengganti.</p></div>@endif
                        <input type="file" name="image" accept="image/*" class="dark:bg-gray-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2 text-sm text-gray-800 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-1.5 file:text-sm file:font-medium file:text-brand-500 hover:file:bg-brand-100 dark:border-gray-700 dark:text-white/90">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi</label>
                        <textarea name="description" rows="3" class="dark:bg-gray-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Update</button>
                    <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
