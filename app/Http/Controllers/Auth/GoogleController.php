<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', __('Google authentication failed.'));
        }

        $user = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        /**
         * =====================================================
         * REGISTER BARU (AUTO ASSIGN ROLE)
         * =====================================================
         */
        if (!$user) {
            $user = User::create([
                'name'       => $googleUser->name,
                'email'      => $googleUser->email,
                'google_id'  => $googleUser->id,
                'avatar'     => $googleUser->avatar,
                'password'   => bcrypt(Str::random(32)),
            ]);

            // ✅ AUTO ASSIGN ROLE DEFAULT
            $user->assignRole('user');
        } else {
            // sync google id jika login pertama kali via Google
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar'    => $googleUser->avatar,
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}