<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                'slug'       => 'medicine',
                'name'       => 'Medicine',
                'status'     => 'draft',
                'parent_id'  => null,
                'created_at' => $now
            ],
            [
                'id'         => 2,
                'slug'       => 'skin-care',
                'name'       => 'Skin care',
                'status'     => 'draft',
                'parent_id'  => 1,
                'created_at' => $now
            ],
            [
                'id'         => 3,
                'slug'       => 'gastric',
                'name'       => 'Gastric',
                'status'     => 'draft',
                'parent_id'  => 2,
                'created_at' => $now
            ],
            [
                'id'         => 4,
                'slug'       => 'others',
                'name'       => 'Others',
                'status'     => 'draft',
                'parent_id'  => 3,
                'created_at' => $now
            ],
            [
                'id'         => 5,
                'slug'       => 'medical-devices',
                'name'       => 'Medical Devices',
                'status'     => 'draft',
                'parent_id'  => 4,
                'created_at' => $now
            ],
            [
                'id'         => 6,
                'slug'       => 'men-care',
                'name'       => 'Men Care',
                'status'     => 'draft',
                'parent_id'  => null,
                'created_at' => $now
            ],
            [
                'id'         => 7,
                'slug'       => 'women-care',
                'name'       => 'Women Care',
                'status'     => 'draft',
                'parent_id'  => null,
                'created_at' => $now
            ],
            [
                'id'         => 8,
                'slug'       => 'personal-care',
                'name'       => 'Personal Care',
                'status'     => 'draft',
                'parent_id'  => null,
                'created_at' => $now
            ],
            [
                'id'         => 9,
                'slug'       => 'herbal-homeopathy',
                'name'       => 'Herbal & Homeopathy',
                'status'     => 'draft',
                'parent_id'  => null,
                'created_at' => $now
            ],
            [
                'id'         => 10,
                'slug'       => 'baby-mom-care',
                'name'       => 'Baby & Mom Care',
                'status'     => 'draft',
                'parent_id'  => null,
                'created_at' => $now
            ]
        ];

        DB::table('categories')->insert($data);
    }
}
