<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $colors = [
            [
                'name'       => 'NA',
                'slug'       => 'na',
                'created_at' => $now
            ],
            [
                'name'       => 'Black',
                'slug'       => 'black',
                'created_at' => $now
            ],
            [
                'name'       => 'Blue',
                'slug'       => 'blue',
                'created_at' => $now
            ],
            [
                'name'       => 'Green',
                'slug'       => 'green',
                'created_at' => $now
            ],
            [
                'name'       => 'Red',
                'slug'       => 'red',
                'created_at' => $now
            ],
            [
                'name'       => 'White',
                'slug'       => 'white',
                'created_at' => $now
            ]
        ];

        DB::table('colors')->insert($colors);
    }
}
