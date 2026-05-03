@extends('layouts.app')

@section('title', 'Catat Pergerakan Stok')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Catat Pergerakan Stok</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('stock-movements.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('stock-movements.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">Produk</label>
                            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', request('product_id')) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->sku }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="warehouse_id" class="form-label">Gudang</label>
                            <select name="warehouse_id" id="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id', request('warehouse_id')) == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Tipe Pergerakan</label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stok Masuk (+)</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stok Keluar (-)</option>
                                <option value="adjustment" {{ old('type') == 'adjustment' ? 'selected' : '' }}>Penyesuaian</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="1">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="movement_date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('movement_date') is-invalid @enderror" id="movement_date" name="movement_date" value="{{ old('movement_date', date('Y-m-d')) }}" required>
                            @error('movement_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reference_number" class="form-label">Nomor Referensi (Opsional)</label>
                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror" id="reference_number" name="reference_number" value="{{ old('reference_number') }}" placeholder="Contoh: PO-001, INV-2023-001">
                        @error('reference_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan / Keterangan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            Pergerakan stok yang sudah disimpan tidak dapat diubah atau dihapus untuk menjaga integritas data.
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-check-circle me-1"></i> Simpan Pergerakan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white fw-bold">Panduan</div>
            <div class="card-body">
                <ul class="small text-muted ps-3">
                    <li class="mb-2"><strong>Stok Masuk:</strong> Digunakan untuk penerimaan barang dari supplier atau pengembalian barang.</li>
                    <li class="mb-2"><strong>Stok Keluar:</strong> Digunakan untuk penjualan, pengiriman barang, atau pemakaian internal.</li>
                    <li class="mb-2"><strong>Penyesuaian:</strong> Digunakan jika ada selisih stok saat stock opname (bisa bernilai positif atau negatif di sistem, namun di form ini masukkan nilai positif dan sistem akan menyesuaikan berdasarkan tipe).</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
