@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div x-data="transactionHistory()">
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('transactions.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted small">Cari ID</label>
                    <input type="text" name="search" class="form-control" placeholder="ID Transaksi..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Kasir</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua Kasir</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Metode Bayar</label>
                    <select name="payment_method" class="form-select">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
                <div class="col-md-9 d-flex align-items-end justify-content-end gap-2">
                    <a href="{{ route('transactions.index') }}" class="btn btn-light px-4">Reset</a>
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                </div>
            </form>
        </div>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Daftar Transaksi</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Waktu</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="ps-4 fw-bold text-muted">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td class="fw-bold text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ strtoupper($transaction->payment_method) }}</span></td>
                        <td class="text-center pe-4">
                            <button type="button" class="btn btn-sm btn-outline-info" @click="showDetail({{ $transaction->id }})" title="Detail Transaksi">
                                <i class="bi bi-eye"></i>
                            </button>
                            <a href="{{ route('transactions.print', $transaction->id) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Cetak Struk">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailModal" tabindex="-1" x-ref="detailModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" x-show="selectedTransaction">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" x-text="'Detail Transaksi #' + String(selectedTransaction?.id).padStart(6, '0')">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in selectedTransaction?.items" :key="item.id">
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold" x-text="item.product?.name || 'Produk Dihapus'"></div>
                                        <small class="text-muted" x-text="'SKU: ' + (item.product?.sku || '-')"></small>
                                    </td>
                                    <td class="text-center align-middle" x-text="'Rp ' + formatRupiah(item.price)"></td>
                                    <td class="text-center align-middle" x-text="item.quantity"></td>
                                    <td class="text-end pe-4 align-middle fw-bold" x-text="'Rp ' + formatRupiah(item.subtotal)"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-light border-top">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Metode Pembayaran:</span>
                        <span class="fw-bold text-uppercase" x-text="selectedTransaction?.payment_method"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Tagihan:</span>
                        <span class="fw-bold text-primary" x-text="'Rp ' + formatRupiah(selectedTransaction?.total || 0)"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Uang Dibayar:</span>
                        <span class="fw-bold" x-text="'Rp ' + formatRupiah(selectedTransaction?.paid || 0)"></span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Kembalian:</span>
                        <span class="fw-bold" x-text="'Rp ' + formatRupiah(selectedTransaction?.change || 0)"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a :href="'/transactions/' + selectedTransaction?.id + '/print'" target="_blank" class="btn btn-primary">
                    <i class="bi bi-printer me-2"></i>Cetak Ulang
                </a>
            </div>
        </div>
    </div>
</div>

</div> <!-- end x-data -->

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('transactionHistory', () => ({
        transactions: @json($transactions->items()),
        selectedTransaction: null,
        modalInstance: null,
        
        showDetail(id) {
            this.selectedTransaction = this.transactions.find(t => t.id === id);
            if (!this.modalInstance) {
                this.modalInstance = new bootstrap.Modal(this.$refs.detailModal);
            }
            this.modalInstance.show();
        },

        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }
    }));
});
</script>
@endpush
@endsection
