@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Penjualan</div>
            <h2 class="header-title mb-0">Transaksi #{{ $penjualan->id }}</h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penjualan.receipt', $penjualan) }}" class="btn btn-receipt">
                <i class="bi bi-receipt me-1"></i> Lihat Struk
            </a>
            <a href="{{ route('penjualan.index') }}" class="btn btn-soft-light">Kembali</a>
        </div>
    </div>

    <div class="panel-card mb-3">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ $penjualan->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-label">Kasir</div>
                <div class="info-value">{{ $penjualan->user->name ?? '-' }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-label">Metode Bayar</div>
                <div class="info-value">{{ strtoupper($penjualan->metode_pembayaran ?? '-') }}</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="badge-status {{ $penjualan->status === 'OPEN' ? 'badge-open' : 'badge-completed' }}">
                        {{ $penjualan->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-card mb-3">
        <table class="table table-bakery align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualan->itemPenjualan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-semibold" style="color:#4E2F1A;">{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                    <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->kuantitas }}</td>
                    <td class="text-end fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Tidak ada rincian produk untuk transaksi ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="panel-card d-flex justify-content-between align-items-center">
        <span class="text-muted">Total Pembayaran</span>
        <span class="total-value">Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</span>
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
    padding: 1.25rem;
}
.header-card {
    background: #4E2F1A;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
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
.btn-soft-light {
    background: rgba(255,255,255,.1);
    border: none;
    color: #F3E6D8;
    font-weight: 500;
    padding: 8px 18px;
}
.btn-soft-light:hover { background: rgba(255,255,255,.18); color: #fff; }
.btn-receipt {
    background: #F3C77A;
    color: #4E2F1A;
    font-weight: 600;
    padding: 8px 14px;
}
.btn-receipt:hover { background: #F7D99E; color: #4E2F1A; }

.info-label {
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: #8A6D52;
    margin-bottom: 2px;
}
.info-value {
    font-size: .95rem;
    font-weight: 600;
    color: #4E2F1A;
}

.badge-status {
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
}
.badge-open { background: #FAEEDA; color: #854F0B; }
.badge-completed { background: #EAF3DE; color: #3B6D11; }

.table-bakery thead th {
    border-bottom: 1px solid #F0E4D6;
    color: #8A6D52;
    font-weight: 500;
    font-size: .82rem;
}
.table-bakery tbody tr {
    border-bottom: 1px solid #F6EEE3;
}

.total-value {
    font-size: 1.4rem;
    font-weight: 700;
    color: #4E2F1A;
}
</style>

@endsection