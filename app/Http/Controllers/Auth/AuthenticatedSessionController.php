<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Halaman login
    public function create(): View
    {
        return view('auth.login');
    }

    // Proses login
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi kredensial user
        $request->authenticate();

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Arahkan admin ke dashboard
        if ($user->hasRole('admin')) {
            return redirect()->intended('/dashboard');
        }

        // Arahkan user lain (default)
        return redirect()->intended('/dashboard');
    }

    // Logout user & destroy session
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Invalidate session untuk keamanan
        $request->session()->invalidate();

        // Generate ulang CSRF token
        $request->session()->regenerateToken();

        // Kembali ke halaman utama
        return redirect('/');
    }
}