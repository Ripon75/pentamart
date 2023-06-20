<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        Section::insert([
            [
                'name'       => 'First section' ,
                'slug'       => 'first-section',
                'title'      => 'Top Products',
                'created_at' => $now
            ],
            [
                'name'       => 'Second section' ,
                'slug'       => 'second-section',
                'title'      => 'Watch',
                'created_at' => $now
            ],
        ]);

        $data = [
            [
                'section_id' => 1,
                'item_id'    => 1
            ],
            [
                'section_id' => 1,
                'item_id'    => 2
            ],
            [
                'section_id' => 1,
                'item_id'    => 3
            ],
            [
                'section_id' => 1,
                'item_id'    => 4
            ],
            [
                'section_id' => 1,
                'item_id'    => 5
            ],
            [
                'section_id' => 1,
                'item_id'    => 6
            ],
            [
                'section_id' => 1,
                'item_id'    => 7
            ],
            [
                'section_id' => 1,
                'item_id'    => 8
            ],
            [
                'section_id' => 1,
                'item_id'    => 9
            ],
            [
                'section_id' => 1,
                'item_id'    => 10
            ],
            [
                'section_id' => 2,
                'item_id'    => 1
            ],
            [
                'section_id' => 2,
                'item_id'    => 2
            ],
            [
                'section_id' => 2,
                'item_id'    => 3
            ],
            [
                'section_id' => 2,
                'item_id'    => 4
            ],
            [
                'section_id' => 2,
                'item_id'    => 5
            ],
            [
                'section_id' => 2,
                'item_id'    => 6
            ],
            [
                'section_id' => 2,
                'item_id'    => 7
            ],
            [
                'section_id' => 2,
                'item_id'    => 8
            ],
            [
                'section_id' => 2,
                'item_id'    => 9
            ],
            [
                'section_id' => 2,
                'item_id'    => 10
            ],
            [
                'section_id' => 2,
                'item_id'    => 11
            ],
            [
                'section_id' => 2,
                'item_id'    => 12
            ]
        ];

        DB::table('section_item')->insert($data);

    }
}
