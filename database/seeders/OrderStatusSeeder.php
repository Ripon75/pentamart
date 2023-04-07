<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('order_statuses')->insert([
            [
                'id'                  => 1,
                'slug'                => 'submitted',
                'name'                => 'Submitted',
                'bg_color'            => '#546E7A',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 2,
                'slug'                => 'on-hold',
                'name'                => 'On Hold',
                'bg_color'            => '#FF5722',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 3,
                'slug'                => 'under-verified',
                'name'                => 'Under Verified',
                'bg_color'            => '#FFC107',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 4,
                'slug'                => 'under-processing',
                'name'                => 'Under Processing',
                'bg_color'            => '#CDDC39',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 5,
                'slug'                => 'canceled',
                'name'                => 'Canceled',
                'bg_color'            => '#F44336',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 6,
                'slug'                => 'on-way',
                'name'                => 'On Way',
                'bg_color'            => '#673AB7',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 7,
                'slug'                => 'delivered',
                'name'                => 'Delivered',
                'bg_color'            => '#673AB7',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 8,
                'slug'                => 'completed',
                'name'                => 'Completed',
                'bg_color'            => '#4CAF50',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
            [
                'id'                  => 9,
                'slug'                => 'returned',
                'name'                => 'Returned',
                'bg_color'            => '#9C27B0',
                'text_color'          => '#ffffff',
                'seller_visibility'   => true,
                'customer_visibility' => true
            ],
        ]);
    }
}
