@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('content')
<div x-data="transactionHistory()">
{{-- Filter --}}
<div class="mb-4 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
    <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div>
            <label class="mb-1 block text-theme-xs text-gray-500">Cari ID</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ID Transaksi..." class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        </div>
        <div>
            <label class="mb-1 block text-theme-xs text-gray-500">Dari</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        </div>
        <div>
            <label class="mb-1 block text-theme-xs text-gray-500">Sampai</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        </div>
        <div>
            <label class="mb-1 block text-theme-xs text-gray-500">Kasir</label>
            <select name="user_id" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                <option value="">Semua</option>
                @foreach($users as $u)<option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>@endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="h-10 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600">Filter</button>
            <a href="{{ route('transactions.index') }}" class="h-10 rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 flex items-center hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300">Reset</a>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800"><h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Daftar Transaksi</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">ID</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Waktu</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Kasir</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Total</th>
            <th class="px-6 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Metode</th>
            <th class="px-6 py-3 text-center text-theme-xs font-medium uppercase text-gray-500">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($transactions as $t)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                <td class="px-6 py-3 text-sm font-bold text-gray-500">#{{ str_pad($t->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $t->user->name }}</td>
                <td class="px-6 py-3 text-sm font-bold text-brand-500">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td class="px-6 py-3"><span class="rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ strtoupper($t->payment_method) }}</span></td>
                <td class="px-6 py-3 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button @click="showDetail({{ $t->id }})" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 dark:border-gray-700"><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></button>
                        <a href="{{ route('transactions.print', $t->id) }}" target="_blank" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 dark:border-gray-700"><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody></table>
    </div>
    <div class="p-4">{{ $transactions->links() }}</div>
</div>

{{-- Detail Modal --}}
<div x-show="showModal" x-transition.opacity class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4" style="display:none;" @keydown.escape.window="showModal = false">
    <div @click.outside="showModal = false" class="w-full max-w-lg rounded-2xl bg-white shadow-theme-xl dark:bg-gray-900">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90" x-text="'Detail #' + String(selectedTransaction?.id||0).padStart(6,'0')"></h3>
            <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-4 py-2 text-left text-theme-xs font-medium text-gray-500">Produk</th>
                <th class="px-4 py-2 text-center text-theme-xs font-medium text-gray-500">Harga</th>
                <th class="px-4 py-2 text-center text-theme-xs font-medium text-gray-500">Qty</th>
                <th class="px-4 py-2 text-right text-theme-xs font-medium text-gray-500">Subtotal</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <template x-for="item in selectedTransaction?.items" :key="item.id">
                    <tr>
                        <td class="px-4 py-2"><p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="item.product?.name||'Dihapus'"></p></td>
                        <td class="px-4 py-2 text-center text-sm text-gray-500" x-text="'Rp ' + fmt(item.price)"></td>
                        <td class="px-4 py-2 text-center text-sm text-gray-500" x-text="item.quantity"></td>
                        <td class="px-4 py-2 text-right text-sm font-bold text-gray-800 dark:text-white/90" x-text="'Rp ' + fmt(item.subtotal)"></td>
                    </tr>
                </template>
            </tbody></table>
        </div>
        <div class="border-t border-gray-200 bg-gray-50 p-4 space-y-1 dark:border-gray-800 dark:bg-gray-800/50">
            <div class="flex justify-between text-sm"><span class="text-gray-500">Metode</span><span class="font-medium text-gray-800 dark:text-white/90 uppercase" x-text="selectedTransaction?.payment_method"></span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Total</span><span class="font-bold text-brand-500" x-text="'Rp ' + fmt(selectedTransaction?.total||0)"></span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Dibayar</span><span class="font-medium text-gray-800 dark:text-white/90" x-text="'Rp ' + fmt(selectedTransaction?.paid||0)"></span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Kembalian</span><span class="font-medium text-gray-800 dark:text-white/90" x-text="'Rp ' + fmt(selectedTransaction?.change||0)"></span></div>
        </div>
        <div class="flex gap-3 border-t border-gray-200 p-4 dark:border-gray-800">
            <button @click="showModal = false" class="flex-1 rounded-lg border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300">Tutup</button>
            <a :href="'/transactions/' + selectedTransaction?.id + '/print'" target="_blank" class="flex-1 rounded-lg bg-brand-500 py-2.5 text-center text-sm font-medium text-white hover:bg-brand-600">Cetak</a>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('transactionHistory', () => ({
        transactions: @json($transactions->items()),
        selectedTransaction: null, showModal: false,
        showDetail(id) { this.selectedTransaction = this.transactions.find(t => t.id === id); this.showModal = true; },
        fmt(a) { return new Intl.NumberFormat('id-ID').format(a); }
    }));
});
</script>
@endpush
