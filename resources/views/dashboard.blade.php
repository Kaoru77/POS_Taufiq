@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="dash-wrapper">

   <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Dashboard</div>
             <h2 class="header-title mb-0">Ringkasan Penjualan Hari Ini</h2>
         </div>
         <div class="header-date">
             <i class="bi bi-calendar3"></i>
             {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
         </div>
     </div>
    @can('viewRevenue')
    <div class="stat-grid mb-3">
        <div class="stat-card">
            <div class="stat-icon icon-brown"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-label">Total Penjualan</div>
            <div class="stat-value">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="bi bi-receipt"></i></div>
            <div class="stat-label">Transaksi</div>
            <div class="stat-value">{{ $ringkasan['total_transaksi'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-amber"><i class="bi bi-coin"></i></div>
            <div class="stat-label">Tunai</div>
            <div class="stat-value">Rp {{ number_format($ringkasan['total_cash']) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-credit-card"></i></div>
            <div class="stat-label">Non-Tunai</div>
            <div class="stat-value">Rp {{ number_format($ringkasan['total_non_tunai']) }}</div>
        </div>
    </div>
    @endcan

    <div class="panel-card mb-3">
        <h5 class="fw-bold mb-3" style="color:#4E2F1A;">
            <i class="bi bi-exclamation-triangle text-warning"></i> Status Stok
        </h5>
        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-2">Stok rendah</h6>
                @forelse ($produkStokRendah as $produk)
                <div class="stok-row">
                    <span>{{ $produk->nama }}</span>
                    <span class="badge-stok badge-low">sisa {{ $produk->stok }}</span>
                </div>
                @empty
                <p class="text-muted small mb-0">Seluruh produk stok aman</p>
                @endforelse
                {{ $produkStokRendah->links() }}
            </div>
            <div class="col-md-6">
                <h6 class="text-muted mb-2">Habis stok</h6>
                @forelse ($produkStokHabis as $produk)
                <div class="stok-row">
                    <span>{{ $produk->nama }}</span>
                    <span class="badge-stok badge-out">habis</span>
                </div>
                @empty
                <p class="text-muted small mb-0">Tidak ada produk yang habis</p>
                @endforelse
                {{ $produkStokHabis->links() }}
            </div>
        </div>
    </div>

    <div class="panel-card">
        <h5 class="fw-bold mb-3" style="color:#4E2F1A;">
            <i class="bi bi-trophy text-warning"></i> Produk Terlaris
        </h5>
        @php $maxTerjual = $produkTerlaris->max('total_terjual') ?: 1; @endphp
        <div class="d-flex flex-column gap-3">
            @forelse ($produkTerlaris as $produk)
            <div class="d-flex align-items-center gap-3">
                <span class="rank-badge {{ $loop->first ? 'rank-first' : '' }}">{{ $loop->iteration }}</span>
                <span class="best-seller-name">{{ $produk->nama }}</span>
                <div class="progress-track flex-grow-1">
                    <div class="progress-fill {{ $loop->first ? 'fill-first' : '' }}"
                         style="width: {{ ($produk->total_terjual / $maxTerjual) * 100 }}%"></div>
                </div>
                <span class="best-seller-count">{{ $produk->total_terjual }}</span>
            </div>
            @empty
            <p class="text-muted text-center py-3 mb-0">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>

</div>

<style>
.dash-wrapper {
    background: #F3E6D5;
    border-radius: 16px;
    padding: 1.5rem;
}
.stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 12px;
}
.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1rem;
}
.stat-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    font-size: 15px;
}
.icon-brown { background: #F3E6D8; color: #7B4B2A; }
.icon-green { background: #EAF3DE; color: #3B6D11; }
.icon-amber { background: #FAEEDA; color: #854F0B; }
.icon-blue  { background: #E6F1FB; color: #185FA5; }

.stat-label {
    font-size: .78rem;
    color: #8A6D52;
    margin-bottom: 2px;
}
.stat-value {
    font-size: 1.25rem;
    font-weight: 600;
    color: #4E2F1A;
}
.panel-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
}
.stok-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #FAEEDA;
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 8px;
    font-size: .85rem;
}
.badge-stok {
    font-size: .72rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 999px;
}
.badge-low { color: #854F0B; }
.badge-out { color: #791F1F; background: #F7C1C1; }

.rank-badge {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #F3E6D8;
    color: #7B4B2A;
    font-size: .68rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.rank-first {
    background: #FAC775;
    color: #412402;
}
.best-seller-name {
    width: 140px;
    font-size: .85rem;
    color: #4E2F1A;
    flex-shrink: 0;
}
.progress-track {
    background: #F3E6D8;
    border-radius: 6px;
    height: 6px;
    overflow: hidden;
}
.progress-fill {
    background: #D9BFA3;
    height: 100%;
    border-radius: 6px;
}
.fill-first {
    background: #C9922E;
}
.best-seller-count {
    width: 30px;
    text-align: right;
    font-size: .8rem;
    color: #8A6D52;
}
</style>

@endsection