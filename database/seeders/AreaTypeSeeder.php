<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AreaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id'          => 1,
                'slug'        => 'region',
                'name'        => 'Region',
                'description' => null,
                'created_at'  => Carbon::now()
            ],
            [
                'id'          => 2,
                'slug'        => 'area',
                'name'        => 'Area',
                'description' => null,
                'created_at'  => Carbon::now()
            ],
            [
                'id'          => 3,
                'slug'        => 'territory',
                'name'        => 'Territory',
                'description' => null,
                'created_at'  => Carbon::now()
            ]
        ];

        DB::table('area_types')->insert($data);
    }
}
