@extends('layouts.app')
@section('title', 'Laporan Harian')
@section('page-title', 'Laporan Penjualan Harian')
@section('content')
@push('styles')
<style>
    .report-list-container { height: 350px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .report-list-container::-webkit-scrollbar { display: none; }
    .report-panel { height: 450px; display: flex; flex-direction: column; overflow: hidden; }
    @media print {
        .report-panel { display: block !important; height: auto !important; overflow: visible !important; border: none !important; }
        .report-list-container { display: block !important; height: auto !important; overflow: visible !important; scrollbar-width: none !important; -ms-overflow-style: none !important; }
        .report-list-container::-webkit-scrollbar { display: none !important; }
        .no-print { display: none !important; }
        body { background: white !important; overflow: visible !important; }
        .rounded-2xl { border-radius: 0 !important; border: none !important; box-shadow: none !important; }
        .flex-none, .flex-1 { display: block !important; }
    }
</style>
@endpush

<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 ">
 <form action="{{ route('reports.daily') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
  <div class="w-full">
  <label class="mb-1 block text-sm font-medium text-gray-700 ">Tanggal</label>
  <input type="date" name="date" value="{{ $date }}" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm ">
  </div>
  <div class="flex items-end gap-3 w-full">
  <button type="submit" class="h-11 flex-1 rounded-lg bg-brand-500 px-6 text-sm font-medium text-white hover:bg-brand-600">Tampilkan</button>
  <button type="button" onclick="window.print()" class="no-print h-11 flex-1 rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Cetak</button>
  </div>
 </form>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
 <div class="rounded-2xl border border-gray-200 bg-white p-5 ">
 <p class="text-theme-sm text-gray-500">Total Pendapatan</p>
 <h3 class="text-xl font-bold text-brand-500">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h3>
 </div>
 <div class="rounded-2xl border border-gray-200 bg-white p-5 ">
 <p class="text-theme-sm text-gray-500">Total Transaksi</p>
 <h3 class="text-xl font-bold text-gray-800 ">{{ $summary['total_transactions'] }}</h3>
 </div>
 <div class="rounded-2xl border border-gray-200 bg-white p-5 ">
 <p class="text-theme-sm text-gray-500">Rata-rata</p>
 <h3 class="text-xl font-bold text-gray-800 ">Rp {{ number_format($summary['average_transaction'], 0, ',', '.') }}</h3>
 </div>
</div>

<div class="report-panel rounded-2xl border border-gray-200 bg-white ">
 <div class="flex-none border-b border-gray-200 px-6 py-4 "><h3 class="text-lg font-semibold text-gray-800 ">Detail - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h3></div>
 <div class="flex-1 overflow-x-auto report-list-container">
 <table class="w-full"><thead><tr class="border-b border-gray-100 ">
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">#</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Kasir</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Item</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Total</th>
 <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Metode</th>
 </tr></thead>
 <tbody class="divide-y divide-gray-100 ">
 @forelse($transactions as $i => $t)
 <tr class="hover:bg-gray-50 ">
 <td class="px-4 py-3 text-sm text-gray-500">{{ $i + 1 }}</td>
 <td class="px-4 py-3 text-sm text-gray-500">{{ $t->created_at->format('H:i:s') }}</td>
 <td class="px-4 py-3 text-sm text-gray-700 ">{{ $t->user->name }}</td>
 <td class="px-4 py-3">
 @foreach($t->items as $item)<p class="text-theme-xs text-gray-600 ">{{ $item->product->name }} (x{{ $item->quantity }})</p>@endforeach
 </td>
 <td class="px-4 py-3 text-sm font-bold text-brand-500">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
 <td class="px-4 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 ">{{ strtoupper($t->payment_method) }}</span></td>
 </tr>
 @empty
 <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">Tidak ada transaksi.</td></tr>
 @endforelse
 </tbody></table>
 </div>
</div>
@endsection
