<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Section;
use Illuminate\Database\Seeder;
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
                'name'       => 'Top Products' ,
                'slug'       => 'top-products',
                'created_at' => $now
            ],
            [
                'name'       => 'Medical Devices' ,
                'slug'       => 'medical-devices',
                'created_at' => $now
            ],
        ]);
    }
}
