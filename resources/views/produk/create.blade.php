@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="dash-wrapper">
    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Manajemen</div>
            <h2 class="header-title mb-0">Tambah Produk</h2>
        </div>
    </div>

    <form action="{{route('produk.store')}}" method="POST" enctype="multipart/form-data">
        @include('produk._form')
    </form>
</div>

<style>
.dash-wrapper {
    background: #F3E6D5;
    border-radius: 16px;
    padding: 1.5rem;
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