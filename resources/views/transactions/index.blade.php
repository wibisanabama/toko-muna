@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('transactions.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari ID Transaksi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="payment_method" class="form-select">
                    <option value="">Semua Metode Pembayaran</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
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
                            <button class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </button>
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
@endsection
