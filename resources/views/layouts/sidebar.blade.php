<div class="sidebar" id="appSidebar">
    <div class="sidebar-brand">
        <span>🥐</span>
        <span>Sweet Crumbs</span>
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="{{ route('admin.users') }}" class="sidebar-link {{ Request::is('admin/users*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('produk.index') }}" class="sidebar-link {{ Request::is('produk*') ? 'active' : '' }}">
            <i class="bi bi-cup-hot"></i> Produk
        </a>
        <a href="{{ route('kategori.index') }}" class="sidebar-link {{ Request::is('kategori*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> Kategori
        </a>
        <a href="{{ route('penjualan.index') }}" class="sidebar-link {{ Request::is('penjualan*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Penjualan
        </a>
        <a href="{{ route('tentang') }}" class="sidebar-link {{ Request::is('tentang') ? 'active' : '' }}">
            <i class="bi bi-info-circle"></i> Tentang
        </a>
    </nav>

    <div class="sidebar-footer">
         <div class="sidebar-user">
        <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
         <div class="sidebar-user-info">
             <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
             <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role->name) }}</div>
         </div>
     </div>
        <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-logout w-100 text-start border-0">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>