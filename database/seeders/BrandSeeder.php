<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'name'   => 'Brand 1',
                'slug'   => 'brand-1',
                'status' => 'active',
                'is_top' => 1,
            ],
            [
                'name'   => 'Brand 2',
                'slug'   => 'brand-2',
                'status' => 'active',
                'is_top' => 1,
            ],
            [
                'name'   => 'Brand 3',
                'slug'   => 'brand-3',
                'status' => 'active',
                'is_top' => 1,
            ]
        ];

        DB::table('brands')->insert($brands);
    }
}
