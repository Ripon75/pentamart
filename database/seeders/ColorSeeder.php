<?php

namespace Database\Seeders;

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
        $colors = [
            [
                'name' => 'Black',
                'slug' => 'black',
            ],
            [
                'name' => 'White',
                'slug' => 'white',
            ],
            [
                'name' => 'Red',
                'slug' => 'red',
            ],
            [
                'name' => 'Blue',
                'slug' => 'blue',
            ],
            [
                'name' => 'Green',
                'slug' => 'green',
            ]
        ];

        DB::table('colors')->insert($colors);
    }
}
