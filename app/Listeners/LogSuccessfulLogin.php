<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\User; 

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
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
            ->log('login');
    }
}