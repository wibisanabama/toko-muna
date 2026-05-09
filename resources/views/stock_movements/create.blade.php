@extends('layouts.app')
@section('title', 'Catat Stok')
@section('page-title', 'Catat Pergerakan Stok')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Input Stok Masuk / Keluar</h3></div>
        <div class="p-6">
            <form action="{{ route('stock-movements.store') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Produk <span class="text-error-500">*</span></label>
                        <select name="product_id" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $p)<option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} (Stok: {{ $p->stock }})</option>@endforeach
                        </select>
                        @error('product_id')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jenis <span class="text-error-500">*</span></label>
                            <select name="type" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stok Masuk</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stok Keluar</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jumlah <span class="text-error-500">*</span></label>
                            <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                            @error('quantity')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Catatan</label>
                        <textarea name="note" rows="3" placeholder="Contoh: Restock dari supplier" class="dark:bg-gray-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Simpan</button>
                    <a href="{{ route('stock-movements.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
