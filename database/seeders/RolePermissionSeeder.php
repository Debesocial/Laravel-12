<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard & General
            'view dashboard',
            'view reports',

            // User & Security
            'manage users',             // SUPERADMIN + ADMIN
            'manage roles',             // SUPERADMIN ONLY
            'manage permissions',       // SUPERADMIN ONLY
            'manage sessions',          // SUPERADMIN ONLY

            // Logs & Monitoring
            'view action logs',          // SUPERADMIN ONLY
            'view error logs',           // SUPERADMIN ONLY

            // System Configuration
            'system configuration',     // SUPERADMIN ONLY

            // 🔥 Backup & Maintenance
            'backup & restore',          // SUPERADMIN ONLY
            'manage retention',          // SUPERADMIN ONLY
            'manage notification',       // SUPERADMIN ONLY
        ];

        /**
         * =====================================================
         * Create / Update Permissions
         * =====================================================
         */
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['is_active' => 1]
            );
        }

        /**
         * =====================================================
         * Create Roles
         * =====================================================
         */
        $superadmin = Role::updateOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $admin      = Role::updateOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user       = Role::updateOrCreate(['name' => 'user', 'guard_name' => 'web']);

        /*
        |--------------------------------------------------------------------------
        | DISTRIBUSI PERMISSION
        |--------------------------------------------------------------------------
        */

        // 🟣 SUPERADMIN — Full Control
        $superadmin->syncPermissions([
            'view dashboard',
            'view reports',
            'manage users',
            'manage roles',
            'manage permissions',
            'manage sessions',
            'view action logs',
            'view error logs',
            'system configuration',
            'backup & restore',
            'manage retention',
            'manage notification',
        ]);

        // 🔵 ADMIN — Operasional
        $admin->syncPermissions([
            'view dashboard',
            'view reports',
            'manage users',
        ]);

        // 🟢 USER — Basic Access
        $user->syncPermissions([
            'view dashboard',
            'view reports',
        ]);
    }
}