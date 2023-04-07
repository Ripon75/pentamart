<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companiesFilePath    = database_path('data/companies.json');
        $companiesJSONRowData = file_get_contents($companiesFilePath);
        $allData = json_decode($companiesJSONRowData, true);

        $companies = [];
        foreach ($allData as $sdata) {
            $temp = [
                'id'         => $sdata['id'],
                'slug'       => Str::slug($sdata['name'], '-'),
                'name'       => $sdata['display_name'],
                'parent_id'  => $sdata['id'],
                'created_at' => Carbon::now()
            ];

            $companies[] = $temp;
        }

        DB::table('companies')->insert($companies);
    }
}
