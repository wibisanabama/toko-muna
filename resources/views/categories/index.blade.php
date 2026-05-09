@extends('layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Kategori Produk')
@section('content')
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Daftar Kategori</h3>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
            <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
            Tambah Kategori
        </a>
    </div>
    <div class="p-6">
        @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500 dark:text-gray-400">#</th>
                        <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500 dark:text-gray-400">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500 dark:text-gray-400">Dibuat</th>
                        <th class="px-4 py-3 text-center text-theme-xs font-medium uppercase text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($categories as $i => $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $categories->firstItem() + $i }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-white/90">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $category->description ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $category->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('categories.edit', $category) }}" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 dark:border-gray-700 dark:hover:bg-white/5">
                                    <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori {{ $category->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-error-50 hover:text-error-500 dark:border-gray-700 dark:hover:bg-error-500/10">
                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $categories->links() }}</div>
        @else
        <div class="py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Belum ada kategori.</p>
            <a href="{{ route('categories.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Tambah Kategori</a>
        </div>
        @endif
    </div>
</div>
@endsection
