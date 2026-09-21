<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\http\Controllers\Controller;

class AuthController extends Controller
{
    private const LOGIN_MAX_ATTEMPTS = 3;
    private const LOGIN_LOCKOUT_SECONDS = 60;

    public function index(Request $request)
    {
        $lockedEmail = $request->session()->get('login_locked_email');
        $loginLocked = false;
        $lockoutSeconds = 0;

        if ($lockedEmail) {
            $throttleKey = $this->throttleKey($lockedEmail, $request->ip());
            $loginLocked = RateLimiter::tooManyAttempts($throttleKey, self::LOGIN_MAX_ATTEMPTS);
            $lockoutSeconds = $loginLocked ? RateLimiter::availableIn($throttleKey) : 0;

            if (!$loginLocked) {
                $request->session()->forget('login_locked_email');
            }
        }

        return view('login', compact('loginLocked', 'lockoutSeconds'));
    }
    public function auth (LoginRequest $request)
    {
        $email = (string) $request->input('email');
        $throttleKey = $this->throttleKey($email, $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, self::LOGIN_MAX_ATTEMPTS)) {
            $request->session()->put('login_locked_email', $email);

            return back()->withInput(['email' => $email])->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam '.ceil(RateLimiter::availableIn($throttleKey) / 60).' menit.',
            ]);
        }

        if (auth::attempt($request->validated())) {
            RateLimiter::clear($throttleKey);
            $request->session()->forget('login_locked_email');
            $request->session()->regenerate();
            // Authentication passed...
            return redirect()->route('dashboard')->with('success', 'Login berhasil.'.auth::user()->name);
        }

        RateLimiter::hit($throttleKey, self::LOGIN_LOCKOUT_SECONDS);

        if (RateLimiter::tooManyAttempts($throttleKey, self::LOGIN_MAX_ATTEMPTS)) {
            $request->session()->put('login_locked_email', $email);

            return back()->withInput(['email' => $email])->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam '.ceil(self::LOGIN_LOCKOUT_SECONDS / 60).' menit.',
            ]);
        }

        return back()->withInput(['email' => $email])->withErrors([
            'email' => 'email atau password tidak valid.',
        ]);
    }

    private function throttleKey(string $email, ?string $ip): string
    {
        return 'login|'.strtolower($email).'|'.$ip;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
