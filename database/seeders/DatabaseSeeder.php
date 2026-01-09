<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Organizational\Database\Seeders\OrganizationalDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,

            // 🔽 MODULE ORGANIZATIONAL
            OrganizationalDatabaseSeeder::class,
        ]);
    }
}
