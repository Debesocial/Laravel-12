<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // SUPERADMIN
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => 'SAPlogon2010!',
                'role' => 'superadmin',
            ],

            // ADMINS
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'SAPlogon2010!',
                'role' => 'admin',
            ],

            // USERS
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => 'SAPlogon2010!',
                'role' => 'user',
            ],
        ];

        foreach ($users as $data) {

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}