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

    if ($request->boolean('remember')) {

        // Set durasi Remember Me (contoh: 30 hari)
        $minutes = 60 * 24 * 30;

        // Buat ulang cookie remember me dengan durasi custom
        cookie()->queue(
            cookie(
                name: Auth::getRecallerName(), 
                value: Auth::getRecallerName(), 
                minutes: $minutes,
                httpOnly: true, // keamanan
                secure: app()->environment('production'), // https di prod
            )
        );
    }
    
// Redirect berdasarkan role
if ($user->hasRole('superadmin')) {
    return redirect()->intended('/dashboard');
}
if ($user->hasRole('admin')) {
    return redirect()->intended('/dashboard');
}
// Default untuk role user
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