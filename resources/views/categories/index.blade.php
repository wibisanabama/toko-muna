@extends('layouts.app')

@section('title', 'Kategori Produk')
@section('page-title', 'Kategori Produk')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-tags-fill me-2"></i>Daftar Kategori</h5>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Dibuat</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                    <tr>
                        <td class="text-muted">{{ $categories->firstItem() + $index }}</td>
                        <td>
                            <span class="fw-semibold">{{ $category->name }}</span>
                        </td>
                        <td class="text-muted">{{ $category->description ?? '-' }}</td>
                        <td class="text-muted small">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $categories->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada kategori. Silakan tambah kategori baru.</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
