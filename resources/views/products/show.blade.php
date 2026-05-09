@extends('layouts.app')
@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')
@section('content')
<div class="w-full">
 <div class="rounded-2xl border border-gray-200 bg-white ">
 <div class="border-b border-gray-200 px-6 py-4 "><h3 class="text-lg font-semibold text-gray-800 ">Informasi Produk</h3></div>
 <div class="p-6">
 <div class="flex flex-col gap-6 sm:flex-row">
 <div class="sm:w-1/3">
 @if($product->image)
 <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full rounded-xl object-cover shadow-theme-sm">
 @else
 <div class="flex aspect-square w-full items-center justify-center rounded-xl bg-gray-100 text-gray-300 "><svg class="fill-current" width="64" height="64" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
 @endif
 </div>
 <div class="flex-1 space-y-4">
 <div>
 <h2 class="text-xl font-bold text-gray-800 ">{{ $product->name }}</h2>
 <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
 </div>
 <div class="grid grid-cols-2 gap-4">
 <div>
 <p class="text-theme-xs text-gray-500 mb-1">Kategori</p>
 <span class="rounded-full bg-brand-50 px-2.5 py-1 text-theme-xs font-medium text-brand-500 ">{{ $product->category->name ?? '-' }}</span>
 </div>
 <div>
 <p class="text-theme-xs text-gray-500 mb-1">Harga</p>
 <p class="text-lg font-bold text-brand-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
 </div>
 <div>
 <p class="text-theme-xs text-gray-500 mb-1">Stok</p>
 @if($product->stock <= 5)
 <span class="rounded-full bg-error-50 px-2.5 py-1 text-theme-xs font-medium text-error-500 ">{{ $product->stock }} Unit (Rendah!)</span>
 @else
 <span class="rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-500 ">{{ $product->stock }} Unit</span>
 @endif
 </div>
 <div>
 <p class="text-theme-xs text-gray-500 mb-1">Diperbarui</p>
 <p class="text-sm text-gray-800 ">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
 </div>
 </div>
 <div>
 <p class="text-theme-xs text-gray-500 mb-1">Deskripsi</p>
 <p class="text-sm text-gray-700 ">{!! nl2br(e($product->description ?: 'Tidak ada deskripsi.')) !!}</p>
 </div>
 <div class="flex items-center gap-3 pt-2 border-t border-gray-100 ">
 <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Kembali</a>
 </div>
 </div>
 </div>
 </div>
 </div>
</div>
@endsection
