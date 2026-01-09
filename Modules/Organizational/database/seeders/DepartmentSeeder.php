<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\Division;
use Modules\Organizational\App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $corp   = Division::where('name', 'Corporate')->first();
            $mining = Division::where('name', 'Mining Operation')->first();

            Department::create([
                'division_id' => $corp->id,
                'name'        => 'Human Resources',
                'is_active'   => true,
            ]);

            Department::create([
                'division_id' => $mining->id,
                'name'        => 'Production',
                'is_active'   => true,
            ]);

        });
    }
}
