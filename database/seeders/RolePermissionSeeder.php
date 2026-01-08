<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS (VIEW vs MANAGE)
        |--------------------------------------------------------------------------
        */
        $permissions = [

            // Dashboard
            'view dashboard',

            // User Management
            'view users',
            'manage users',

            // Role Management
            'view roles',
            'manage roles',

            // Permission Management
            'view permissions',
            'manage permissions',

            // Action & Error Logs
            'view action logs',
            'view error logs',
            'manage error logs',

            // System Settings
            'view system config',
            'manage system config',

            // Session Manager
            'view sessions',
            'manage sessions',

            // Resource Monitoring
            'view resource monitoring',

            // Notification Center
            'view notifications',
            'manage notifications',

            // Impersonate
            'impersonate users',
        ];

        /*
        |--------------------------------------------------------------------------
        | CREATE / UPDATE PERMISSIONS
        |--------------------------------------------------------------------------
        */
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ],
                [
                    'is_active' => 1,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */
        $superadmin = Role::updateOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $admin      = Role::updateOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user       = Role::updateOrCreate(['name' => 'user', 'guard_name' => 'web']);

        /*
        |--------------------------------------------------------------------------
        | ROLE → PERMISSION MAPPING
        |--------------------------------------------------------------------------
        */

        // 🟣 SUPERADMIN — FULL ACCESS
        $superadmin->syncPermissions($permissions);

        // 🔵 ADMIN — OPERASIONAL (NO SYSTEM CORE)
        $admin->syncPermissions([
            'view dashboard',

            'view users',
            'manage users',

            'view notifications',
            'manage notifications',
        ]);

        // 🟢 USER — READ ONLY
        $user->syncPermissions([
            'view dashboard',
        ]);
    }
}