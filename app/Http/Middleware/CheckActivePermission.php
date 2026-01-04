<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class CheckActivePermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $permissionModel = Permission::where('name', $permission)->first();

        // If permission not found OR inactive -> deny access
        if (!$permissionModel || !$permissionModel->is_active) {
            abort(403, 'This permission is inactive or not available.');
        }

        // Continue request (permission is active)
        return $next($request);
    }
}