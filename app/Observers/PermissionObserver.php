<?php

namespace App\Observers;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionObserver
{
    /**
     * Ketika permission dibuat
     */
    public function creating(Permission $permission)
    {
        if (Auth::check()) {
            $permission->created_by = Auth::id();
        }
    }

    /**
     * Ketika permission diupdate
     */
    public function updating(Permission $permission)
    {
        if (Auth::check()) {
            $permission->updated_by = Auth::id();
        }
    }

    /**
     * Saat permission dihapus (soft delete)
     */
    public function deleting(Permission $permission)
    {
        if (Auth::check()) {
            $permission->updated_by = Auth::id();
            $permission->saveQuietly(); // hindari trigger log berulang
        }
    }
}