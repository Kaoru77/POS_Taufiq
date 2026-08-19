    @extends('layouts.app')

    @section('title', 'Detail Produk')

    @section('content')

    <div class="container mt-4">
        <!-- Header Page & Tombol Kembali -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Produk: {{ $produk->nama }}</h2>
            <a href="{{ route('produk.index') }}" class="btn" style="background:#F3E6D8; color:#7B4B2A;">Kembali</a>
        </div>

        <div class="row">
            <!-- Kolom Kiri: Gambar, Badge Kategori & Profit -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center">
                        @if ($produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="img-fluid rounded mb-3" style="max-height: 250px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" style="height: 200px;">
                                <span class="text-muted">Tidak ada foto</span>
                            </div>
                        @endif
                        <h4 class="fw-bold mb-2">{{ $produk->nama }}</h4>
                        <span class="badge fs-6" style="background:#F3E6D8; color:#7B4B2A;">{{ $produk->kategori->nama ?? '-' }}</span>
                    </div>
                </div>

                <!-- Card Estimasi Keuntungan -->
                <div class="card shadow-sm" style="border-color:#D8E8CC;">
                    <div class="card-body text-center text-md-start">
                        <h6 class="text-muted mb-1">Estimasi Profit / Unit</h6>
                        <h3 class="fw-bold m-0" style="color:#3B6D11;">
                            Rp {{ number_format($produk->harga_jual - $produk->harga_beli, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Rincian Lengkap & Riwayat Penjualan -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0 fw-bold">Informasi Rinci</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="35%" class="fw-bold">Harga Beli</td>
                                <td>: Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Harga Jual</td>
                                <td>: Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Stok Tersedia</td>
                                <td>: <span class="badge bg-{{ $produk->stok > 10 ? 'success' : 'danger' }} fs-6">{{ $produk->stok }} Unit</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Diinput Oleh</td>
                                <td>: {{ $produk->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tanggal Dibuat</td>
                                <td>: {{ $produk->created_at ? $produk->created_at->translatedFormat('d F Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Card Riwayat Penjualan Terakhir -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0 fw-bold">Transaksi Terakhir Produk Ini</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kasir</th>
                                    <th>Jumlah (Qty)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produk->itemPenjualan->take(5) ?? [] as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->created_at ? $item->created_at->translatedFormat('d-m-Y H:i') : '-' }}</td>
                                    <td>{{ $item->penjualan->user->name ?? '-' }}</td>
                                    <td><span class="badge" style="background:#F3E6D8; color:#7B4B2A;">{{ $item->kuantitas }} Qty</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada riwayat penjualan untuk produk ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection