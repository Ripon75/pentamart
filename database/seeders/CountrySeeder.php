<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name'            => 'Bangladesh',
            'code'            => 'BGD',
            'currency_code'   => 'BDT',
            'currency_symbol' => 'TK',
            'created_at'      => Carbon::now()
        ]);
    }
}
