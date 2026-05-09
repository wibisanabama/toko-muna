@extends('layouts.app')
@section('title', 'Laporan Bulanan')
@section('page-title', 'Laporan Penjualan Bulanan')
@section('content')

<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 relative z-20">
 <form action="{{ route('reports.monthly') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
 <div class="grid grid-cols-2 gap-3">
 <div>
 <label class="mb-1 block text-sm font-medium text-gray-700 ">Bulan</label>
 <div class="relative w-full" x-data="{ open: false, selected: '{{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }}' }">
 <button type="button" @click="open = !open" class="custom-select-trigger w-full">
 <span x-text="selected"></span>
 <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
 </button>
 <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown max-h-28 overflow-y-auto w-full">
 @foreach(range(1, 12) as $m)
 <div @click="selected = '{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}'; open = false; $refs.monthInput.value = '{{ sprintf('%02d', $m) }}';" class="custom-select-option" :class="$refs.monthInput.value == '{{ sprintf('%02d', $m) }}' ? 'custom-select-option-active' : 'custom-select-option-inactive'">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</div>
 @endforeach
 </div>
 <input type="hidden" name="month" x-ref="monthInput" value="{{ $month }}">
 </div>
 </div>
 <div>
 <label class="mb-1 block text-sm font-medium text-gray-700 ">Tahun</label>
 <div class="relative w-full" x-data="{ open: false, selected: '{{ $year }}' }">
 <button type="button" @click="open = !open" class="custom-select-trigger w-full">
 <span x-text="selected"></span>
 <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
 </button>
 <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown w-full">
 @foreach(range(date('Y')-2, date('Y')) as $y)
 <div @click="selected = '{{ $y }}'; open = false; $refs.yearInput.value = '{{ $y }}';" class="custom-select-option" :class="$refs.yearInput.value == '{{ $y }}' ? 'custom-select-option-active' : 'custom-select-option-inactive'">{{ $y }}</div>
 @endforeach
 </div>
 <input type="hidden" name="year" x-ref="yearInput" value="{{ $year }}">
 </div>
 </div>
 </div>
 <div class="flex items-end gap-3 w-full">
 <button type="submit" class="h-11 flex-1 rounded-lg bg-brand-500 px-6 text-sm font-medium text-white hover:bg-brand-600">Tampilkan</button>
 <button type="button" onclick="window.print()" class="no-print h-11 flex-1 rounded-lg border border-gray-300 px-5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Cetak</button>
 </div>
 </form>
</div>

<div class="grid grid-cols-1 gap-2 sm:grid-cols-3 mb-4">
 <div class="rounded-xl border border-gray-200 bg-white p-4 flex flex-col justify-center">
 <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-500 mb-1">Total Pendapatan</p>
 <h3 class="text-lg font-bold text-brand-500 leading-none">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h3>
 </div>
 <div class="rounded-xl border border-gray-200 bg-white p-4 flex flex-col justify-center">
 <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-500 mb-1">Total Transaksi</p>
 <h3 class="text-lg font-bold text-gray-800 leading-none">{{ $summary['total_transactions'] }}</h3>
 </div>
 <div class="rounded-xl border border-gray-200 bg-white p-4 flex flex-col justify-center">
 <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-500 mb-1">Rata-rata</p>
 <h3 class="text-lg font-bold text-gray-800 leading-none">Rp {{ number_format($summary['average_transaction'], 0, ',', '.') }}</h3>
 </div>
</div>

<div class="rounded-xl border border-gray-200 bg-white overflow-hidden flex flex-col" style="height: 400px !important;">
 <div class="border-b border-gray-200 px-6 py-3 flex-none"><h3 class="text-sm font-bold text-gray-800 ">Ringkasan Harian - {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}</h3></div>
 <div class="flex-1 overflow-y-auto no-scrollbar">
 <table class="w-full text-sm">
 <thead class="sticky top-0 bg-white z-10"><tr class="border-b border-gray-100 ">
 <th class="px-6 py-3 text-left text-[10px] font-bold uppercase text-gray-500">Tanggal</th>
 <th class="px-6 py-3 text-left text-[10px] font-bold uppercase text-gray-500">Jumlah Transaksi</th>
 <th class="px-6 py-3 text-right text-[10px] font-bold uppercase text-gray-500">Total Pendapatan</th>
 </tr></thead>
 <tbody class="divide-y divide-gray-100 ">
 @php $totalRev = 0; $totalTrans = 0; @endphp
 @foreach(array_reverse($chartData) as $data)
 @if($data['revenue'] > 0)
 @php $totalRev += $data['revenue']; $dayCount = $transactions->filter(fn($t) => $t->created_at->format('d') == $data['day'])->count(); $totalTrans += $dayCount; @endphp
 <tr class="hover:bg-gray-50 ">
 <td class="px-6 py-3 text-gray-700 ">{{ $data['day'] }} {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }}</td>
 <td class="px-6 py-3 text-gray-500">{{ $dayCount }}</td>
 <td class="px-6 py-3 text-right font-bold text-brand-500">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</td>
 </tr>
 @endif
 @endforeach
 </tbody>
 </table>
 </div>
 @if($totalRev > 0)
 <div class="border-t border-gray-200 bg-white px-6 py-3 flex-none">
 <div class="flex justify-between items-center font-bold text-sm">
 <div class="text-gray-800 ">TOTAL ({{ $totalTrans }} Transaksi)</div>
 <div class="text-brand-500">Rp {{ number_format($totalRev, 0, ',', '.') }}</div>
 </div>
 </div>
 @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
});
</script>
@endpush
