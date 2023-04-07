<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('payment_gateways')->insert([
            [
                'id'         => 1,
                'slug'       => 'cash-on-delivery',
                'name'       => 'Cash on Delivery',
                'code'       => 'PG101',
                'icon'       => 'fa-solid fa-hand-holding-dollar',
                'status'     => 'activated',
                'created_at' => $now
            ],
            [
                'id'         => 2,
                'slug'       => 'online-payment',
                'name'       => 'Card Payment',
                'code'       => 'PG102',
                'icon'       => 'fa-solid fa-credit-card',
                'status'     => 'activated',
                'created_at' => $now
            ],
            [
                'id'         => 3,
                'slug'       => 'mobile-payment',
                'name'       => 'Mobile Payment',
                'code'       => 'PG103',
                'icon'       => 'fa-solid fa-mobile-screen-button',
                'status'     => 'draft',
                'created_at' => $now
            ]
        ]);
    }
}
