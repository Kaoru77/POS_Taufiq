@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="dash-wrapper">

    <div class="header-card mb-3">
        <div>
            <div class="header-eyebrow">Manajemen</div>
            <h2 class="header-title mb-0">Daftar User</h2>
        </div>
        <a href="{{route('admin.users.create')}}" class="btn btn-caramel">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
    </div>

    <div class="panel-card mb-3">
        <form action="{{ route('admin.users') }}" method="GET" class="search-box">
            <i class="bi bi-search"></i>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="search-input"
                placeholder="Cari nama atau email...">
            <button class="btn btn-sm btn-outline-caramel" type="submit">Cari</button>
        </form>
    </div>

    <div class="panel-card">
        <table class="table table-bakery align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-initial {{ $user->role->name === 'admin' ? 'avatar-admin' : 'avatar-kasir' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-semibold" style="color:#4E2F1A;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        <span class="badge-role {{ $user->role->name === 'admin' ? 'badge-admin' : 'badge-kasir' }}">
                            {{ ucfirst($user->role->name) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-soft-brown">Detail</a>
                        <a href="{{ route('admin.users.edit',$user)}}" class="btn btn-sm btn-caramel">Edit</a>

                        @if($user->id !== auth()->id())
                        <form action="{{route ('admin.users.destroy', $user)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-soft-danger" onclick="return confirm('Yakin hapus user ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @else
                        <span class="badge-self">IN</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $users->links() }}
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
.search-input::placeholder { color: #B49A82; }

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
.table-bakery tbody tr:last-child {
    border-bottom: none;
}

.avatar-initial {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .72rem;
    font-weight: 700;
    flex-shrink: 0;
}
.avatar-admin { background: #F3E6D8; color: #7B4B2A; }
.avatar-kasir { background: #EAF3DE; color: #3B6D11; }

.badge-role {
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
}
.badge-admin { background: #F3E6D8; color: #7B4B2A; }
.badge-kasir { background: #EAF3DE; color: #3B6D11; }

.badge-self {
    background: #EDEDED;
    color: #777;
    font-size: .72rem;
    padding: 4px 10px;
    border-radius: 999px;
}

@media (max-width: 576px) {
    .header-card { flex-wrap: wrap; }
    .header-title { white-space: normal; }
}
</style>

@endsection