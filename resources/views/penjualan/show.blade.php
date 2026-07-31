@extends('layouts.app') {{-- Sesuaikan nama layout utama kamu --}}

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detail Transaksi Penjualan #{{ $penjualan->id }}</h2>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <!-- Informasi Ringkasan Transaksi -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tanggal Transaksi:</strong> {{ $penjualan->created_at->format('d-m-Y H:i:s') }}</p>
                    <p><strong>Kasir:</strong> {{ $penjualan->user->name ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Metode Pembayaran:</strong> {{ $penjualan->metode_pembayaran }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-info">{{ $penjualan->status }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian Produk yang Dibeli -->
    <div class="card">
        <div class="card-header bg-light"><strong>Rincian Item</strong></div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th width="100">Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Sesuaikan 'itemPenjualan' dengan nama relasi di Model Penjualan kamu --}}
                    @forelse($penjualan->itemPenjualan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</td>
                            <td>Rp.{{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp.{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada rincian produk.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total Pembayaran:</th>
                        <th>Rp.{{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection