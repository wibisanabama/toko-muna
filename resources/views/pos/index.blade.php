@extends('layouts.app')

@section('title', 'Kasir')
@section('page-title', 'Point of Sale (Kasir)')

@push('styles')
<style>
    .product-card {
        cursor: pointer;
        transition: all 0.2s;
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        border-color: var(--primary) !important;
    }
    .cart-container {
        height: calc(100vh - 180px);
        display: flex;
        flex-direction: column;
    }
    .cart-items {
        flex: 1;
        overflow-y: auto;
    }
    .product-grid {
        height: calc(100vh - 250px);
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
<div class="row g-4" x-data="posApp()">
    <!-- Bagian Kiri: Produk -->
    <div class="col-lg-8">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <form action="{{ route('pos.index') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari nama produk atau SKU...">
                    </div>
                    <button type="submit" class="btn btn-primary px-4">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('pos.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </form>
            </div>
            <div class="card-body bg-light product-grid p-4">
                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-md-4 col-sm-6">
                            <div class="card product-card shadow-sm" @click="addToCart({{ json_encode($product) }})">
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <i class="bi bi-box-seam text-secondary" style="font-size: 3rem;"></i>
                                    @endif
                                </div>
                                <div class="card-body p-3">
                                    <small class="text-muted d-block mb-1 text-truncate">{{ $product->category ? $product->category->name : 'Uncategorized' }}</small>
                                    <h6 class="card-title text-dark mb-2 text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="badge bg-secondary">Stok: {{ $product->stock }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">Tidak ada produk ditemukan.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan: Keranjang -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm cart-container">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2"></i>Keranjang</h5>
                <span class="badge bg-light text-primary rounded-pill" x-text="cart.length + ' item'">0 item</span>
            </div>
            
            <div class="card-body p-0 cart-items bg-light">
                <template x-if="cart.length === 0">
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted p-4 text-center">
                        <i class="bi bi-cart-x mb-3" style="font-size: 4rem; opacity: 0.5;"></i>
                        <h6>Keranjang masih kosong</h6>
                        <small>Klik produk di sebelah kiri untuk menambahkan ke keranjang.</small>
                    </div>
                </template>

                <div class="list-group list-group-flush">
                    <template x-for="(item, index) in cart" :key="item.id">
                        <div class="list-group-item p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1" x-text="item.name"></h6>
                                    <small class="text-muted" x-text="'Rp ' + formatRupiah(item.price)"></small>
                                </div>
                                <button @click="removeItem(index)" class="btn btn-link text-danger p-0 ms-2" title="Hapus item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" type="button" @click="updateQuantity(index, -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control text-center px-1" x-model.number="item.quantity" @change="checkQuantity(index)" min="1" :max="item.stock">
                                    <button class="btn btn-outline-secondary" type="button" @click="updateQuantity(index, 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <span class="fw-bold" x-text="'Rp ' + formatRupiah(item.price * item.quantity)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="card-footer bg-white p-3 shadow-sm border-top-0">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Item</span>
                    <span class="fw-medium" x-text="totalItems() + ' item'"></span>
                </div>
                <div class="d-flex justify-content-between mb-4 align-items-center">
                    <h5 class="mb-0 fw-bold">Total Harga</h5>
                    <h4 class="mb-0 fw-bold text-primary" x-text="'Rp ' + formatRupiah(totalPrice())">Rp 0</h4>
                </div>
                
                <button @click="checkout()" class="btn btn-success w-100 py-2 fw-bold" :disabled="cart.length === 0">
                    <i class="bi bi-check-circle me-2"></i>Proses Pembayaran
                </button>
                <button @click="clearCart()" x-show="cart.length > 0" class="btn btn-outline-danger w-100 py-2 mt-2 fw-bold">
                    Kosongkan Keranjang
                </button>
            </div>
        </div>
    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true" x-ref="checkoutModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="checkoutModalLabel">Proses Pembayaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <p class="text-muted mb-1">Total Tagihan</p>
                        <h2 class="text-primary fw-bold mb-0" x-text="'Rp ' + formatRupiah(totalPrice())">Rp 0</h2>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <select class="form-select" x-model="paymentMethod" @change="if(paymentMethod !== 'cash') paidAmount = totalPrice()">
                            <option value="cash">Tunai (Cash)</option>
                            <option value="transfer">Transfer Bank / QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3" x-show="paymentMethod === 'cash'">
                        <label class="form-label fw-bold">Nominal Uang (Rp)</label>
                        <input type="number" class="form-control form-control-lg" x-model.number="paidAmount" min="0" placeholder="0">
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-secondary btn-sm" @click="paidAmount = totalPrice()">Uang Pas</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" @click="paidAmount = 50000">50.000</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" @click="paidAmount = 100000">100.000</button>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded" x-show="paymentMethod === 'cash'">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-bold">Kembalian</span>
                            <h4 class="mb-0 fw-bold" :class="changeAmount() < 0 ? 'text-danger' : 'text-success'" x-text="'Rp ' + formatRupiah(changeAmount())">Rp 0</h4>
                        </div>
                    </div>

                    <div class="alert alert-danger mt-3" x-show="errorMsg" x-text="errorMsg"></div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success px-4" @click="processPayment()" :disabled="isProcessing || (paymentMethod === 'cash' && changeAmount() < 0)">
                        <span x-show="!isProcessing"><i class="bi bi-check-circle me-2"></i>Selesaikan Pembayaran</span>
                        <span x-show="isProcessing"><span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('posApp', () => ({
            cart: [],
            paymentMethod: 'cash',
            paidAmount: 0,
            modalInstance: null,
            isProcessing: false,
            errorMsg: '',
            
            init() {
                const savedCart = localStorage.getItem('pos_cart');
                if (savedCart) {
                    try {
                        this.cart = JSON.parse(savedCart);
                    } catch (e) {
                        this.cart = [];
                    }
                }
                
                this.$watch('cart', value => {
                    localStorage.setItem('pos_cart', JSON.stringify(value));
                });
            },
            
            addToCart(product) {
                const existingItem = this.cart.find(item => item.id === product.id);
                
                if (existingItem) {
                    if (existingItem.quantity < product.stock) {
                        existingItem.quantity++;
                    } else {
                        alert('Stok tidak mencukupi!');
                    }
                } else {
                    if (product.stock > 0) {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            price: parseFloat(product.price),
                            stock: product.stock,
                            quantity: 1
                        });
                    } else {
                        alert('Stok produk habis!');
                    }
                }
            },
            
            updateQuantity(index, change) {
                const item = this.cart[index];
                const newQuantity = item.quantity + change;
                
                if (newQuantity > 0 && newQuantity <= item.stock) {
                    item.quantity = newQuantity;
                } else if (newQuantity <= 0) {
                    if(confirm('Hapus item dari keranjang?')) {
                        this.removeItem(index);
                    }
                } else {
                    alert('Stok maksimal adalah ' + item.stock);
                }
            },
            
            checkQuantity(index) {
                const item = this.cart[index];
                if (item.quantity <= 0) {
                    item.quantity = 1;
                } else if (item.quantity > item.stock) {
                    item.quantity = item.stock;
                    alert('Stok maksimal adalah ' + item.stock);
                }
            },
            
            removeItem(index) {
                this.cart.splice(index, 1);
            },
            
            clearCart() {
                if(confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                    this.cart = [];
                }
            },
            
            totalItems() {
                return this.cart.reduce((total, item) => total + parseInt(item.quantity), 0);
            },
            
            totalPrice() {
                return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            },
            
            formatRupiah(amount) {
                return new Intl.NumberFormat('id-ID').format(amount);
            },
            
            changeAmount() {
                return this.paidAmount - this.totalPrice();
            },
            
            checkout() {
                this.errorMsg = '';
                this.paymentMethod = 'cash';
                this.paidAmount = 0;
                
                if (!this.modalInstance) {
                    this.modalInstance = new bootstrap.Modal(this.$refs.checkoutModal);
                }
                this.modalInstance.show();
            },

            async processPayment() {
                if (this.paymentMethod === 'cash' && this.changeAmount() < 0) {
                    this.errorMsg = 'Nominal pembayaran kurang dari total tagihan!';
                    return;
                }

                this.isProcessing = true;
                this.errorMsg = '';

                try {
                    const response = await axios.post('/pos/checkout', {
                        items: this.cart,
                        payment_method: this.paymentMethod,
                        paid: this.paymentMethod === 'cash' ? this.paidAmount : this.totalPrice(),
                    });

                    if (response.data.success) {
                        this.cart = []; // clear cart
                        this.modalInstance.hide();
                        alert(`Transaksi Berhasil!\nKembalian: Rp ${this.formatRupiah(response.data.change)}`);
                        window.location.reload(); // Reload to refresh stock UI
                    }
                } catch (error) {
                    this.errorMsg = error.response?.data?.message || 'Terjadi kesalahan sistem.';
                } finally {
                    this.isProcessing = false;
                }
            }
        }));
    });
</script>
@endpush
