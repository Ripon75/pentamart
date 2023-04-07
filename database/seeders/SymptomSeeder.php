<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('symptoms')->insert([
            [
            'id'         => 1,
            'slug'       => 'stomach-pain',
            'name'       => 'Stomach Pain',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 2,
            'slug'       => 'fever',
            'name'       => 'Fever',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 3,
            'slug'       => 'pregnant',
            'name'       => 'Pregnant',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 4,
            'slug'       => 'joint-pain',
            'name'       => 'Joint pain',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 5,
            'slug'       => 'headache',
            'name'       => 'Headache',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 6,
            'slug'       => 'newborn-baby',
            'name'       => 'Newborn Baby',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 7,
            'slug'       => 'diabetes',
            'name'       => 'Diabetes',
            'status'     => 'draft',
            'created_at' => $now
            ],
            [
            'id'         => 8,
            'slug'       => 'over-weight',
            'name'       => 'Over Weight',
            'status'     => 'draft',
            'created_at' => $now
            ]
        ]);
    }
}
