@extends('layouts.app')
@section('title', 'Kasir')
@section('page-title', 'Kasir')
@push('styles')
<style>
    .product-panel { height: calc(100vh - 180px); display: flex; flex-direction: column; }
    .product-grid { flex: 1; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .product-grid::-webkit-scrollbar { display: none; }
    .cart-container { height: calc(100vh - 180px); display: flex; flex-direction: column; }
    .cart-items { flex: 1; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
    .cart-items::-webkit-scrollbar { display: none; }
    .custom-select { appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25rem; padding-right: 2.5rem !important; }
    /* Hide spin buttons */
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }
</style>
@endpush
@section('content')
<div class="flex flex-col gap-4 lg:flex-row" x-data="posApp()">

    <div class="w-full flex-1 min-w-0 lg:w-2/3">
        <div class="product-panel rounded-2xl border border-gray-200 bg-white overflow-hidden">
 <div class="border-b border-gray-200 px-5 py-4 ">
 <form action="{{ route('pos.index') }}" method="GET" class="flex gap-2">
 <div class="relative flex-1"><span class="absolute left-3 top-1/2 -translate-y-1/2"><svg class="fill-gray-400" width="18" height="18" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></span>
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/SKU..." class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 "></div>
 <button type="submit" class="h-11 rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600">Cari</button>
 @if(request('search'))<a href="{{ route('pos.index') }}" class="h-11 rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 flex items-center hover:bg-gray-50 ">Reset</a>@endif
 </form>
 </div>
                <div class="product-grid p-3 bg-gray-50 ">
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">
                        @forelse($products as $product)
                            <div class="cursor-pointer rounded-xl border border-gray-200 bg-white p-0 shadow-theme-xs transition hover:-translate-y-1 hover:shadow-theme-md hover:border-brand-300 " @click="addToCart({{ json_encode($product) }})">
                                <div class="flex h-28 items-center justify-center overflow-hidden rounded-t-xl bg-gray-100 ">
                                    @if($product->image)<img src="{{ Storage::url($product->image) }}" class="h-full w-full object-cover">@else<svg class="fill-gray-300" width="36" height="36" viewBox="0 0 24 24"><path d="M20 2H4c-1 0-2 1-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>@endif
                                </div>
                                <div class="p-3">
 <p class="text-theme-xs text-gray-500 truncate">{{ $product->category ? $product->category->name : '-' }}</p>
 <p class="text-sm font-medium text-gray-800 truncate " title="{{ $product->name }}">{{ $product->name }}</p>
 <div class="mt-2 flex items-center justify-between">
 <span class="text-sm font-bold text-brand-500">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
 <span class="rounded-full bg-gray-100 px-2 py-0.5 text-theme-xs text-gray-600 ">{{ $product->stock }}</span>
 </div>
 </div>
 </div>
 @empty
 <div class="col-span-full py-12 text-center text-gray-500">Tidak ada produk ditemukan.</div>
 @endforelse
 </div>
 </div>

        </div>
    </div>

    <div class="w-full lg:w-1/3 lg:shrink-0">
 <div class="cart-container rounded-2xl border border-gray-200 bg-white overflow-hidden">
 <div class="flex items-center justify-between rounded-t-2xl bg-brand-500 px-5 py-4">
 <h5 class="font-bold text-white">Keranjang</h5>
 <span class="rounded-full bg-white/20 px-2.5 py-1 text-theme-xs font-medium text-white" x-text="cart.length + ' item'"></span>
 </div>
 <div class="cart-items bg-gray-50 ">
 <template x-if="cart.length === 0">
 <div class="flex h-full flex-col items-center justify-center p-6 text-center text-gray-400">
 <svg class="mb-3 fill-gray-300" width="48" height="48" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0020 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
 <p class="text-sm font-medium">Keranjang kosong</p>
 <p class="text-theme-xs">Klik produk untuk menambahkan</p>
 </div>
 </template>
 <div class="divide-y divide-gray-100 ">
 <template x-for="(item, index) in cart" :key="item.id">
                                <div class="p-4 border-b border-gray-100 last:border-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1 min-w-0 pr-4">
                                            <p class="text-sm font-medium text-gray-800 truncate" x-text="item.name"></p>
                                            <p class="text-xs text-gray-500" x-text="'Rp ' + formatRupiah(item.price)"></p>
                                        </div>
                                        <button @click="removeItem(index)" class="text-error-400 hover:text-error-500 transition-colors">
                                            <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1">
                                            <button @click="updateQuantity(index, -1)" class="flex h-7 w-7 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 ">−</button>
                                            <input type="number" class="h-8 w-12 rounded-lg border border-gray-200 text-center text-sm focus:border-brand-300 focus:ring-1 focus:ring-brand-500/10" x-model.number="item.quantity" @change="checkQuantity(index)" min="1" :max="item.stock">
                                            <button @click="updateQuantity(index, 1)" class="flex h-7 w-7 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 ">+</button>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800" x-text="'Rp ' + formatRupiah(item.price * item.quantity)"></p>
                                    </div>
                                </div>
 </template>
 </div>
 </div>
 <div class="border-t border-gray-200 p-4 ">
 <div class="mb-2 flex justify-between text-sm text-gray-500"><span>Total Item</span><span x-text="totalItems() + ' item'"></span></div>
 <div class="mb-4 flex items-center justify-between"><h5 class="font-bold text-gray-800 ">Total</h5><h4 class="text-xl font-bold text-brand-500" x-text="'Rp ' + formatRupiah(totalPrice())"></h4></div>
 <button @click="checkout()" class="w-full rounded-lg bg-success-500 py-3 text-sm font-bold text-white hover:bg-success-600 disabled:opacity-50" :disabled="cart.length === 0">Proses Pembayaran</button>
                                <button type="button" @click="cart = []" x-show="cart.length > 0" class="mt-2 w-full rounded-lg border border-error-300 py-2.5 text-sm font-medium text-error-500 hover:bg-error-50 ">Kosongkan</button>
 </div>
 </div>
 </div>

 <div x-show="showModal" x-transition.opacity class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4" @keydown.escape.window="showModal = false" style="display:none;">
 <div @click.outside="showModal = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-theme-xl ">
 <h3 class="mb-4 text-lg font-semibold text-gray-800 ">Proses Pembayaran</h3>
 <div class="mb-5 text-center"><p class="text-sm text-gray-500">Total Tagihan</p><h2 class="text-2xl font-bold text-brand-500" x-text="'Rp ' + formatRupiah(totalPrice())"></h2></div>
 <div class="mb-4">
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Metode Pembayaran</label>
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="custom-select-trigger">
                            <span x-text="paymentMethod === 'cash' ? 'Tunai (Cash)' : 'Transfer / QRIS'"></span>
                            <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown">
                            <div @click="paymentMethod = 'cash'; open = false; paidAmount = 0;"
                                class="custom-select-option flex items-center justify-between"
                                :class="paymentMethod === 'cash' ? 'custom-select-option-active' : 'custom-select-option-inactive'">
                                <span>Tunai (Cash)</span>
                                <svg x-show="paymentMethod === 'cash'" class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            </div>
                            <div @click="paymentMethod = 'transfer'; open = false; paidAmount = totalPrice();"
                                class="custom-select-option flex items-center justify-between"
                                :class="paymentMethod === 'transfer' ? 'custom-select-option-active' : 'custom-select-option-inactive'">
                                <span>Transfer / QRIS</span>
                                <svg x-show="paymentMethod === 'transfer'" class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QRIS Barcode -->
                <div class="mb-4 text-center" x-show="paymentMethod === 'transfer'" x-transition>
                    <div class="inline-block p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                        <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wider">Scan QRIS untuk Pembayaran</p>
                        <img src="{{ asset('img/qris_v2.jpg') }}" alt="QRIS Toko Muna" class="mx-auto w-64 h-auto rounded-lg">
                        <div class="mt-2 flex items-center justify-center gap-2">
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-50 text-blue-600 rounded uppercase">GOPAY</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-red-50 text-red-600 rounded uppercase">OVO</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-orange-50 text-orange-600 rounded uppercase">SHOPEEPAY</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-green-50 text-green-600 rounded uppercase">DANA</span>
                        </div>
                    </div>
                </div>

 <div class="mb-4" x-show="paymentMethod === 'cash'">
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Nominal (Rp)</label>
 <input type="number" x-model.number="paidAmount" min="0" class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 <div class="mt-2 flex gap-2">
 <button type="button" @click="paidAmount = totalPrice()" class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 hover:bg-gray-50 ">Uang Pas</button>
 <button type="button" @click="paidAmount = 50000" class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 hover:bg-gray-50 ">50K</button>
 <button type="button" @click="paidAmount = 100000" class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-700 hover:bg-gray-50 ">100K</button>
 </div>
 </div>
 <div class="mb-4 rounded-lg bg-gray-50 p-3 " x-show="paymentMethod === 'cash'">
 <div class="flex items-center justify-between"><span class="text-sm text-gray-500">Kembalian</span><span class="text-lg font-bold" :class="changeAmount() < 0 ? 'text-error-500' : 'text-success-500'" x-text="'Rp ' + formatRupiah(changeAmount())"></span></div>
 </div>
 <div x-show="errorMsg" class="mb-4 rounded-lg bg-error-50 p-3 text-sm text-error-500 " x-text="errorMsg"></div>
 <div class="flex gap-3">
 <button @click="showModal = false" class="flex-1 rounded-lg border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Batal</button>
 <button @click="processPayment()" :disabled="isProcessing || (paymentMethod === 'cash' && changeAmount() < 0)" class="flex-1 rounded-lg bg-success-500 py-2.5 text-sm font-bold text-white hover:bg-success-600 disabled:opacity-50">
 <span x-show="!isProcessing">Bayar</span><span x-show="isProcessing">Memproses...</span>
 </button>
 </div>
 </div>
 </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
 Alpine.data('posApp', () => ({
 cart: [], paymentMethod: 'cash', paidAmount: 0, showModal: false, isProcessing: false, errorMsg: '',
 init() {
 const saved = localStorage.getItem('pos_cart');
 if (saved) { try { this.cart = JSON.parse(saved); } catch(e) { this.cart = []; } }
 this.$watch('cart', v => localStorage.setItem('pos_cart', JSON.stringify(v)));
 },
 addToCart(product) {
 const existing = this.cart.find(i => i.id === product.id);
 if (existing) { if (existing.quantity < product.stock) existing.quantity++; else alert('Stok tidak mencukupi!'); }
 else { if (product.stock > 0) this.cart.push({ id: product.id, name: product.name, price: parseFloat(product.price), stock: product.stock, quantity: 1 }); else alert('Stok habis!'); }
 },
 updateQuantity(index, change) {
 const item = this.cart[index]; const nq = item.quantity + change;
 if (nq > 0 && nq <= item.stock) item.quantity = nq;
 else if (nq <= 0) { if(confirm('Hapus item?')) this.removeItem(index); }
 else alert('Stok max: ' + item.stock);
 },
 checkQuantity(index) { const item = this.cart[index]; if (item.quantity <= 0) item.quantity = 1; else if (item.quantity > item.stock) { item.quantity = item.stock; alert('Stok max: ' + item.stock); } },
 removeItem(index) { this.cart.splice(index, 1); },
 clearCart() { if(window.confirm("Kosongkan seluruh isi keranjang?")) this.cart = []; },
 totalItems() { return this.cart.reduce((t, i) => t + parseInt(i.quantity), 0); },
 totalPrice() { return this.cart.reduce((t, i) => t + (i.price * i.quantity), 0); },
 formatRupiah(a) { return new Intl.NumberFormat('id-ID').format(a); },
 changeAmount() { return this.paidAmount - this.totalPrice(); },
 checkout() { this.errorMsg = ''; this.paymentMethod = 'cash'; this.paidAmount = 0; this.showModal = true; },
 async processPayment() {
 if (this.paymentMethod === 'cash' && this.changeAmount() < 0) { this.errorMsg = 'Nominal kurang!'; return; }
 this.isProcessing = true; this.errorMsg = '';
 try {
 const res = await axios.post('/pos/checkout', { items: this.cart, payment_method: this.paymentMethod, paid: this.paymentMethod === 'cash' ? this.paidAmount : this.totalPrice() });
 if (res.data.success) { this.cart = []; this.showModal = false; window.open('/transactions/' + res.data.transaction_id + '/print', '_blank'); setTimeout(() => window.location.reload(), 500); }
 } catch(e) { this.errorMsg = e.response?.data?.message || 'Error sistem.'; } finally { this.isProcessing = false; }
 }
 }));
});
</script>
@endpush
