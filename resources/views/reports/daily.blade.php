@extends('layouts.app')
@section('title', 'Laporan Harian')
@section('page-title', 'Laporan Penjualan Harian')
@section('content')
{{-- Filter --}}
<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
    <form action="{{ route('reports.daily') }}" method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal</label>
            <input type="date" name="date" value="{{ $date }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        </div>
        <button type="submit" class="h-11 rounded-lg bg-brand-500 px-6 text-sm font-medium text-white hover:bg-brand-600">Tampilkan</button>
        <button type="button" onclick="window.print()" class="no-print h-11 rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300">🖨️ Cetak</button>
    </form>
</div>

{{-- Summary --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-theme-sm text-gray-500">Total Pendapatan</p>
        <h3 class="text-xl font-bold text-brand-500">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h3>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-theme-sm text-gray-500">Total Transaksi</p>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">{{ $summary['total_transactions'] }}</h3>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <p class="text-theme-sm text-gray-500">Rata-rata</p>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($summary['average_transaction'], 0, ',', '.') }}</h3>
    </div>
</div>

{{-- Table --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Detail - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">#</th>
            <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
            <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Kasir</th>
            <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Item</th>
            <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Total</th>
            <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Metode</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($transactions as $i => $t)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-4 py-3 text-sm text-gray-500">{{ $i + 1 }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $t->created_at->format('H:i:s') }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $t->user->name }}</td>
                <td class="px-4 py-3">
                    @foreach($t->items as $item)<p class="text-theme-xs text-gray-600 dark:text-gray-400">{{ $item->product->name }} (x{{ $item->quantity }})</p>@endforeach
                </td>
                <td class="px-4 py-3 text-sm font-bold text-brand-500">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td class="px-4 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ strtoupper($t->payment_method) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">Tidak ada transaksi.</td></tr>
            @endforelse
        </tbody></table>
    </div>
</div>
@endsection
