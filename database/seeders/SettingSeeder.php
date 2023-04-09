<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Setting::truncate();
        $now = Carbon::now();

        Setting::insert([
            [
                'key'             => 'app_name',
                'value'           => 'Pentamart',
                'value_cast_type' => 'string',
                'group'           => 'general',
                'created_at'      => $now
            ],
            [
                'key'             => 'app_logo_src',
                'value'           => '/images/logos/logo.svg',
                'value_cast_type' => 'string',
                'group'           => 'general',
                'created_at'      => $now
            ],
            [
                'key'             => 'app_country',
                'value'           => 'BD',
                'value_cast_type' => 'string',
                'group'           => 'general',
                'created_at'      => $now
            ],
            [
                'key'             => 'app_currency_name',
                'value'           => 'BDT',
                'value_cast_type' => 'string',
                'group'           => 'general',
                'created_at'      => $now
            ],
            [
                'key'             => 'app_currency_symbol',
                'value'           => 'Tk',
                'value_cast_type' => 'string',
                'group'           => 'general',
                'created_at'      => $now
            ],
            [
                'key'             => 'app_timezone',
                'value'           => 'Asia/Dhaka',
                'value_cast_type' => 'string',
                'group'           => 'general',
                'created_at'      => $now
            ],
            [
                'key'             => 'app_debug',
                'value'           => 'true',
                'value_cast_type' => 'boolean',
                'group'           => 'general',
                'created_at'      => $now
            ]
        ]);
    }
}
