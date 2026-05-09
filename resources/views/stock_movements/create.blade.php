@extends('layouts.app')

@section('title', 'Catat Stok')
@section('page-title', 'Catat Pergerakan Stok')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Input Stok Masuk / Keluar</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('stock_movements.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="product_id" class="form-label fw-semibold">Pilih Produk <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label fw-semibold">Jenis Pergerakan <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stok Masuk</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stok Keluar</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" min="1" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="note" class="form-label fw-semibold">Catatan / Keterangan</label>
                        <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror" placeholder="Contoh: Restock dari supplier, Koreksi stok, dll.">{{ old('note') }}</textarea>
                        @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('stock_movements.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
