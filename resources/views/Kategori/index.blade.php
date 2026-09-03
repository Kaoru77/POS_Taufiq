@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Manajemen</div>
            <h2 class="header-title mb-0">Kategori Produk</h2>
        </div>
        @can('create', App\Models\Kategori::class)
        <a href="{{route('kategori.create')}}" class="btn btn-caramel">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
        @endcan
    </div>

    <div class="panel-card mb-3">
        <form action="{{route('kategori.index')}}" method="GET" class="search-box">
            <i class="bi bi-search"></i>
            <input type="text"
                   name="search"
                   value="{{request()->search}}"
                   placeholder="Cari kategori..."
                   class="search-input">
            <button class="btn btn-sm btn-outline-caramel" type="submit">Cari</button>
        </form>
    </div>

    <div class="panel-card">
        <table class="table table-bakery align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Jumlah Produk</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                <tr>
                    <td class="fw-semibold" style="color:#4E2F1A;">{{ $kategori->nama }}</td>
                    <td>
                        <span class="badge-count">{{ $kategori->produk_count }} produk</span>
                    </td>
                    <td class="text-muted">{{ $kategori->user->name ?? '-' }}</td>    
                    <td class="text-end">
                        @can('update', $kategori)
                        <a href="{{route('kategori.edit', $kategori)}}" class="btn btn-sm btn-caramel">Edit</a>
                        @endcan
                        @can('delete', $kategori)
                        <form action="{{route('kategori.destroy', $kategori)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-soft-danger" onclick="return confirm('Yakin hapus kategori ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">Belum ada kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $kategoris->links() }}
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
}
.search-box i { color: #8A6D52; }
.search-input {
    border: none;
    background: transparent;
    flex: 1;
    outline: none;
    font-size: .9rem;
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
.badge-count {
    background: #F3E6D8;
    color: #7B4B2A;
    font-size: .75rem;
    padding: 3px 10px;
    border-radius: 999px;
}

@media (max-width: 576px) {
    .header-card { flex-wrap: wrap; }
    .header-title { white-space: normal; }
}
</style>

@endsection