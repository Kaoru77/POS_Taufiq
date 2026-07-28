<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function auth (LoginRequest $request)
    {

        if (auth::attempt($request->validated())) {
            $request->session()->regenerate();
            // Authentication passed...
            return redirect()->route('dashboard')->with('success', 'Login berhasil.'.auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'email atau password tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
