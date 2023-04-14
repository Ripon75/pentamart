<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $data = [
            [
                'id'         => 1,
                'slug'       => 'Category 1',
                'name'       => 'category-1',
                'status'     => 'active',
                'created_at' => $now
            ],
            [
                'id'         => 2,
                'slug'       => 'Category 2',
                'name'       => 'category-2',
                'status'     => 'active',
                'created_at' => $now
            ],
            [
                'id'         => 3,
                'slug'       => 'Category 3',
                'name'       => 'category-3',
                'status'     => 'active',
                'created_at' => $now
            ],
            [
                'id'         => 4,
                'slug'       => 'Category 4',
                'name'       => 'category-4',
                'status'     => 'active',
                'created_at' => $now
            ],
            [
                'id'         => 5,
                'slug'       => 'Category 5',
                'name'       => 'category-5',
                'status'     => 'active',
                'created_at' => $now
            ],
        ];

        DB::table('categories')->insert($data);
    }
}
