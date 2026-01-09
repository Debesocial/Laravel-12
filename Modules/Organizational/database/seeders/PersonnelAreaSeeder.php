<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\CompanyCode;
use Modules\Organizational\App\Models\PersonnelArea;

class PersonnelAreaSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $company = CompanyCode::first();

            PersonnelArea::create([
                'company_code_id' => $company->id,
                'name'            => 'Head Office',
                'is_active'       => true,
            ]);

            PersonnelArea::create([
                'company_code_id' => $company->id,
                'name'            => 'Mining Site',
                'is_active'       => true,
            ]);

        });
    }
}
