@extends('layouts.app')

@section('title', 'POS')

@section('content')

@if(session('errors'))

<div class="alert alert-danger">
    {{session('errors')}}
</div>   
@endif

<h4 class="mb-3">
    {{$mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan'}}
</h4>

<div class="row">

    {{-- ================= DAFTAR PRODUK (KIRI) ================= --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-body" style="max-height:70vh; overflow:auto">
                
                {{-- Form Search --}}
                <div class="mb-3">
                    <form method="GET" action="{{route ('penjualan.create')}}">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Cari produk..."
                            onkeyup="this.form.submit()">
                    </form>
                </div>

                @foreach($products as $product)
                <form action="{{route ('itempenjualan.store')}}" method="POST" class="row mb-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="row align-items-center g-2">
                        {{-- Card Detail Produk --}}
                        <div class="col-7">
                             <button class="btn btn-outline-primary w-100 text-start p-2 {{$sale->status === 'COMPLETED' ? 'disable': ''}}">
                                <div class="d-flex align-items-center gap-2">

                                    <img src="{{ asset('storage/' . $product->foto) }}" 
                                         alt="Gambar" 
                                         class="rounded-circle"
                                         style="width:45px; height:45px; object-fit:cover">
                                    <div>
                                        <strong class="text-primary d-block">{{ $product->nama }}</strong>
                                        <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                    </div>
                                </div>
                            </button>
                        </div>

                        {{-- Input Quantity --}}
                        <div class="col-3">
                            <input type="number" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   class="form-control{{$sale->status === 'COMPLETED' ? 'readonly' : ''}}">
                        </div>

                        {{-- Tombol Tambah --}}
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary w-100 {{$sale->status === 'COMPLETED' ? 'disable' : ''}}">+</button>
                        </div>
                    </div>
                </form>
                @endforeach

            </div>
        </div>
    </div>

    {{-- ================= KERANJANG BELANJA (KANAN) ================= --}}
    <div class="col-md-6">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 align-middle">
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
                        {{-- Contoh Item Keranjang (Nanti diloop dari data keranjang/item_penjualan) --}}
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
                                           class="form-control form-control-sm"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>Rp {{number_format($item->subtotal)}}</td>
                            <td>
                                @can('delete', $item)
                                <form method="POST" action="{{route('itempenjualan.destroy',$item->id)}}">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Keranjang kosong
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Total & Checkout --}}
            <div class="card-footer bg-white">
                <strong>Rp {{number_format($sale->total_pembayaran)}}</strong>
                {{-- Form Checkout --}}
                <form method="POST" action="{{route('penjualan.update',$sale->id)}}"
                    onsubmit="return confirm('yakin ingin checkout?')" class="mt-2">
                    @csrf
                    @method('PUT')
                    <select name="payment_method" class="form-select mb-3" required>
                        <option value="">Pilih Pembayaran</option>
                        <option value="CASH">Cash</option>
                        <option value="QRIS">QRIS</option>
                    </select>

                    <button class="btn btn-success w-100 mb-2{{$sale->status === 'COMPLETED' ? 'disable' : ''}}">
                        Checkout
                    </button>
                </form>
                @can('delete',$sale)

                {{-- Form Batal Transaksi --}}
                <form method="POST" action="{{route('penjualan.destroy', $sale->id)}}"
                    onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 mt-2 {{$sale->status === 'COMPLETED' ? 'disable':''}}">
                        Batal Transaksi
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>

</div>

@endsection