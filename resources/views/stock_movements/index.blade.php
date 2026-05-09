@extends('layouts.app')
@section('title', 'Riwayat Stok')
@section('page-title', 'Manajemen Stok')
@section('content')
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Riwayat Pergerakan Stok</h3>
        <a href="{{ route('stock-movements.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
            <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>Catat Pergerakan</a>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">#</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Produk</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Tipe</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Jumlah</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Oleh</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Catatan</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($movements as $i => $m)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $movements->firstItem() + $i }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3"><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $m->product->name }}</p><p class="text-theme-xs text-gray-500">{{ $m->product->sku }}</p></td>
                    <td class="px-4 py-3">
                        @if($m->type === 'in')<span class="rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-500 dark:bg-success-500/10">↓ Masuk</span>
                        @else<span class="rounded-full bg-error-50 px-2.5 py-1 text-theme-xs font-medium text-error-500 dark:bg-error-500/10">↑ Keluar</span>@endif
                    </td>
                    <td class="px-4 py-3 text-sm font-bold {{ $m->type === 'in' ? 'text-success-500' : 'text-error-500' }}">{{ $m->type === 'in' ? '+' : '-' }}{{ $m->quantity }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $m->user->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $m->note ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada riwayat pergerakan stok.</td></tr>
                @endforelse
            </tbody></table>
        </div>
        <div class="mt-4">{{ $movements->links() }}</div>
    </div>
</div>
@endsection
