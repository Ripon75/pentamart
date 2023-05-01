<?php

namespace Database\Seeders;

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
        $sizes = [
            [
                'name' => 'M',
                'slug' => 'm',
            ],
            [
                'name' => 'L',
                'slug' => 'l',
            ],
            [
                'name' => 'XL',
                'slug' => 'xl',
            ],
            [
                'name' => 'XLL',
                'slug' => 'xll',
            ]
        ];

        DB::table('sizes')->insert($sizes);
    }
}
