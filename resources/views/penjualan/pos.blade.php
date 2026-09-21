@extends('layouts.app')

@section('title', 'POS')

@section('content')

@php
    $locked = $sale->status === 'COMPLETED' || $sale->status_pembayaran === 'MENUNGGU';
@endphp

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
                                <div class="product-box {{$locked ? 'disabled': ''}}">
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
                                    {{$locked ? 'readonly' : ''}}>
                            </div>

                            {{-- Tombol Tambah --}}
                            <div class="col-2">
                                <button type="submit" class="btn-add w-100" {{$locked ? 'disabled' : ''}}>
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
                                            {{$locked ? 'readonly' : 'onchange=this.form.submit()'}}>
                                    </form>
                                </td>
                                <td>Rp {{number_format($item->subtotal)}}</td>
                                <td>
                                    @can('delete', $item)
                                    @if(!$locked)
                                    <form method="POST" action="{{route('itempenjualan.destroy',$item->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                    @endif
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

                <div class="cart-footer">
                    @php
                        $subtotal = $sale->itemPenjualan->sum('subtotal');
                        $diskonPersen = $sale->diskon_persen ?? 0;
                        $nilaiDiskon = (int) round($subtotal * $diskonPersen / 100);
                        $totalSetelahDiskon = $subtotal - $nilaiDiskon;
                    @endphp
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{number_format($subtotal, 0, ',', '.')}}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 text-success">
                        <span>Diskon</span>
                        <span id="discountSummary">0% (-Rp {{number_format($nilaiDiskon, 0, ',', '.')}})</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total</span>
                        <span class="cart-total" id="totalSummary">Rp {{number_Format($subtotal, 0, ',', '.')}}</span>
                    </div>

                    @if($sale->status_pembayaran === 'MENUNGGU')

                        {{-- ================= PANEL MENUNGGU KONFIRMASI ================= --}}
                        <div class="waiting-panel">
                            @if($sale->metode_pembayaran === 'QRIS')
                                <div class="qr-box">
                                    <i class="bi bi-qr-code"></i>
                                </div>
                                <div class="waiting-label">Minta pelanggan scan kode ini</div>
                            @else
                                <div class="transfer-info">
                                    <div class="transfer-row"><span>Bank Tujuan</span><strong>BRI</strong></div>
                                    <div class="transfer-row"><span>No. Rekening</span><strong>9876235098</strong></div>
                                    <div class="transfer-row"><span>Atas Nama</span><strong>Sweet Crumbs Bakery</strong></div>
                                </div>
                            @endif

                            <form method="POST" action="{{route('penjualan.konfirmasi', $sale)}}" class="mt-2">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-checkout w-100">
                                    Konfirmasi {{ $sale->metode_pembayaran === 'QRIS' ? 'Pembayaran' : 'Transfer' }} Diterima
                                </button>
                            </form>

                            <form method="POST" action="{{route('penjualan.batalKonfirmasi', $sale)}}" class="mt-2">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-cancel-link">pilih metode lain</button>
                            </form>
                        </div>

                    @else

                        {{-- ================= FORM PILIH METODE PEMBAYARAN ================= --}}
                        <form method="POST" action="{{route('penjualan.update',$sale->id)}}"
                            onsubmit="return confirm('yakin ingin checkout?')">
                            @csrf
                            @method('PUT')
                            <label for="diskonPersen" class="form-label mb-1">Diskon (maksimal 20%)</label>
                            <input type="number" name="diskon_persen" id="diskonPersen" class="form-control mb-2"
                                value="{{ $diskonPersen }}" min="0" max="20" step="1" required oninput="updateTotal()">
                            <select name="payment_method" id="paymentMethod" class="form-select mb-2" required onchange="toggleCashInput(this.value)">
                                <option value="">Pilih Pembayaran</option>
                                <option value="CASH">Cash</option>
                                <option value="QRIS">QRIS</option>
                                <option value="TRANSFER">Transfer</option>
                            </select>

                            <div id="cashInputWrapper" class="mb-2" style="display:none;">
                                <input type="number" name="uang_diterima" id="uangDiterima" class="form-control cash-input mb-2"
                                    placeholder="Uang diterima (Rp)" min="0" oninput="updateKembalian()">
                                <div class="kembalian-box" id="kembalianInfo"></div>
                            </div>

                            <button class="btn btn-checkout w-100" {{$locked ? 'disabled' : ''}}>
                                Bayar Sekarang
                            </button>
                        </form>

                    @endif

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

<script>
const subtotalPenjualan = {{ $subtotal }};
let totalPembayaran = subtotalPenjualan;

function updateTotal() {
    const diskonInput = document.getElementById('diskonPersen');
    if (!diskonInput) {
        totalPembayaran = {{ $sale->total_pembayaran }};
        return;
    }
    const diskon = Math.min(Math.max(parseInt(diskonInput.value) || 0, 0), 20);
    const nilaiDiskon = Math.round(subtotalPenjualan * diskon / 100);
    totalPembayaran = subtotalPenjualan - nilaiDiskon;
    document.getElementById('discountSummary').textContent = diskon + '% (-Rp ' + nilaiDiskon.toLocaleString('id-ID') + ')';
    document.getElementById('totalSummary').textContent = 'Rp ' + totalPembayaran.toLocaleString('id-ID');
    updateKembalian();
}

function toggleCashInput(method) {
    const wrapper = document.getElementById('cashInputWrapper');
    const input = document.getElementById('uangDiterima');
    if (method === 'CASH') {
        wrapper.style.display = 'block';
        input.setAttribute('required', 'required');
    } else {
        wrapper.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
        document.getElementById('kembalianInfo').textContent = '';
    }
}

updateTotal();

function updateKembalian() {
    const diterima = parseInt(document.getElementById('uangDiterima').value) || 0;
    const info = document.getElementById('kembalianInfo');
    info.classList.add('show');
    if (diterima < totalPembayaran) {
        info.classList.remove('status-cukup');
        info.classList.add('status-kurang');
        info.textContent = 'Uang belum cukup, kurang Rp ' + (totalPembayaran - diterima).toLocaleString('id-ID');
    } else {
        info.classList.remove('status-kurang');
        info.classList.add('status-cukup');
        info.textContent = 'Kembalian: Rp ' + (diterima - totalPembayaran).toLocaleString('id-ID');
    }
}
</script>

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
.cash-input {
    border: 1px solid #E8D9C5;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: .95rem;
}
.cash-input:focus {
    border-color: #C9922E;
    box-shadow: 0 0 0 .2rem rgba(201,146,46,.15);
}
.kembalian-box {
    padding: 8px 12px;
    border-radius: 8px;
    font-size: .85rem;
    font-weight: 600;
    display: none;
}
.kembalian-box.show { display: block; }
.kembalian-box.status-kurang {
    background: #FCEBEB;
    color: #791F1F;
}
.kembalian-box.status-cukup {
    background: #EAF3DE;
    color: #27500A;
}

.waiting-panel {
    background: #FAF3EA;
    border-radius: 10px;
    padding: 1rem;
    text-align: center;
}
.qr-box {
    width: 130px;
    height: 130px;
    margin: 0 auto 10px;
    background: #fff;
    border: 2px solid #E8D9C5;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.qr-box i {
    font-size: 70px;
    color: #4E2F1A;
}
.waiting-label {
    font-size: .78rem;
    color: #8A6D52;
    margin-bottom: 10px;
}
.transfer-info {
    background: #fff;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 10px;
    text-align: left;
}
.transfer-row {
    display: flex;
    justify-content: space-between;
    font-size: .82rem;
    color: #4E2F1A;
    margin-bottom: 6px;
}
.transfer-row:last-child { margin-bottom: 0; }
</style>

@endsection