<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\Unit;
use Modules\Organizational\App\Models\SubUnit;

class SubUnitSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $unit = Unit::where('name', 'Production Unit')->first();

            SubUnit::create([
                'unit_id'   => $unit->id,
                'name'      => 'Production Sub Unit A',
                'is_active' => true,
            ]);

        });
    }
}
