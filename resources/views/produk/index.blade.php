@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Manajemen</div>
            <h2 class="header-title mb-0">Daftar Produk</h2>
        </div>
        @can('create', App\Models\Produk::class)
        <a href="{{ route('produk.create') }}" class="btn btn-caramel">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
        @endcan
    </div>

    <div class="panel-card mb-3">
        <form action="{{ route('produk.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <select name="kategori" class="form-select field-input" onchange="this.form.submit()">
                        <option value="">-- Semua Jenis --</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="search-input"
                               placeholder="Cari nama produk...">
                        <button class="btn btn-sm btn-outline-caramel" type="submit">Cari</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="panel-card">
        <table class="table table-bakery align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>
                    <td>
                        @if($product->foto)
                            <img src="{{ asset('storage/'.$product->foto) }}" class="product-photo">
                        @else
                            <div class="product-photo-placeholder"><i class="bi bi-cup-hot"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold" style="color:#4E2F1A;">{{ $product->nama }}</td>
                    <td>
                        <span class="badge-kategori">{{ $product->kategori->nama ?? '-' }}</span>
                    </td>
                    <td>Rp {{ number_format($product->harga_beli) }}</td>
                    <td>Rp {{ number_format($product->harga_jual) }}</td>
                    <td>
                        @if($product->stok == 0)
                            <span class="badge-stok badge-out">Habis</span>
                        @elseif($product->stok <= 5)
                            <span class="badge-stok badge-low">{{ $product->stok }}</span>
                        @else
                            {{ $product->stok }}
                        @endif
                    </td>
                    <td class="text-end">
                        @can('view', $product)
                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-sm btn-soft-brown">Detail</a>
                        @endcan
                        @can('update', $product)
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-sm btn-caramel">Edit</a>
                        @endcan
                        @can('delete', $product)
                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-soft-danger" onclick="return confirm('Apakah anda yakin?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Data tidak tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $products->links() }}
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
    flex-wrap: nowrap;
    gap: 16px;
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
    white-space: nowrap;
}
.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #FAF3EA;
    border-radius: 8px;
    padding: 6px 14px;
    height: 100%;
}
.search-box i { color: #8A6D52; }
.search-input {
    border: none;
    background: transparent;
    flex: 1;
    outline: none;
    font-size: .9rem;
}
.field-input {
    border: 1px solid #E8D9C5;
}
.btn-caramel {
    background-color: #C9922E;
    border: none;
    color: #fff;
    font-weight: 600;
}
.btn-caramel:hover { background-color: #A97722; color: #fff; }
.btn-outline-caramel {
    background: transparent;
    border: 1.5px solid #C9922E;
    color: #C9922E;
    font-weight: 600;
}
.btn-outline-caramel:hover { background: #C9922E; color: #fff; }
.btn-soft-brown {
    background-color: #F3E6D8;
    border: none;
    color: #7B4B2A;
    font-weight: 500;
}
.btn-soft-brown:hover { background-color: #E8D5BE; color: #4E2F1A; }
.btn-soft-danger {
    background-color: #F7C1C1;
    border: none;
    color: #791F1F;
}
.btn-soft-danger:hover { background-color: #F3A5A5; color: #501313; }
.table-bakery thead th {
    border-bottom: 1px solid #F0E4D6;
    color: #8A6D52;
    font-weight: 500;
    font-size: .82rem;
}
.table-bakery tbody tr {
    border-bottom: 1px solid #F6EEE3;
}
.product-photo, .product-photo-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
}
.product-photo-placeholder {
    background: #F3E6D8;
    color: #B49A82;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.badge-kategori {
    background: #F3E6D8;
    color: #7B4B2A;
    font-size: .75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 999px;
}
.badge-stok {
    font-size: .75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 999px;
}
.badge-low { background: #FAEEDA; color: #854F0B; }
.badge-out { background: #F7C1C1; color: #791F1F; }

@media (max-width: 576px) {
    .header-card { flex-wrap: wrap; }
    .header-title { white-space: normal; }
}
</style>

@endsection