@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Produk</h6>
                        <h2 class="mb-0">{{ $totalProducts }}</h2>
                    </div>
                    <i class="bi bi-box fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="{{ route('products.index') }}">Lihat Detail</a>
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Kategori</h6>
                        <h2 class="mb-0">{{ $totalCategories }}</h2>
                    </div>
                    <i class="bi bi-tags fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="{{ route('categories.index') }}">Lihat Detail</a>
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Supplier</h6>
                        <h2 class="mb-0">{{ $totalSuppliers }}</h2>
                    </div>
                    <i class="bi bi-truck fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="{{ route('suppliers.index') }}">Lihat Detail</a>
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Gudang</h6>
                        <h2 class="mb-0">{{ $totalWarehouses }}</h2>
                    </div>
                    <i class="bi bi-building fs-1"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between small">
                <a class="text-white stretched-link" href="{{ route('warehouses.index') }}">Lihat Detail</a>
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-7">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-clock-history me-1"></i> Pergerakan Stok Terbaru
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0" style="font-size: 0.875rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Produk</th>
                                <th>Tipe</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMovements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('H:i') }}</td>
                                <td>{{ $movement->product->name }}</td>
                                <td>
                                    @if($movement->type === 'in')
                                        <span class="badge bg-success">In</span>
                                    @elseif($movement->type === 'out')
                                        <span class="badge bg-danger">Out</span>
                                    @else
                                        <span class="badge bg-warning">Adj</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">{{ $movement->quantity }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada aktivitas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('stock-movements.index') }}" class="small text-decoration-none">Lihat Semua Riwayat</a>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i> Peringatan Stok Rendah
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0" style="font-size: 0.875rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Sisa Stok</th>
                                <th class="text-center">Min</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td class="text-center fw-bold text-danger">{{ $product->totalStock() }}</td>
                                <td class="text-center text-muted">{{ $product->minimum_stock }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-success">Stok aman terkendali.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="small text-decoration-none">Lihat Detail Stok</a>
            </div>
        </div>
    </div>
</div>
@endsection
