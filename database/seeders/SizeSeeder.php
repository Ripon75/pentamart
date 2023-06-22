<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $sizes = [
            [
                'name'       => 'NA',
                'slug'       => 'na',
                'created_at' => $now
            ],
            [
                'name'       => 'M',
                'slug'       => 'm',
                'created_at' => $now
            ],
            [
                'name'       => 'L',
                'slug'       => 'l',
                'created_at' => $now
            ],
            [
                'name'       => 'XL',
                'slug'       => 'xl',
                'created_at' => $now
            ],
            [
                'name'       => 'XLL',
                'slug'       => 'xll',
                'created_at' => $now
            ]
        ];

        DB::table('sizes')->insert($sizes);
    }
}
