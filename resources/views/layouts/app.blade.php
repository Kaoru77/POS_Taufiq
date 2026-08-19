<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background: #4E2F1A;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .sidebar-brand {
            padding: 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
        }
        .sidebar-menu {
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #D9BFA3;
            text-decoration: none;
            font-size: .85rem;
            background: none;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }
        .sidebar-link.active {
            background: rgba(255,255,255,.1);
            color: #F3C77A;
            font-weight: 600;
        }
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-logout {
            color: #F3A5A5;
        }
        .sidebar-logout:hover {
            background: rgba(247,193,193,.1);
            color: #fff;
        }

        .main-content {
            flex: 1;
            min-width: 0;
        }

        .sidebar-toggle {
            display: none;
            background: #4E2F1A;
            color: #fff;
            border: none;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            font-size: 18px;
            margin: 12px;
        }

        .sidebar-overlay {
            display: none;
        }

        /* Tampilan HP: sidebar disembunyikan, muncul lewat tombol hamburger */
        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform .25s ease;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-toggle {
                display: block;
            }
            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.4);
                z-index: 1040;
            }
            .sidebar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 10px 14px;
}
.sidebar-user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    color: #F3C77A;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 700;
    flex-shrink: 0;
}
.sidebar-user-info {
    min-width: 0;
}
.sidebar-user-name {
    color: #fff;
    font-size: .82rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sidebar-user-role {
    color: #D9BFA3;
    font-size: .72rem;
}
        }
    </style>
</head>
<body class="m-0 p-0">

    <div class="app-shell">

        @include('layouts.sidebar')

        <div class="main-content">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div class="container-fluid px-4 py-3">

                @if (session('success'))
                    <div class="alert-bakery alert-bakery-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close-bakery" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-bakery alert-bakery-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close-bakery" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    </div>

    <style>
        .alert-bakery {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: .9rem;
            margin-bottom: 1rem;
        }
        .alert-bakery-success { background: #EAF3DE; color: #27500A; }
        .alert-bakery-error { background: #FCEBEB; color: #791F1F; }
        .btn-close-bakery {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 1.1rem;
            line-height: 1;
            color: inherit;
            opacity: .6;
            cursor: pointer;
        }
        .btn-close-bakery:hover { opacity: 1; }
    </style>

    <script>
        const toggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }

        if (toggle) {
            toggle.addEventListener('click', function () {
                sidebar.classList.add('open');
                overlay.classList.add('show');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }
    </script>

</body>
</html>