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
        | PERMISSIONS (AKSI)
        |--------------------------------------------------------------------------
        */
        $permissions = [
            'view dashboard',
            'manage users',
            'approve document',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES (AREA / JABATAN)
        |--------------------------------------------------------------------------
        */
        $admin    = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $approver = Role::firstOrCreate(['name' => 'approver', 'guard_name' => 'web']);
        $manager  = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $user     = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN PERMISSION KE ROLE
        |--------------------------------------------------------------------------
        */
        $admin->syncPermissions([
            'view dashboard',
            'manage users',
            'approve document',
            'view reports',
        ]);

        $approver->syncPermissions([
            'view dashboard',
            'approve document',
        ]);

        $manager->syncPermissions([
            'view dashboard',
            'view reports',
        ]);

        $user->syncPermissions([
            'view dashboard',
        ]);
    }
}
