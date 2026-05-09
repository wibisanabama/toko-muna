@extends('layouts.app')
@section('title', 'Riwayat Stok')
@section('page-title', 'Manajemen Stok')
@push('styles')
<style>
    .stock-list-container { height: 550px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .stock-list-container::-webkit-scrollbar { display: none; }
    .stock-panel { height: 650px; display: flex; flex-direction: column; overflow: hidden; }
    @media print {
        .stock-panel { display: block !important; height: auto !important; overflow: visible !important; border: none !important; }
        .stock-list-container { display: block !important; height: auto !important; overflow: visible !important; scrollbar-width: none !important; -ms-overflow-style: none !important; }
        .stock-list-container::-webkit-scrollbar { display: none !important; }
        .no-print { display: none !important; }
        body { background: white !important; overflow: visible !important; }
        .flex-none, .flex-1 { display: block !important; }
    }
</style>
@endpush
@section('content')
<div class="stock-panel rounded-2xl border border-gray-200 bg-white ">
 <div class="flex-none flex items-center justify-between border-b border-gray-200 px-6 py-4 ">
 <h3 class="text-lg font-semibold text-gray-800 ">Riwayat Pergerakan Stok</h3>
 <a href="{{ route('stock-movements.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
 <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>Catat Pergerakan</a>
 </div>
 <div class="flex-1 p-6 stock-list-container">
 <div class="overflow-x-auto">
 <table class="w-full"><thead><tr class="border-b border-gray-100 ">
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">#</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Produk</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Tipe</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Jumlah</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Oleh</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Catatan</th>
 </tr></thead>
 <tbody class="divide-y divide-gray-100 ">
 @forelse($movements as $i => $m)
 <tr class="hover:bg-gray-50 ">
 <td class="px-4 py-3 text-sm text-gray-500">{{ $i + 1 }}</td>
 <td class="px-4 py-3 text-sm text-gray-500">{{ $m->created_at->format('d/m/Y H:i') }}</td>
 <td class="px-4 py-3"><p class="text-sm font-medium text-gray-800 ">{{ $m->product->name }}</p><p class="text-theme-xs text-gray-500">{{ $m->product->sku }}</p></td>
 <td class="px-4 py-3">
 @if($m->type === 'in')<span class="rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-500 ">↓ Masuk</span>
 @else<span class="rounded-full bg-error-50 px-2.5 py-1 text-theme-xs font-medium text-error-500 ">↑ Keluar</span>@endif
 </td>
 <td class="px-4 py-3 text-sm font-bold {{ $m->type === 'in' ? 'text-success-500' : 'text-error-500' }}">{{ $m->type === 'in' ? '+' : '-' }}{{ $m->quantity }}</td>
 <td class="px-4 py-3 text-sm text-gray-700 ">{{ $m->user->name }}</td>
 <td class="px-4 py-3 text-sm text-gray-500">{{ $m->note ?? '-' }}</td>
 </tr>
 @empty
 <tr><td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada riwayat pergerakan stok.</td></tr>
 @endforelse
 </tbody></table>
 </div>
 </div>

</div>
@endsection
