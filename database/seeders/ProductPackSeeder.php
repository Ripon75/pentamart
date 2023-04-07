<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductPackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('product_packs')->insert([
            [
                'id'            => 1,
                'product_id'    => 1,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 1,
                'price'         => 10.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 2,
                'product_id'    => 1,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 120,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 3,
                'product_id'    => 1,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'           => 50,
                'price'         => 500,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 4,
                'product_id'    => 2,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 1,
                'price'         => 21.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 5,
                'product_id'    => 2,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 218.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 6,
                'product_id'    => 2,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 350,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 7,
                'product_id'    => 3,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 28.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 8,
                'product_id'    => 3,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 118.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 9,
                'product_id'    => 3,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 250,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 10,
                'product_id'    => 4,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 38.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 11,
                'product_id'    => 4,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 90.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 12,
                'product_id'    => 4,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 210,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 13,
                'product_id'    => 5,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 48.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 14,
                'product_id'    => 5,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 70.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 15,
                'product_id'    => 5,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 180,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 16,
                'product_id'    => 6,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 18.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 17,
                'product_id'    => 6,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 30.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 18,
                'product_id'    => 6,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 80,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 19,
                'product_id'    => 7,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 18.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 20,
                'product_id'    => 7,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 30.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 21,
                'product_id'    => 7,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 80,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 22,
                'product_id'    => 8,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 21.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 23,
                'product_id'    => 8,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 34.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 24,
                'product_id'    => 8,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 143,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 25,
                'product_id'    => 9,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 33.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 26,
                'product_id'    => 9,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 55.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 27,
                'product_id'    => 9,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 310,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 28,
                'product_id'    => 10,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 25.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 29,
                'product_id'    => 10,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 78.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 30,
                'product_id'    => 10,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 190,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 31,
                'product_id'    => 11,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 27.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 32,
                'product_id'    => 11,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 65.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 33,
                'product_id'    => 11,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 150,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 34,
                'product_id'    => 12,
                'uom_id'        => 1,
                'name'          => '1 Piece',
                'slug'          => '1-piece',
                'piece'         => 15,
                'price'         => 38.17,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 35,
                'product_id'    => 12,
                'uom_id'        => 2,
                'name'          => '1 Strip',
                'slug'          => '1-strip',
                'piece'         => 10,
                'price'         => 70.0,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ],
            [
                'id'            => 36,
                'product_id'    => 12,
                'uom_id'        => 4,
                'name'          => '1 Box',
                'slug'          => '1-box',
                'piece'         => 50,
                'price'         => 280,
                'min_order_qty' => 1,
                'max_order_qty' => 100
            ]
        ]);
    }
}
