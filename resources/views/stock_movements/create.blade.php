@extends('layouts.app')
@section('title', 'Catat Stok')
@section('page-title', 'Catat Pergerakan Stok')
@section('content')
<div class="w-full">
 <div class="rounded-2xl border border-gray-200 bg-white ">
 <div class="border-b border-gray-200 px-6 py-4 "><h3 class="text-lg font-semibold text-gray-800 ">Input Stok Masuk / Keluar</h3></div>
 <div class="p-6">
 <form action="{{ route('stock-movements.store') }}" method="POST">
 @csrf
 <div class="space-y-5">
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Produk <span class="text-error-500">*</span></label>
                    <div class="relative" x-data="{ open: false, selected: '{{ old('product_id') ? ($products->firstWhere('id', old('product_id'))->name ?? '-- Pilih Produk --') : '-- Pilih Produk --' }}' }">
                        <button type="button" @click="open = !open" class="custom-select-trigger">
                            <span x-text="selected"></span>
                            <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown">
                            <div @click="selected = '-- Pilih Produk --'; open = false; $refs.productInput.value = '';" class="custom-select-option" :class="!$refs.productInput.value ? 'custom-select-option-active' : 'custom-select-option-inactive'">-- Pilih Produk --</div>
                            @foreach($products as $p)
                            <div @click="selected = '{{ $p->name }} (Stok: {{ $p->stock }})'; open = false; $refs.productInput.value = '{{ $p->id }}';" class="custom-select-option" :class="$refs.productInput.value == '{{ $p->id }}' ? 'custom-select-option-active' : 'custom-select-option-inactive'">{{ $p->name }} (Stok: {{ $p->stock }})</div>
                            @endforeach
                        </div>
                        <input type="hidden" name="product_id" x-ref="productInput" value="{{ old('product_id') }}">
                    </div>
 @error('product_id')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div class="grid grid-cols-2 gap-4">
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Jenis <span class="text-error-500">*</span></label>
                    <div class="relative" x-data="{ open: false, selected: '{{ old('type') === 'out' ? 'Stok Keluar' : 'Stok Masuk' }}' }">
                        <button type="button" @click="open = !open" class="custom-select-trigger">
                            <span x-text="selected"></span>
                            <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown">
                            <div @click="selected = 'Stok Masuk'; open = false; $refs.typeInput.value = 'in';" class="custom-select-option" :class="$refs.typeInput.value === 'in' ? 'custom-select-option-active' : 'custom-select-option-inactive'">Stok Masuk</div>
                            <div @click="selected = 'Stok Keluar'; open = false; $refs.typeInput.value = 'out';" class="custom-select-option" :class="$refs.typeInput.value === 'out' ? 'custom-select-option-active' : 'custom-select-option-inactive'">Stok Keluar</div>
                        </div>
                        <input type="hidden" name="type" x-ref="typeInput" value="{{ old('type', 'in') }}">
                    </div>
 </div>
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Jumlah <span class="text-error-500">*</span></label>
 <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('quantity')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 </div>
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Catatan</label>
 <textarea name="note" rows="3" placeholder="Contoh: Restock dari supplier" class=" w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">{{ old('note') }}</textarea>
 </div>
 </div>
 <div class="mt-6 flex items-center gap-3">
 <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Simpan</button>
 <a href="{{ route('stock-movements.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Batal</a>
 </div>
 </form>
 </div>
 </div>
</div>
@endsection
