@extends('layouts.app')
@section('title', 'Produk')
@section('page-title', 'Produk')
@push('styles')
<style>
    .product-list-container { height: 450px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .product-list-container::-webkit-scrollbar { display: none; }
    .main-panel { height: 550px; display: flex; flex-direction: column; overflow: hidden; }
</style>
@endpush
@section('content')

<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 ">
 <form action="{{ route('products.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
 <div class="relative flex-1">
 <span class="absolute left-3 top-1/2 -translate-y-1/2"><svg class="fill-gray-400" width="18" height="18" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></span>
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/SKU..." class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 </div>
        <div class="relative sm:w-48" x-data="{ open: false, selected: '{{ request('category_id') ? ($categories->firstWhere('id', request('category_id'))->name ?? 'Semua Kategori') : 'Semua Kategori' }}' }">
            <button type="button" @click="open = !open" class="flex h-11 w-full items-center justify-between rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10">
                <span x-text="selected"></span>
                <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown">
                <div @click="selected = 'Semua Kategori'; open = false; $refs.categoryInput.value = '';" class="custom-select-option" :class="!$refs.categoryInput.value ? 'custom-select-option-active' : 'custom-select-option-inactive'">Semua Kategori</div>
                @foreach($categories as $cat)
                <div @click="selected = '{{ $cat->name }}'; open = false; $refs.categoryInput.value = '{{ $cat->id }}';" class="custom-select-option" :class="$refs.categoryInput.value == '{{ $cat->id }}' ? 'custom-select-option-active' : 'custom-select-option-inactive'">{{ $cat->name }}</div>
                @endforeach
            </div>
            <input type="hidden" name="category_id" x-ref="categoryInput" value="{{ request('category_id') }}">
        </div>
 <button type="submit" class="h-11 rounded-lg bg-brand-500 px-6 text-sm font-medium text-white hover:bg-brand-600">Filter</button>
 @if(request('search') || request('category_id'))
 <a href="{{ route('products.index') }}" class="flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-theme-xs">
 Reset
 </a>
 @endif
 </form>
</div>

<div class="main-panel rounded-2xl border border-gray-200 bg-white ">
 <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 ">
 <h3 class="text-lg font-semibold text-gray-800 ">Daftar Produk</h3>
 <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
 <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>Tambah Produk</a>
 </div>
  <div class="product-list-container p-6">
 @if($products->count() > 0)
 <div class="overflow-x-auto">
 <table class="w-full">
 <thead><tr class="border-b border-gray-100 ">
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">#</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Produk</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Kategori</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Harga</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Stok</th>
 <th class="px-4 py-3 text-center text-theme-xs font-medium uppercase text-gray-500">Aksi</th>
 </tr></thead>
 <tbody class="divide-y divide-gray-100 ">
 @foreach($products as $i => $product)
 <tr class="hover:bg-gray-50 ">
  <td class="px-4 py-3 text-sm text-gray-500">{{ $i + 1 }}</td>
 <td class="px-4 py-3">
 <div class="flex items-center gap-3">
 @if($product->image)
 <img src="{{ asset('storage/' . $product->image) }}" class="h-10 w-10 rounded-lg object-cover">
 @else
 <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-400 "><svg class="fill-current" width="18" height="18" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
 @endif
 <div><p class="text-sm font-medium text-gray-800 ">{{ $product->name }}</p><p class="text-theme-xs text-gray-500">SKU: {{ $product->sku }}</p></div>
 </div>
 </td>
 <td class="px-4 py-3"><span class="rounded-full bg-brand-50 px-2.5 py-1 text-theme-xs font-medium text-brand-500 ">{{ $product->category->name ?? '-' }}</span></td>
 <td class="px-4 py-3 text-sm font-medium text-gray-800 ">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
 <td class="px-4 py-3">
 @if($product->stock <= 5)
 <span class="rounded-full bg-error-50 px-2.5 py-1 text-theme-xs font-medium text-error-500 ">{{ $product->stock }}</span>
 @else
 <span class="rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-500 ">{{ $product->stock }}</span>
 @endif
 </td>
 <td class="px-4 py-3 text-center">
 <div class="flex items-center justify-center gap-2">
 <a href="{{ route('products.show', $product) }}" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 "><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></a>
 <a href="{{ route('products.edit', $product) }}" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 "><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg></a>
  <form action="{{ route('products.destroy', $product) }}" method="POST" class="m-0 inline-block">@csrf @method('DELETE')
 <button type="submit" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-error-50 hover:text-error-500 "><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg></button>
 </form>
 </div>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>

 @else
 <div class="py-12 text-center">
 <p class="text-sm text-gray-500">Belum ada produk.</p>
 <a href="{{ route('products.create') }}" class="mt-3 inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Tambah Produk</a>
 </div>
 @endif
 </div>
</div>
@endsection
