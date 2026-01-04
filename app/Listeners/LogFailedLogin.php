<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        activity('auth')
            ->causedBy($event->user ?? null)
            ->withProperties([
                'email_attempt' => request()->email,
                'ip'            => request()->ip(),
                'agent'         => request()->userAgent(),
            ])
            ->log('failed login');
    }
}