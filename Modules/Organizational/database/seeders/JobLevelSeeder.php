<?php

namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\Position;
use Modules\Organizational\App\Models\JobLevel;

class JobLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $position = Position::first();

            JobLevel::create([
                'position_id' => $position->id,
                'name'        => 'Junior',
                'level_order' => 1,
                'is_active'   => true,
            ]);

            JobLevel::create([
                'position_id' => $position->id,
                'name'        => 'Senior',
                'level_order' => 2,
                'is_active'   => true,
            ]);

        });
    }
}
