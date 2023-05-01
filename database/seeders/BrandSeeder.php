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
        $brands = [
            [
                'name'    => 'Brand 1',
                'slug'    => 'brand-1',
                'status'  => 'active',
                'img_src' => '/images/sample/brand.jpeg'
            ],
            [
                'name'    => 'Brand 2',
                'slug'    => 'brand-2',
                'status'  => 'active',
                'img_src' => '/images/sample/brand.jpeg'
            ],
            [
                'name'    => 'Brand 3',
                'slug'    => 'brand-3',
                'status'  => 'active',
                'img_src' => '/images/sample/brand.jpeg'
            ]
        ];

        DB::table('brands')->insert($brands);
    }
}
