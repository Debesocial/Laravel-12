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
            [
                'name'  => 'Admin Utama',
                'email' => 'admin1@example.com',
                'password' => 'password123',
                'role' => 'admin',
            ],
            [
                'name'  => 'Admin Kedua',
                'email' => 'admin2@example.com',
                'password' => 'password123',
                'role' => 'admin',
            ],
            [
                'name'  => 'User A',
                'email' => 'user1@example.com',
                'password' => 'password123',
                'role' => 'user',
            ],
            [
                'name'  => 'User B',
                'email' => 'user2@example.com',
                'password' => 'password123',
                'role' => 'user',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            // Assign role (Spatie)
            $user->syncRoles([$data['role']]);
        }
    }
}
