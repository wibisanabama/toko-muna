@extends('layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Kategori Produk')
@push('styles')
<style>
    .category-panel { height: calc(100vh - 210px); display: flex; flex-direction: column; overflow: hidden; }
    .category-table-wrapper { flex: 1; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .category-table-wrapper::-webkit-scrollbar { display: none; }
</style>
@endpush
@section('content')
<div class="category-panel rounded-2xl border border-gray-200 bg-white ">
 <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 ">
 <h3 class="text-lg font-semibold text-gray-800 ">Daftar Kategori</h3>
 <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
 <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
 Tambah Kategori
 </a>
 </div>
    <div class="category-table-wrapper">
        <div class="p-0">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed">
                        <thead>
                            <tr class="border-b border-gray-100 ">
                                <th class="w-16 px-4 py-2.5 text-left text-theme-xs font-medium uppercase text-gray-500 ">#</th>
                                <th class="w-1/4 px-4 py-2.5 text-left text-theme-xs font-medium uppercase text-gray-500 ">Nama</th>
                                <th class="px-4 py-2.5 text-left text-theme-xs font-medium uppercase text-gray-500 ">Deskripsi</th>
                                <th class="w-40 px-4 py-2.5 text-left text-theme-xs font-medium uppercase text-gray-500 ">Dibuat</th>
                                <th class="w-32 px-4 py-2.5 text-center text-theme-xs font-medium uppercase text-gray-500 ">Aksi</th>
                            </tr>
                        </thead>
 <tbody class="divide-y divide-gray-100 ">
 @foreach($categories as $i => $category)
 <tr class="hover:bg-gray-50 ">
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                        <div class="truncate max-w-[150px]" title="{{ $category->name }}">{{ $category->name }}</div>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                        <div class="truncate max-w-[300px]" title="{{ $category->description }}">{{ $category->description ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500 ">{{ $category->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-center">
 <div class="flex items-center justify-center gap-2">
 <a href="{{ route('categories.edit', $category) }}" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 ">
 <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
 </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="m-0 inline-block">
 @csrf @method('DELETE')
 <button type="submit" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-error-50 hover:text-error-500 ">
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
        </div>
    </div>

 @else
 <div class="py-12 text-center">
 <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
 <p class="mt-3 text-sm text-gray-500 ">Belum ada kategori.</p>
 <a href="{{ route('categories.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Tambah Kategori</a>
 </div>
 @endif
</div>
@endsection
