<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = database_path('data/brands.json');
        $jsonData = file_get_contents($filePath);
        $allData  = json_decode($jsonData, true);

        foreach (array_chunk($allData, 500) as $cData) {
            $brands = [];
            foreach ($cData as $sData) {
                $temp = [
                    'id'         => $sData['id'],
                    'slug'       => $sData['name'],
                    'name'       => $sData['display_name'],
                    'status'     => 'activated',
                    'created_at' => Carbon::now()
                ];
                $brands[] = $temp;
            }
            DB::table('brands')->insert($brands);
        }
    }
}
