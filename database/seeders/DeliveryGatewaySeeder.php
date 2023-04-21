<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DeliveryGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('delivery_gateways')->insert([
            [
                'id'                 => 1,
                'slug'               => 'basic',
                'name'               => 'Basic',
                'code'               => 'DG101',
                'price'              => 10,
                'status'             => 'active',
                'min_delivery_time'  => 1,
                'max_delivery_time'  => 2,
                'delivery_time_unit' => 'Days',
                'created_at'         => $now
            ]
        ]);
    }
}
