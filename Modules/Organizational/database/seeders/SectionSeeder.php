<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\Department;
use Modules\Organizational\App\Models\Section;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $prod = Department::where('name', 'Production')->first();

            Section::create([
                'department_id' => $prod->id,
                'name'          => 'Production Section',
                'is_active'     => true,
            ]);

            Section::create([
                'department_id' => $prod->id,
                'name'          => 'Operator Section',
                'is_active'     => true,
            ]);

        });
    }
}
