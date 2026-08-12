@extends('layouts.app')

@section('title', 'POS')

@section('content')

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">{{ ucfirst(auth()->user()->role->name) }}</div>
            <h2 class="header-title mb-0">{{$mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan'}}</h2>
        </div>
    </div>

    <div class="row">

        {{-- ================= DAFTAR PRODUK (KIRI) ================= --}}
        <div class="col-md-6">
            <div class="panel-card">
                <div style="max-height:70vh; overflow:auto">

                    {{-- Form Search --}}
                    <div class="mb-3">
                        <form method="GET" action="{{route ('penjualan.create')}}" class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="search-input"
                                placeholder="Cari produk..."
                                onkeyup="this.form.submit()">
                        </form>
                    </div>

                    @foreach($products as $product)
                    <form action="{{route ('itempenjualan.store')}}" method="POST" class="row mb-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row align-items-center g-2">
                            {{-- Card Detail Produk --}}
                            <div class="col-7">
                                <div class="product-box {{$sale->status === 'COMPLETED' ? 'disabled': ''}}">
                                    <div class="d-flex align-items-center gap-2">

                                        @if($product->foto)
                                            <img src="{{ asset('storage/' . $product->foto) }}"
                                                 alt="{{$product->nama}}"
                                                 class="product-thumb">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="bi bi-cup-hot"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <strong class="product-name d-block">{{ $product->nama }}</strong>
                                            <small class="product-price">Rp {{ number_format($product->harga_jual) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Input Quantity --}}
                            <div class="col-3">
                                <input type="number"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    class="qty-input w-100"
                                    {{$sale->status === 'COMPLETED' ? 'readonly' : ''}}>
                            </div>

                            {{-- Tombol Tambah --}}
                            <div class="col-2">
                                <button type="submit" class="btn-add w-100" {{$sale->status === 'COMPLETED' ? 'disabled' : ''}}>
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- ================= KERANJANG BELANJA (KANAN) ================= --}}
        <div class="col-md-6">
            <div class="panel-card">
                <h6 class="fw-bold mb-3" style="color:#4E2F1A;">Keranjang</h6>

                <div class="table-responsive">
                    <table class="table table-bakery mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sale->itemPenjualan as $item)
                            <tr>
                                <td>{{$item->produk->nama}}</td>
                                <td>{{number_format($item->produk->harga_jual)}}</td>
                                <td>
                                    <form method="POST" action="{{route('itempenjualan.update', $item->id)}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="number"
                                            name="quantity"
                                            value="{{$item->kuantitas}}"
                                            min="1"
                                            class="qty-input-sm"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>Rp {{number_format($item->subtotal)}}</td>
                                <td>
                                    @can('delete', $item)
                                    <form method="POST" action="{{route('itempenjualan.destroy',$item->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Keranjang kosong
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer Total & Checkout --}}
                <div class="cart-footer">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total</span>
                        <span class="cart-total">Rp {{number_format($sale->total_pembayaran)}}</span>
                    </div>

                    <form method="POST" action="{{route('penjualan.update',$sale->id)}}"
                        onsubmit="return confirm('yakin ingin checkout?')">
                        @csrf
                        @method('PUT')
                        <select name="payment_method" class="form-select mb-2" required>
                            <option value="">Pilih Pembayaran</option>
                            <option value="CASH">Cash</option>
                            <option value="QRIS">QRIS</option>
                            <option value="TRANSFER">Transfer</option>
                        </select>

                        <button class="btn btn-checkout w-100" {{$sale->status === 'COMPLETED' ? 'disabled' : ''}}>
                            Checkout
                        </button>
                    </form>

                    @can('delete',$sale)
                    <form method="POST" action="{{route('penjualan.destroy', $sale->id)}}"
                        onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-cancel-link" {{$sale->status === 'COMPLETED' ? 'disabled':''}}>
                            Batal transaksi ini
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.dash-wrapper {
    background: #F3E6D5;
    border-radius: 16px;
    padding: 1.5rem;
}
.panel-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.1rem;
}
.header-card {
    background: #4E2F1A;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
}
.header-eyebrow {
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #D9BFA3;
    margin-bottom: 2px;
}
.header-title {
    font-size: 1.35rem;
    font-weight: 600;
    color: #fff;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #FAF3EA;
    border-radius: 8px;
    padding: 8px 14px;
}
.search-box i { color: #8A6D52; }
.search-input {
    border: none;
    background: transparent;
    flex: 1;
    outline: none;
    font-size: .9rem;
}

.product-box {
    border: 1px solid #F0E4D6;
    border-radius: 10px;
    padding: 8px;
}
.product-thumb, .product-thumb-placeholder {
    width: 42px;
    height: 42px;
    border-radius: 8px;
    flex-shrink: 0;
    object-fit: cover;
}
.product-thumb-placeholder {
    background: #F3E6D8;
    color: #B49A82;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.product-name {
    font-size: .85rem;
    color: #4E2F1A;
}
.product-price {
    font-size: .78rem;
    color: #8A6D52;
}
.qty-input, .qty-input-sm {
    border: 1px solid #F0E4D6;
    border-radius: 6px;
    text-align: center;
    padding: 4px;
    font-size: .85rem;
}
.btn-add {
    background: #C9922E;
    color: #fff;
    border: none;
    border-radius: 7px;
    height: 38px;
}
.btn-add:hover { background: #A97722; }

.table-bakery thead th {
    border-bottom: 1px solid #F0E4D6;
    color: #8A6D52;
    font-weight: 500;
    font-size: .8rem;
}
.table-bakery tbody tr {
    border-bottom: 1px solid #F6EEE3;
}
.btn-remove {
    background: #F7C1C1;
    color: #791F1F;
    border: none;
    border-radius: 6px;
    width: 30px;
    height: 30px;
}
.btn-remove:hover { background: #F3A5A5; }

.cart-footer {
    border-top: 1px solid #F0E4D6;
    padding-top: 14px;
    margin-top: 10px;
}
.cart-total {
    font-size: 1.4rem;
    font-weight: 700;
    color: #4E2F1A;
}
.btn-checkout {
    background: #3B6D11;
    color: #fff;
    font-weight: 600;
    padding: 10px;
    border: none;
}
.btn-checkout:hover { background: #2C5209; color: #fff; }
.btn-checkout:disabled { opacity: .5; }

.btn-cancel-link {
    background: none;
    border: none;
    color: #A15A5A;
    font-size: .82rem;
    width: 100%;
    text-align: center;
    padding: 6px;
    text-decoration: underline;
}
.btn-cancel-link:hover { color: #791F1F; }
</style>

@endsection