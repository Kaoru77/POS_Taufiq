@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="dash-wrapper">
    <div class="form-page">
        <div class="header-card mb-3">
            <div>
                <div class="header-eyebrow">Manajemen</div>
                <h2 class="header-title mb-0">Edit Kategori</h2>
            </div>
        </div>

        <div class="panel-card">
            <form action="{{route('kategori.update', $kategori)}}" method="POST">
                @method('PUT')
                @include('kategori._form')
            </form>
        </div>
    </div>
</div>

@endsection