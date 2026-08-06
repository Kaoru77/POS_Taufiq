@extends('layouts.app')

@section('title', 'produk')

@section('content')
<h1>Halaman Produk</h1>

@can('create', App\Models\Produk::class)
<a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Create</a>
@endcan

{{-- FORM SEARCH DAN FILTER KATEGORI --}}
<form action="{{ route('produk.index') }}" method="GET" class="mb-3">
    <div class="row g-2">
        {{-- Dropdown Filter Jenis Produk --}}
        <div class="col-md-3">
            <select name="kategori" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Jenis --</option>
                <option value="Makanan" {{ request('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ request('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
            </select>
        </div>

        {{-- Input Search Nama --}}
        <div class="col-md-9">
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
        </div>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Foto</th>
            <th scope="col">Nama</th>
            <th scope="col">Jenis</th> {{-- Tambahan Header Jenis --}}
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
                   <img src="{{ asset('storage/'.$product->foto) }}"class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                </td>
                <td>{{ $product->nama }}</td>
                <td>
                    <span class="badge bg-info text-dark">
                        {{ $product->kategori ?? '-' }}
                    </span>
                </td> {{-- Tambahan Kolom Jenis --}}
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

                    {{-- Tombol Edit --}}
                    @can('update', $product)
                    ||
                    <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @endcan
                    
                    {{-- Tombol Hapus --}}
                    @can('delete', $product)
                    ||
                    <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">
                            Hapus
                        </button>
                    </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Data tidak tersedia.</td> {{-- Sesuaikan colspan jadi 9 --}}
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}
    
@endsection