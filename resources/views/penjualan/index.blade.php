@extends('layouts.app')

@section('title','Penjualan')

@section('content')

@if(session('error'))
<div class="alert alert-danger">{{session('error')}}</div>
@endif

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Penjualan</div>
            <h2 class="header-title mb-0">Riwayat Transaksi</h2>
        </div>
        <a href="{{route('penjualan.create')}}" class="btn btn-caramel">
            <i class="bi bi-plus-lg"></i> Transaksi Baru
        </a>
    </div>

    <div class="panel-card mb-3">
        <form action="{{route('penjualan.index')}}" method="GET" class="search-box">
            <i class="bi bi-search"></i>
            <input type="text"
                   name="search"
                   value="{{request()->search}}"
                   placeholder="Cari transaksi..."
                   class="search-input">
            <button class="btn btn-sm btn-outline-caramel" type="submit">Cari</button>
        </form>
    </div>

    <div class="panel-card">
        <table class="table table-bakery align-middle mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                <tr>
                    <td>{{$sale->created_at->translatedFormat('d-m-Y H:i')}}</td>
                    <td>{{$sale->user->name}}</td>
                    <td class="fw-semibold">Rp {{number_format($sale->total_pembayaran)}}</td>
                    <td>
                        @switch($sale->metode_pembayaran)
                            @case('CASH')
                                <span class="metode"><i class="bi bi-cash"></i> Cash</span>
                                @break
                            @case('TRANSFER')
                                <span class="metode"><i class="bi bi-bank"></i> Transfer</span>
                                @break
                            @case('QRIS')
                                <span class="metode"><i class="bi bi-qr-code"></i> QRIS</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        @if($sale->status === 'OPEN')
                            <span class="badge-status badge-open">OPEN</span>
                        @else
                            <span class="badge-status badge-completed">COMPLETED</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($sale->status === 'COMPLETED')
                        <a href="{{route('penjualan.show', $sale->id)}}" class="btn btn-sm btn-soft-brown">Detail</a>
                        @endif

                        @if(auth()->user()->role->name === 'admin' && $sale->status === 'OPEN')
                        <a href="{{route('penjualan.edit', $sale)}}" class="btn btn-sm btn-caramel">Lanjutkan</a>
                        @endif

                        @can('delete',$sale)
                        <form action="{{route('penjualan.destroy', $sale)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-soft-danger" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{$sales->links()}}
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
.header-card .btn-caramel {
    flex-shrink: 0;
    white-space: nowrap;
}

@media (max-width: 576px) {
    .header-card {
        flex-wrap: wrap;
    }
    .header-title {
        white-space: normal;
    }
} 
.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #FAF3EA;
    border-radius: 8px;
    padding: 6px 14px;
}
.search-box i {
    color: #8A6D52;
}
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
.btn-outline-caramel {
    background: transparent;
    border: 1.5px solid #C9922E;
    color: #C9922E;
    font-weight: 600;
}
.btn-outline-caramel:hover {
    background: #C9922E;
    color: #fff;
}
.search-input::placeholder {
    color: #B49A82;
}
.btn-caramel:hover { background-color: #A97722; color: #fff; }

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
.table-bakery tbody tr:last-child {
    border-bottom: none;
}

.metode {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .85rem;
    color: #8A6D52;
}

.badge-status {
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
}
.badge-open {
    background: #FAEEDA;
    color: #854F0B;
}
.badge-completed {
    background: #EAF3DE;
    color: #3B6D11;
}
</style>

@endsection