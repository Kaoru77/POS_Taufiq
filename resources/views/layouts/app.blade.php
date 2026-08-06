<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        .alert-bakery-success {
            background: #EAF3DE;
            color: #27500A;
        }
        .alert-bakery-error {
            background: #FCEBEB;
            color: #791F1F;
        }
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
</head>
<body>
    @include('layouts.navbar')

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
</body>
</html>