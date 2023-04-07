<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Area;
use Carbon\Carbon;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // Area::truncate();

        // Artisan::call('scout:flush "App\\Models\\Product"');

        $csvFile   = fopen(base_path("database/data/area.csv"), "r");
        $firstline = true;


        while (($data = fgetcsv($csvFile, 2500, ",")) !== false) {
            if (!$firstline) {
                $areaID = $data['0'];
                $name = $data['1'];
                $slug = Str::slug($name, '-');

                if ($name) {
                    $areaObj                 = new Area();
                    $areaObj->id             = $areaID;
                    $areaObj->name           = $name;
                    $areaObj->slug           = $slug;
                    $areaObj->save();
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
