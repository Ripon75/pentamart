<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ]
        ]);
    }
}
