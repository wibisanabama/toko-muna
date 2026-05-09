@extends('layouts.app')

@section('title', 'Riwayat Stok')
@section('page-title', 'Manajemen Stok')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i>Riwayat Pergerakan Stok</h5>
        <a href="{{ route('stock-movements.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Catat Pergerakan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Oleh</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $index => $movement)
                    <tr>
                        <td class="text-muted">{{ $movements->firstItem() + $index }}</td>
                        <td class="small">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="fw-semibold">{{ $movement->product->name }}</div>
                            <div class="text-muted small">SKU: {{ $movement->product->sku }}</div>
                        </td>
                        <td>
                            @if($movement->type === 'in')
                                <span class="badge bg-success"><i class="bi bi-arrow-down-left me-1"></i>Masuk</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-arrow-up-right me-1"></i>Keluar</span>
                            @endif
                        </td>
                        <td class="fw-bold {{ $movement->type === 'in' ? 'text-success' : 'text-danger' }}">
                            {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                        </td>
                        <td>{{ $movement->user->name }}</td>
                        <td class="text-muted small">{{ $movement->note ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pergerakan stok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection
