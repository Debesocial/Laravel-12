<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\User;

class LogLogout
{
    public function handle(Logout $event): void
    {
        // 🛑 HANDLE CASE: user sudah null (session expired / forced logout)
        if (!$event->user) {
            activity('auth')
                ->withProperties([
                    'ip'    => request()->ip(),
                    'agent' => request()->userAgent(),
                ])
                ->log('logout - user session expired / forced logout');
            return; // <-- keluar, karena tidak ada user untuk diinjek
        }

        // 🧍 user ada → pastikan pakai Model User asli
        $user = $event->user instanceof User
            ? $event->user
            : User::find($event->user->id);

        activity('auth')
            ->causedBy($user)
            ->withProperties([
                'email' => $user?->email,
                'ip'    => request()->ip(),
                'agent' => request()->userAgent(),
            ])
            ->log('logout');
    }
}