<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * START IMPERSONATE
     */
    public function start(User $user)
    {
        $authUser = Auth::user();

        /**
         * =====================================================
         * VALIDASI AKSES — HANYA SUPER ADMIN
         * =====================================================
         */
        abort_if(
            $user->hasRole('superadmin', 'web'),
            403,
            __('Only Super Admin can impersonate users.')
        );


        /**
         * =====================================================
         * CEGAH IMPERSONATE DIRI SENDIRI
         * =====================================================
         */
        abort_if(
            $authUser->id === $user->id,
            403,
            __('You cannot impersonate yourself.')
        );

        /**
         * =====================================================
         * CEGAH IMPERSONATE SESAMA SUPER ADMIN
         * =====================================================
         */
        abort_if(
            $user->hasRole('superadmin', 'web'),
            403,
            __('You cannot impersonate another Super Admin.')
        );

        /**
         * =====================================================
         * CEK STATUS USER
         * =====================================================
         */
        abort_if(
            ! $user->is_active,
            403,
            __('User is inactive.')
        );

        /**
         * =====================================================
         * CEGAH LOOP IMPERSONATE
         * =====================================================
         */
        if (session()->has('impersonator_id')) {
            return redirect()->back()
                ->with('error', __('You are already impersonating another user.'));
        }

        /**
         * =====================================================
         * SIMPAN SUPER ADMIN ID
         * =====================================================
         */
        session([
            'impersonator_id' => $authUser->id,
        ]);

        /**
         * =====================================================
         * LOGIN SEBAGAI USER TARGET
         * =====================================================
         */
        Auth::loginUsingId($user->id);

        return redirect()->route('dashboard')
            ->with('success', __('You are now impersonating this user.'));
    }

    /**
     * STOP IMPERSONATE
     */
    public function stop()
    {
        abort_if(
            ! session()->has('impersonator_id'),
            403,
            __('No impersonation session found.')
        );

        $superAdminId = session()->pull('impersonator_id');

        Auth::loginUsingId($superAdminId);

        return redirect()->route('users')
            ->with('success', __('Returned to Super Admin account.'));
    }
}