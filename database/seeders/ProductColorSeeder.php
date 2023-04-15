<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productColors = [
            [
                'product_id' => 1,
                'color_id' => 1,
            ],
            [
                'product_id' => 1,
                'color_id' => 2,
            ],
            [
                'product_id' => 1,
                'color_id' => 3,
            ],
            [
                'product_id' => 1,
                'color_id' => 4,
            ],
            [
                'product_id' => 2,
                'color_id' => 1,
            ],
            [
                'product_id' => 2,
                'color_id' => 2,
            ],
            [
                'product_id' => 2,
                'color_id' => 3,
            ],
            [
                'product_id' => 2,
                'color_id' => 4,
            ],
            [
                'product_id' => 3,
                'color_id' => 1,
            ],
            [
                'product_id' => 3,
                'color_id' => 2,
            ],
            [
                'product_id' => 3,
                'color_id' => 3,
            ],
            [
                'product_id' => 3,
                'color_id' => 4,
            ],
        ];

        DB::table('product_colors')->insert($productColors);
    }
}
