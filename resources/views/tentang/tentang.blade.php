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

    <div class="panel-card mb-3">
        <h5 class="fw-bold mb-2" style="color:#4E2F1A;">🥐 Sweet Crumbs Bakery POS</h5>
        <p class="text-muted mb-0">
            Sweet Crumbs Bakery POS adalah sistem kasir berbasis web untuk mengelola
            transaksi penjualan, data produk, kategori, dan pengguna toko roti secara
            sederhana dan efisien.
        </p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="panel-card h-100">
                <h6 class="fw-bold mb-3" style="color:#4E2F1A;">Dibuat Oleh</h6>
                <p class="mb-1"><strong>Taufiq Hakim</strong></p>
                <p class="text-muted mb-0">
                    Siswa SMK Jurusan Pengembangan Perangkat Lunak dan Gim (PPLG)
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel-card h-100">
                <h6 class="fw-bold mb-3" style="color:#4E2F1A;">Teknologi yang Digunakan</h6>
                <ul class="text-muted mb-0 ps-3">
                    <li>Laravel (PHP Framework)</li>
                    <li>MySQL / MariaDB</li>
                    <li>Bootstrap 5</li>
                </ul>
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
</style>

@endsection