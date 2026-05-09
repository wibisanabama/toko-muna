@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview Dashboard')

@section('content')
{{-- Widgets --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-currency-dollar fs-3 text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted small mb-1">Penjualan Hari Ini</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($todaySales, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-cart-check fs-3 text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted small mb-1">Transaksi Hari Ini</h6>
                        <h4 class="fw-bold mb-0">{{ $todayTransactionsCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-box-seam fs-3 text-info"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted small mb-1">Total Produk</h6>
                        <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-danger bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-exclamation-triangle fs-3 text-danger"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted small mb-1">Stok Rendah</h6>
                        <h4 class="fw-bold mb-0">{{ $lowStockCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    {{-- Sales Chart --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Penjualan 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="weeklySalesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    {{-- Top Products --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Produk Terlaris</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $item)
                    <div class="list-group-item py-3">
                        <div class="d-flex align-items-center">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->total_qty }} terjual</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">Belum ada data penjualan.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">5 Transaksi Terakhir</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Waktu</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $transaction->created_at->diffForHumans() }}</div>
                            <small class="text-muted">{{ $transaction->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>{{ $transaction->user->name }}</td>
                        <td class="fw-bold text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ strtoupper($transaction->payment_method) }}</span></td>
                        <td class="text-center pe-4">
                            <a href="#" class="btn btn-sm btn-outline-info">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada transaksi hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
                    backgroundColor: 'rgba(108, 92, 231, 0.8)',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000) + 'jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000) + 'k';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
