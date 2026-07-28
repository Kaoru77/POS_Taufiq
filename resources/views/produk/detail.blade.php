@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm style="max-width: 600px; margin: auto;">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Detail Produk</h5>
        </div>
        <div class="card-body">
            @if ($produk->foto)
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="img-fluid rounded" style="max-height: 250px;">
                </div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th width="35%">Nama Produk</th>
                    <td>{{ $produk->nama }}</td>
                </tr>
                <tr>
                    <th>Harga Beli</th>
                    <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Harga Jual</th>
                    <td>Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>{{ $produk->stok }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection