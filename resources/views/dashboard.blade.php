@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Overview Dashboard')
@section('content')
{{-- Metric Cards --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                <svg class="fill-brand-500" width="24" height="24" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
            </div>
            <div>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Penjualan Hari Ini</p>
                <h4 class="text-xl font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($todaySales, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                <svg class="fill-success-500" width="24" height="24" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0020 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </div>
            <div>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Transaksi Hari Ini</p>
                <h4 class="text-xl font-bold text-gray-800 dark:text-white/90">{{ $todayTransactionsCount }}</h4>
            </div>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-light-50 dark:bg-blue-light-500/10">
                <svg class="fill-blue-light-500" width="24" height="24" viewBox="0 0 24 24"><path d="M20 2H4c-1 0-2 1-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
            </div>
            <div>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Total Produk</p>
                <h4 class="text-xl font-bold text-gray-800 dark:text-white/90">{{ $totalProducts }}</h4>
            </div>
        </div>
    </div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-error-50 dark:bg-error-500/10">
                <svg class="fill-error-500" width="24" height="24" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
            </div>
            <div>
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Stok Rendah</p>
                <h4 class="text-xl font-bold text-gray-800 dark:text-white/90">{{ $lowStockCount }}</h4>
            </div>
        </div>
    </div>
</div>

{{-- Chart + Top Products --}}
<div class="grid grid-cols-12 gap-4 mb-6">
    <div class="col-span-12 xl:col-span-8">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Penjualan 7 Hari Terakhir</h3></div>
            <div class="p-6"><canvas id="weeklySalesChart" height="280"></canvas></div>
        </div>
    </div>
    <div class="col-span-12 xl:col-span-4">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] h-full">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Produk Terlaris</h3></div>
            <div class="p-0">
                @forelse($topProducts as $item)
                <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-3 last:border-0 dark:border-gray-800">
                    @if($item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" class="h-10 w-10 rounded-lg object-cover">
                    @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800"><svg class="fill-current" width="18" height="18" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate dark:text-white/90">{{ $item->product->name }}</p>
                        <p class="text-theme-xs text-gray-500">{{ $item->total_qty }} terjual</p>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-sm text-gray-500">Belum ada data.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">5 Transaksi Terakhir</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Kasir</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Total</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Metode</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentTransactions as $t)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-6 py-3"><p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $t->created_at->diffForHumans() }}</p><p class="text-theme-xs text-gray-500">{{ $t->created_at->format('H:i') }} WIB</p></td>
                <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $t->user->name }}</td>
                <td class="px-6 py-3 text-sm font-bold text-brand-500">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td class="px-6 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ strtoupper($t->payment_method) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody></table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('weeklySalesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($last7Days, 'date')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode(array_column($last7Days, 'sales')) !!},
                backgroundColor: 'rgba(70, 95, 255, 0.8)',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(v) {
                            if (v >= 1000000) return 'Rp ' + (v / 1000000) + 'jt';
                            if (v >= 1000) return 'Rp ' + (v / 1000) + 'k';
                            return 'Rp ' + v;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
