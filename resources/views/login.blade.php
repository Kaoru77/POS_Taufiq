@extends('layouts.guest')
@section('title', 'Login')
@section('content')

<div class="login-wrapper">

    <div class="login-hero d-none d-md-flex">
        <div class="hero-content text-white">
            <h1 class="fw-bold">🥐 Sweet Crumbs Bakery</h1>
            <p class="fs-5 mb-0">Kehangatan setiap adonan, kelezatan di setiap gigitan.</p>
        </div>
    </div>

    <div class="login-form-panel">
        <div class="login-card p-4 p-md-5">

            <div class="text-center mb-4">
                <div class="brand-icon mb-2">🥐</div>
                <h3 class="fw-bold mb-1" style="color:#4E2F1A;">Sweet Crumbs Bakery</h3>
            </div>

            <form action="{{ route('auth') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
            </form>
        </div>
    </div>

</div>

<style>
.login-wrapper {
    display: flex;
    height: 100vh;
}

.login-hero {
    width: 60%;
    background:
        linear-gradient(rgba(78,47,26,.55), rgba(78,47,26,.8)),
        url('{{ asset('images/croissant.jpg') }}') center/cover no-repeat;
    align-items: flex-end;
    padding: 3rem;
}

.login-form-panel {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #FFF8F0;
}

.login-hero + .login-form-panel {
    width: 40%;
}

.brand-icon {
    font-size: 2.5rem;
}

.login-card {
    width: 100%;
    max-width: 380px;
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(78,47,26,.1);
}

</style>

@endsection