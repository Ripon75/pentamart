<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = database_path('data/generics.json');
        $jsonData = file_get_contents($filePath);
        $allData  = json_decode($jsonData, true);

        $generics = [];
        foreach ($allData as $singledata) {
            $temp = [
                'id'         => $singledata['id'],
                'slug'       => $singledata['name'],
                'name'       => $singledata['display_name'],
                'strength'   => $singledata['strength'],
                'created_at' => Carbon::now()
            ];
            $generics[] = $temp;
        }
        DB::table('generics')->insert($generics);
    }
}
