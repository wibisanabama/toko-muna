@extends('layouts.app')

@section('title', 'Laporan Harian')
@section('page-title', 'Laporan Penjualan Harian')

@section('content')
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('reports.daily') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="date" class="form-label fw-bold">Pilih Tanggal</label>
                <input type="date" class="form-control" name="date" id="date" value="{{ $date }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
            <div class="col-md-6 text-md-end">
                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Cetak Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-white-50 small mb-1">Total Pendapatan</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-white-50 small mb-1">Total Transaksi</h6>
                <h3 class="fw-bold mb-0">{{ $summary['total_transactions'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-white-50 small mb-1">Rata-rata Penjualan</h6>
                <h3 class="fw-bold mb-0">Rp {{ number_format($summary['average_transaction'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold"><i class="bi bi-list-task me-2 text-primary"></i>Detail Transaksi - {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Kasir</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="small">{{ $transaction->created_at->format('H:i:s') }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                @foreach($transaction->items as $item)
                                    <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="fw-bold text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ strtoupper($transaction->payment_method) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Tidak ada transaksi pada tanggal ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
