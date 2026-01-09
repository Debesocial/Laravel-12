<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\PersonnelSubArea;
use Modules\Organizational\App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $psaHO   = PersonnelSubArea::where('name', 'HO Jakarta')->first();
            $psaSite = PersonnelSubArea::where('name', 'Site Kalimantan')->first();

            Division::create([
                'personnel_sub_area_id' => $psaHO->id,
                'name'                  => 'Corporate',
                'is_active'             => true,
            ]);

            Division::create([
                'personnel_sub_area_id' => $psaSite->id,
                'name'                  => 'Mining Operation',
                'is_active'             => true,
            ]);

        });
    }
}
