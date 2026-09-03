@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="dash-wrapper">
    <div class="form-page">
        <div class="header-card mb-3">
            <div>
                <div class="header-eyebrow">Manajemen</div>
                <h2 class="header-title mb-0">Tambah Kategori</h2>
            </div>
        </div>

        <div class="panel-card">
            <form action="{{route('kategori.store')}}" method="POST">
                @include('kategori._form')
            </form>
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