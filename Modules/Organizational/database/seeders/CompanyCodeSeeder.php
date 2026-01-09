<?php
namespace Modules\Organizational\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Organizational\App\Models\CompanyCode;

class CompanyCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
DB::transaction(function () {

    CompanyCode::create([
        'name'      => 'PT. Inovasi Tanpa Batas',
        'is_active' => true,
    ]);

    CompanyCode::create([
        'name'      => 'PT. Tenkno Gold Mining',
        'is_active' => true,
    ]);

});

    }
}
