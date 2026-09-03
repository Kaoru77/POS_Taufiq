@extends('layouts.app')

@section('title', 'Tentang')

@section('content')

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Informasi</div>
            <h2 class="header-title mb-0">Tentang Aplikasi</h2>
        </div>
    </div>

    <div class="panel-card text-center mb-3">
        <div class="about-icon mb-3">🥐</div>
        <h4 class="fw-bold mb-2" style="color:#4E2F1A;">Sweet Crumbs Bakery POS</h4>
        <span class="badge-version mb-3">v1.0</span>
        <p class="about-desc mx-auto mb-0">
            Sistem kasir berbasis web untuk mengelola transaksi penjualan, data produk,
            kategori, dan pengguna toko roti secara sederhana dan efisien.
        </p>
    </div>

    <div class="feature-grid mb-3">
        <div class="feature-card">
            <i class="bi bi-cup-hot"></i>
            <div class="feature-label">Manajemen Produk</div>
        </div>
        <div class="feature-card">
            <i class="bi bi-receipt"></i>
            <div class="feature-label">Transaksi Kasir</div>
        </div>
        <div class="feature-card">
            <i class="bi bi-bar-chart"></i>
            <div class="feature-label">Dashboard Ringkas</div>
        </div>
        <div class="feature-card">
            <i class="bi bi-people"></i>
            <div class="feature-label">Multi Role</div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="panel-card h-100">
                <h6 class="fw-bold mb-3" style="color:#4E2F1A;">Dibuat Oleh</h6>
                <div class="d-flex align-items-center gap-3">
                    <div class="creator-avatar">T</div>
                    <div>
                        <div class="fw-semibold" style="color:#4E2F1A;">Taufiqurrochman  Hakim</div>
                        <div class="text-muted small">Siswa SMK &ndash; PPLG</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel-card h-100">
                <h6 class="fw-bold mb-3" style="color:#4E2F1A;">Teknologi yang Digunakan</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="tech-badge">Laravel</span>
                    <span class="tech-badge">MySQL</span>
                    <span class="tech-badge">Bootstrap 5</span>
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
    padding: 1.25rem;
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

.about-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #F3E6D8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto;
}
.badge-version {
    display: inline-block;
    background: #FAEEDA;
    color: #854F0B;
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
}
.about-desc {
    max-width: 480px;
    color: #8A6D52;
    font-size: .88rem;
    line-height: 1.6;
}

.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 10px;
}
.feature-card {
    background: #fff;
    border-radius: 10px;
    padding: 1rem .75rem;
    text-align: center;
}
.feature-card i {
    font-size: 22px;
    color: #C9922E;
}
.feature-label {
    font-size: .78rem;
    font-weight: 600;
    color: #4E2F1A;
    margin-top: 8px;
}

.creator-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #F3E6D8;
    color: #7B4B2A;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: .9rem;
    flex-shrink: 0;
}

.tech-badge {
    background: #F3E6D8;
    color: #7B4B2A;
    font-size: .75rem;
    padding: 4px 12px;
    border-radius: 999px;
}
</style>

@endsection