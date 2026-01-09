<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\Section;
use Modules\Organizational\App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $section = Section::where('name', 'Production Section')->first();

            Unit::create([
                'section_id' => $section->id,
                'name'       => 'Production Unit',
                'is_active'  => true,
            ]);

        });
    }
}
