@extends('layouts.app')

@section('title', 'Laporan Bulanan')
@section('page-title', 'Laporan Penjualan Bulanan')

@section('content')
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('reports.monthly') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="month" class="form-label fw-bold">Pilih Bulan</label>
                <select name="month" id="month" class="form-select">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label fw-bold">Pilih Tahun</label>
                <select name="year" id="year" class="form-select">
                    @foreach(range(date('Y')-2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
            <div class="col-md-4 text-md-end">
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
                <h6 class="card-title text-white-50 small mb-1">Total Pendapatan Bulan Ini</h6>
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

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold"><i class="bi bi-graph-up me-2 text-primary"></i>Grafik Penjualan</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pie-chart me-2 text-primary"></i>Ringkasan Metode</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @php
                    $cashCount = $transactions->where('payment_method', 'cash')->count();
                    $transferCount = $transactions->where('payment_method', 'transfer')->count();
                @endphp
                @if($transactions->count() > 0)
                    <canvas id="methodChart"></canvas>
                @else
                    <div class="text-muted small">Data tidak tersedia</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold"><i class="bi bi-list-task me-2 text-primary"></i>Ringkasan Harian - {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Jumlah Transaksi</th>
                        <th class="text-end pe-4">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $totalRev = 0; 
                        $totalTrans = 0;
                    @endphp
                    @foreach(array_reverse($chartData) as $data)
                        @if($data['revenue'] > 0)
                            @php 
                                $totalRev += $data['revenue'];
                                $totalTrans += $transactions->filter(fn($t) => $t->created_at->format('d') == $data['day'])->count();
                            @endphp
                            <tr>
                                <td class="ps-4">{{ $data['day'] }} {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</td>
                                <td>{{ $transactions->filter(fn($t) => $t->created_at->format('d') == $data['day'])->count() }}</td>
                                <td class="text-end pe-4 fw-bold">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                @if($totalRev > 0)
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td class="ps-4">TOTAL</td>
                        <td>{{ $totalTrans }}</td>
                        <td class="text-end pe-4">Rp {{ number_format($totalRev, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @else
                <tbody>
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">Tidak ada data penjualan untuk bulan ini.</td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'day')) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode(array_column($chartData, 'revenue')) !!},
                    borderColor: '#6C5CE7',
                    backgroundColor: 'rgba(108, 92, 231, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#6C5CE7'
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
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Method Chart
        @if($transactions->count() > 0)
        const methodCtx = document.getElementById('methodChart').getContext('2d');
        new Chart(methodCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cash', 'Transfer'],
                datasets: [{
                    data: [{{ $cashCount }}, {{ $transferCount }}],
                    backgroundColor: ['#00CEC9', '#0984E3'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
        @endif
    });
</script>
@endpush
