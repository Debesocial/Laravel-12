<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function creating(User $user)
    {
        if (Auth::check()) {
            $user->created_by = Auth::id();
        }
    }

    public function updating(User $user)
    {
        if (Auth::check()) {
            $user->updated_by = Auth::id();
        }
    }

    public function deleting(User $user)
    {
        if (Auth::check()) {
            $user->updated_by = Auth::id();
        }
    }
}