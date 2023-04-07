<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = ['Shop 1', 'Shop 2', 'Shop 3', 'Shop 4', 'Shop 5', 'Shop 6', 'Shop 7', 'Shop 8', 'Shop 9', 'Shop 10'];
        foreach ($shops as $shop) {
            DB::table('shops')->insert([
                'slug'          => Str::slug($shop, '-'),
                'name'          => $shop,
                'status'        => 'activated',
                'owner_id'      => rand(1, 4),
                'registered_at' => Carbon::now()
            ]);
        }
    }
}
