<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DosageFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = database_path('data/dosageForms.json');
        $jsonData = file_get_contents($filePath);
        $allData  = json_decode($jsonData, true);

        $dosageForms = [];
        foreach ($allData as $singleData) {
            $temp = [
                'id'         => $singleData['id'],
                'slug'       => $singleData['name'],
                'name'       => $singleData['display_name'],
                'status'     => 'draft',
                'created_at' => Carbon::now()
            ];
            $dosageForms[] = $temp;
        }
        DB::table('dosage_forms')->insert($dosageForms);
    }
}
