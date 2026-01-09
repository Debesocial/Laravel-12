<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\PersonnelArea;
use Modules\Organizational\App\Models\PersonnelSubArea;

class PersonnelSubAreaSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $paHO   = PersonnelArea::where('name', 'Head Office')->first();
            $paSite = PersonnelArea::where('name', 'Mining Site')->first();

            PersonnelSubArea::create([
                'personnel_area_id' => $paHO->id,
                'name'              => 'HO Jakarta',
                'is_active'         => true,
            ]);

            PersonnelSubArea::create([
                'personnel_area_id' => $paSite->id,
                'name'              => 'Site Kalimantan',
                'is_active'         => true,
            ]);

        });
    }
}
