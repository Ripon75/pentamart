<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UOMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('uoms')->insert([
            [
                'id'         => 1,
                'slug'       => 'piece',
                'name'       => 'Piece',
                'code'       => 'pcs',
                'created_at' => $now
            ],
            [
                'id'         => 2,
                'slug'       => 'strip',
                'name'       => 'Strip',
                'code'       => 'strip',
                'created_at' => $now
            ],
            [
                'id'         => 3,
                'slug'       => 'bottol',
                'name'       => 'Bottol',
                'code'       => 'bottol',
                'created_at' => $now
            ],
            [
                'id'         => 4,
                'slug'       => 'box',
                'name'       => 'Box',
                'code'       => 'box',
                'created_at' => $now
            ]
        ]);
    }
}
