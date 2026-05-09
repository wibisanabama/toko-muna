@extends('layouts.app')
@section('title', 'Laporan Bulanan')
@section('page-title', 'Laporan Penjualan Bulanan')
@section('content')
{{-- Filter --}}
<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
    <form action="{{ route('reports.monthly') }}" method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-400">Bulan</label>
            <select name="month" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                @foreach(range(1, 12) as $m)
                <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-400">Tahun</label>
            <select name="year" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                @foreach(range(date('Y')-2, date('Y')) as $y)<option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>@endforeach
            </select>
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

{{-- Charts --}}
<div class="grid grid-cols-12 gap-4 mb-6">
    <div class="col-span-12 xl:col-span-8">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Grafik Penjualan</h3></div>
            <div class="p-6"><canvas id="salesChart" height="300"></canvas></div>
        </div>
    </div>
    <div class="col-span-12 xl:col-span-4">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] h-full">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Metode Bayar</h3></div>
            <div class="flex items-center justify-center p-6">
                @php $cashCount = $transactions->where('payment_method', 'cash')->count(); $transferCount = $transactions->where('payment_method', 'transfer')->count(); @endphp
                @if($transactions->count() > 0)<canvas id="methodChart"></canvas>@else<p class="text-sm text-gray-500">Data tidak tersedia</p>@endif
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Ringkasan Harian - {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Tanggal</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Jumlah Transaksi</th>
            <th class="px-6 py-3 text-right text-theme-xs font-medium uppercase text-gray-500">Total Pendapatan</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @php $totalRev = 0; $totalTrans = 0; @endphp
            @foreach(array_reverse($chartData) as $data)
                @if($data['revenue'] > 0)
                @php $totalRev += $data['revenue']; $dayCount = $transactions->filter(fn($t) => $t->created_at->format('d') == $data['day'])->count(); $totalTrans += $dayCount; @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $data['day'] }} {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $dayCount }}</td>
                    <td class="px-6 py-3 text-right text-sm font-bold text-brand-500">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
        @if($totalRev > 0)
        <tfoot><tr class="border-t-2 border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
            <td class="px-6 py-3 text-sm font-bold text-gray-800 dark:text-white/90">TOTAL</td>
            <td class="px-6 py-3 text-sm font-bold text-gray-800 dark:text-white/90">{{ $totalTrans }}</td>
            <td class="px-6 py-3 text-right text-sm font-bold text-brand-500">Rp {{ number_format($totalRev, 0, ',', '.') }}</td>
        </tr></tfoot>
        @else
        <tbody><tr><td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada data.</td></tr></tbody>
        @endif
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'line',
        data: { labels: {!! json_encode(array_column($chartData, 'day')) !!}, datasets: [{ label: 'Pendapatan', data: {!! json_encode(array_column($chartData, 'revenue')) !!}, borderColor: '#465fff', backgroundColor: 'rgba(70,95,255,0.1)', borderWidth: 3, fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: '#465fff' }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString() } } } }
    });
    @if($transactions->count() > 0)
    new Chart(document.getElementById('methodChart').getContext('2d'), {
        type: 'doughnut',
        data: { labels: ['Cash', 'Transfer'], datasets: [{ data: [{{ $cashCount }}, {{ $transferCount }}], backgroundColor: ['#12b76a', '#465fff'], borderWidth: 0 }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
    @endif
});
</script>
@endpush
