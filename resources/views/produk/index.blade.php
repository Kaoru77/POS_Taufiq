@extends('layouts.app')

@section('title', 'produk')

@section('content')

@include('layouts.navbar')
    
<h1>halaman produk</h1>

@can('create', App\Models\Produk::class)
<a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">create</a>
@endcan

<form action="{{ route('produk.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Search nama produk"
        >
        <button class="btn btn-outline-secondary" type="submit">
            Search
        </button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Foto</th>
            <th scope="col">Nama</th>
            <th scope="col">Harga Beli</th>
            <th scope="col">Harga Jual</th>
            <th scope="col">Stok</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <th scope="row">{{ $products->firstItem() + $loop->index }}</th>
                <td>{{ $product->user->name }}</td>
                <td>
                    <img src="{{ asset('storage/'.$product->foto) }}" width="100" class="img-thumbnail">
                </td>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->harga_beli }}</td>
                <td>{{ $product->harga_jual }}</td>
                <td>{{ $product->stok }}</td>
                <td class="d-flex gap-1 align-items-center">
                    {{-- Tombol Detail --}}
                    @can('view', $product)
                    <a href="{{ route('produk.show', $product->id) }}" class="btn btn-info btn-sm">
                        Detail
                    </a>
                    @endcan
                    ||
                    {{-- Tombol Edit (Tanpa @can) --}}
                    <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                    ||
                    
                    {{-- Tombol Hapus (Tanpa @can) --}}
                    <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Data tidak tersedia.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}
    
@endsection