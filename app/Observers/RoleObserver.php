<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleObserver
{
    /**
     * Ketika role dibuat
     */
    public function creating(Role $role)
    {
        if (Auth::check()) {
            $role->created_by = Auth::id();
        }
    }

    /**
     * Ketika role diupdate
     */
    public function updating(Role $role)
    {
        if (Auth::check()) {
            $role->updated_by = Auth::id();
        }
    }

    /**
     * Saat role dihapus (soft delete)
     */
    public function deleting(Role $role)
    {
        if (Auth::check()) {
            $role->updated_by = Auth::id();
            $role->saveQuietly(); // Hindari loop & double log
        }
    }

    /**
     * Saat status role di-toggle
     */
    public function toggleStatus(Role $role)
    {
        if (Auth::check()) {
            $role->updated_by = Auth::id();
        }
    }

    
}