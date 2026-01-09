<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\SubUnit;
use Modules\Organizational\App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $subUnit = SubUnit::first();

            Position::create([
                'sub_unit_id' => $subUnit->id,
                'name'        => 'Dump Truck Operator',
                'is_active'   => true,
            ]);

        });
    }
}
