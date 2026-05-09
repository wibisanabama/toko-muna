@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Produk</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
                @else
                    <div class="bg-light rounded d-flex justify-content-center align-items-center text-muted w-100" style="aspect-ratio: 1; font-size: 4rem;">
                        <i class="bi bi-image"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h3 class="fw-bold mb-1">{{ $product->name }}</h3>
                <p class="text-muted mb-4">SKU: {{ $product->sku }}</p>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Kategori</div>
                    <div class="col-sm-8">
                        @if($product->category)
                            <span class="badge bg-secondary">{{ $product->category->name }}</span>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Harga</div>
                    <div class="col-sm-8 text-primary fw-bold fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Stok Tersedia</div>
                    <div class="col-sm-8">
                        @if($product->stock <= 5)
                            <span class="badge bg-danger">{{ $product->stock }} Unit</span> <small class="text-danger ms-1">(Stok menipis!)</small>
                        @else
                            <span class="badge bg-success">{{ $product->stock }} Unit</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted fw-semibold">Deskripsi</div>
                    <div class="col-sm-8">
                        {!! nl2br(e($product->description ?: 'Tidak ada deskripsi.')) !!}
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-4 text-muted fw-semibold">Terakhir Diperbarui</div>
                    <div class="col-sm-8">
                        {{ $product->updated_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square me-1"></i>Edit Produk
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
