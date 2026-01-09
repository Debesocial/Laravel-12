<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;

class OrganizationalDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CompanyCodeSeeder::class,
            PersonnelAreaSeeder::class,
            PersonnelSubAreaSeeder::class,
            DivisionSeeder::class,
            DepartmentSeeder::class,
            SectionSeeder::class,
            UnitSeeder::class,
            SubUnitSeeder::class,
            PositionSeeder::class,
            JobLevelSeeder::class,
        ]);
    }
}
