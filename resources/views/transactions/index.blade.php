@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('content')
@push('styles')
<style>
    .transaction-list-container { height: 400px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .transaction-list-container::-webkit-scrollbar { display: none; }
    .transaction-panel { height: 560px; display: flex; flex-direction: column; overflow: hidden; }
    @media print {
        .transaction-panel { display: block !important; height: auto !important; overflow: visible !important; border: none !important; }
        .transaction-list-container { display: block !important; height: auto !important; overflow: visible !important; scrollbar-width: none !important; -ms-overflow-style: none !important; }
        .transaction-list-container::-webkit-scrollbar { display: none !important; }
        .no-print { display: none !important; }
        body { background: white !important; overflow: visible !important; }
        .rounded-2xl { border: none !important; box-shadow: none !important; }
        .flex-none, .flex-1 { display: block !important; }
    }
</style>
@endpush
<div x-data="transactionHistory()">

<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 ">
 <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
 <div>
 <label class="mb-1 block text-theme-xs text-gray-500">Cari ID</label>
 <input type="text" name="search" value="{{ request('search') }}" placeholder="ID Transaksi..." class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm ">
 </div>
 <div>
 <label class="mb-1 block text-theme-xs text-gray-500">Dari</label>
 <input type="date" name="start_date" value="{{ request('start_date') }}" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm ">
 </div>
 <div>
 <label class="mb-1 block text-theme-xs text-gray-500">Sampai</label>
 <input type="date" name="end_date" value="{{ request('end_date') }}" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm ">
 </div>
 <div>
 <label class="mb-1 block text-theme-xs text-gray-500">Kasir</label>
                    <div class="relative w-full" x-data="{ open: false, selected: '{{ request('user_id') ? ($users->firstWhere('id', request('user_id'))->name ?? 'Semua') : 'Semua' }}' }">
                        <button type="button" @click="open = !open" class="custom-select-trigger h-10 px-3">
                            <span x-text="selected"></span>
                            <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown">
                            <div @click="selected = 'Semua'; open = false; $refs.userInput.value = '';" class="custom-select-option" :class="!$refs.userInput.value ? 'custom-select-option-active' : 'custom-select-option-inactive'">Semua</div>
                            @foreach($users as $u)
                            <div @click="selected = '{{ $u->name }}'; open = false; $refs.userInput.value = '{{ $u->id }}';" class="custom-select-option" :class="$refs.userInput.value == '{{ $u->id }}' ? 'custom-select-option-active' : 'custom-select-option-inactive'">{{ $u->name }}</div>
                            @endforeach
                        </div>
                        <input type="hidden" name="user_id" x-ref="userInput" value="{{ request('user_id') }}">
                    </div>
 </div>
  <div class="flex items-end gap-2 w-full">
  <button type="submit" class="h-10 flex-1 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600">Filter</button>
  @if(request()->anyFilled(['search', 'start_date', 'end_date', 'user_id']))
  <a href="{{ route('transactions.index') }}" class="h-10 flex-1 rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 flex items-center justify-center hover:bg-gray-50 ">Reset</a>
  @endif
  </div>
 </form>
</div>

<div class="transaction-panel rounded-2xl border border-gray-200 bg-white ">
 <div class="flex-none border-b border-gray-200 px-6 py-4 "><h3 class="text-lg font-semibold text-gray-800 ">Daftar Transaksi</h3></div>
 <div class="flex-1 overflow-x-auto transaction-list-container">
 <table class="w-full"><thead><tr class="border-b border-gray-100 ">
 <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">ID</th>
 <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
 <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Kasir</th>
 <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Total</th>
 <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Metode</th>
 <th class="px-6 py-3 text-center text-theme-xs font-medium uppercase text-gray-500">Aksi</th>
 </tr></thead>
 <tbody class="divide-y divide-gray-100 ">
 @forelse($transactions as $t)
 <tr class="hover:bg-gray-50 ">
 <td class="px-6 py-3 text-sm font-bold text-gray-500">#{{ str_pad($t->id, 6, '0', STR_PAD_LEFT) }}</td>
 <td class="px-6 py-3 text-sm text-gray-700 ">{{ $t->created_at->format('d/m/Y H:i') }}</td>
 <td class="px-6 py-3 text-sm text-gray-700 ">{{ $t->user->name }}</td>
 <td class="px-6 py-3 text-sm font-bold text-brand-500">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
 <td class="px-6 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 ">{{ strtoupper($t->payment_method) }}</span></td>
 <td class="px-6 py-3 text-center">
 <div class="flex items-center justify-center gap-2">
 <button @click="showDetail({{ $t->id }})" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 "><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></button>
 <a href="{{ route('transactions.print', $t->id) }}" target="_blank" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 "><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg></a>
 </div>
 </td>
 </tr>
 @empty
 <tr><td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada transaksi.</td></tr>
 @endforelse
 </tbody></table>
 </div>
</div>

<div x-show="showModal" x-transition.opacity class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4" style="display:none;" @keydown.escape.window="showModal = false">
 <div @click.outside="showModal = false" class="w-full max-w-lg rounded-2xl bg-white shadow-theme-xl ">
 <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 ">
 <h3 class="text-lg font-semibold text-gray-800 " x-text="'Detail #' + String(selectedTransaction?.id||0).padStart(6,'0')"></h3>
 <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
 </div>
 <div class="overflow-x-auto">
 <table class="w-full"><thead><tr class="border-b border-gray-100 ">
 <th class="px-4 py-2 text-left text-theme-xs font-medium text-gray-500">Produk</th>
 <th class="px-4 py-2 text-center text-theme-xs font-medium text-gray-500">Harga</th>
 <th class="px-4 py-2 text-center text-theme-xs font-medium text-gray-500">Qty</th>
 <th class="px-4 py-2 text-right text-theme-xs font-medium text-gray-500">Subtotal</th>
 </tr></thead>
 <tbody class="divide-y divide-gray-100 ">
 <template x-for="item in selectedTransaction?.items" :key="item.id">
 <tr>
 <td class="px-4 py-2"><p class="text-sm font-medium text-gray-800 " x-text="item.product?.name||'Dihapus'"></p></td>
 <td class="px-4 py-2 text-center text-sm text-gray-500" x-text="'Rp ' + fmt(item.price)"></td>
 <td class="px-4 py-2 text-center text-sm text-gray-500" x-text="item.quantity"></td>
 <td class="px-4 py-2 text-right text-sm font-bold text-gray-800 " x-text="'Rp ' + fmt(item.subtotal)"></td>
 </tr>
 </template>
 </tbody></table>
 </div>
 <div class="border-t border-gray-200 bg-gray-50 p-4 space-y-1 ">
 <div class="flex justify-between text-sm"><span class="text-gray-500">Metode</span><span class="font-medium text-gray-800 uppercase" x-text="selectedTransaction?.payment_method"></span></div>
 <div class="flex justify-between text-sm"><span class="text-gray-500">Total</span><span class="font-bold text-brand-500" x-text="'Rp ' + fmt(selectedTransaction?.total||0)"></span></div>
 <div class="flex justify-between text-sm"><span class="text-gray-500">Dibayar</span><span class="font-medium text-gray-800 " x-text="'Rp ' + fmt(selectedTransaction?.paid||0)"></span></div>
 <div class="flex justify-between text-sm"><span class="text-gray-500">Kembalian</span><span class="font-medium text-gray-800 " x-text="'Rp ' + fmt(selectedTransaction?.change||0)"></span></div>
 </div>
  <div class="border-t border-gray-200 p-4 ">
  <button @click="showModal = false" class="w-full rounded-lg bg-gray-100 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 ">Tutup</button>
  </div>
 </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
 Alpine.data('transactionHistory', () => ({
 transactions: @json($transactions),
 selectedTransaction: null, showModal: false,
 showDetail(id) { this.selectedTransaction = this.transactions.find(t => t.id === id); this.showModal = true; },
 fmt(a) { return new Intl.NumberFormat('id-ID').format(a); }
 }));
});
</script>
@endpush
