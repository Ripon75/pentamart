<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $districts = [
            [
                'name'       => 'Dhaka',
                'slug'       => 'dhaka',
                'created_at' => $now
            ],
            [
                'name'       => 'Barguna',
                'slug'       => 'barguna',
                'created_at' => $now
            ],
            [
                'name'       => 'Barisal',
                'slug'       => 'barisal',
                'created_at' => $now
            ],
            [
                'name'       => 'Bhola',
                'slug'       => 'bhola',
                'created_at' => $now
            ],
            [
                'name'       => 'Jhalokati',
                'slug'       => 'jhalokati',
                'created_at' => $now
            ],
            [
                'name'       => 'Patuakhali',
                'slug'       => 'patuakhali',
                'created_at' => $now
            ],
            [
                'name'       => 'Pirojpur',
                'slug'       => 'pirojpur',
                'created_at' => $now
            ],
            [
                'name'       => 'Bandarban',
                'slug'       => 'bandarban',
                'created_at' => $now
            ],
            [
                'name'       => 'Brahmanbaria',
                'slug'       => 'brahmanbaria',
                'created_at' => $now
            ],
            [
                'name'       => 'Chandpur',
                'slug'       => 'chandpur',
                'created_at' => $now
            ],
            [
                'name'       => 'Chittagong',
                'slug'       => 'chittagong',
                'created_at' => $now
            ],
            [
                'name'       => 'Comilla',
                'slug'       => 'comilla',
                'created_at' => $now
            ],
            [
                'name'       => "Cox's Bazar",
                'slug'       => "cox's-bazar",
                'created_at' => $now
            ],
            [
                'name'       => "Feni",
                'slug'       => "feni",
                'created_at' => $now
            ],
            [
                'name'       => "Khagrachhari",
                'slug'       => "khagrachhari",
                'created_at' => $now
            ],
            [
                'name'       => "Lakshmipur",
                'slug'       => "lakshmipur",
                'created_at' => $now
            ],
            [
                'name'       => "Noakhali",
                'slug'       => "noakhali",
                'created_at' => $now
            ],
            [
                'name'       => "Rangamati",
                'slug'       => "rangamati",
                'created_at' => $now
            ],
            [
                'name'       => "Faridpur",
                'slug'       => "faridpur",
                'created_at' => $now
            ],
            [
                'name'       => "Gazipur",
                'slug'       => "gazipur",
                'created_at' => $now
            ],
            [
                'name'       => "Gopalganj",
                'slug'       => "gopalganj",
                'created_at' => $now
            ],
            [
                'name'       => "Kishoreganj",
                'slug'       => "kishoreganj",
                'created_at' => $now
            ],
            [
                'name'       => "Madaripur",
                'slug'       => "madaripur",
                'created_at' => $now
            ],
            [
                'name'       => "Manikganj",
                'slug'       => "manikganj",
                'created_at' => $now
            ],
            [
                'name'       => "Munshiganj",
                'slug'       => "munshiganj",
                'created_at' => $now
            ],
            [
                'name'       => "Narayanganj",
                'slug'       => "narayanganj",
                'created_at' => $now
            ],
            [
                'name'       => "Narsingdi",
                'slug'       => "narsingdi",
                'created_at' => $now
            ],
            [
                'name'       => "Rajbari",
                'slug'       => "rajbari",
                'created_at' => $now
            ],
            [
                'name'       => "Shariatpur",
                'slug'       => "shariatpur",
                'created_at' => $now
            ],
            [
                'name'       => "Tangail",
                'slug'       => "tangail",
                'created_at' => $now
            ],
            [
                'name'       => "Bagerhat",
                'slug'       => "bagerhat",
                'created_at' => $now
            ],
            [
                'name'       => "Chuadanga",
                'slug'       => "chuadanga",
                'created_at' => $now
            ],
            [
                'name'       => "Jessore",
                'slug'       => "jessore",
                'created_at' => $now
            ],
            [
                'name'       => "Jhenaidah",
                'slug'       => "jhenaidah",
                'created_at' => $now
            ],
            [
                'name'       => "Khulna",
                'slug'       => "khulna",
                'created_at' => $now
            ],
            [
                'name'       => "Kushtia",
                'slug'       => "kushtia",
                'created_at' => $now
            ],
            [
                'name'       => "Magura",
                'slug'       => "magura",
                'created_at' => $now
            ],
            [
                'name'       => "Meherpur",
                'slug'       => "meherpur",
                'created_at' => $now
            ],
            [
                'name'       => "Narail",
                'slug'       => "narail",
                'created_at' => $now
            ],
            [
                'name'       => "Satkhira",
                'slug'       => "satkhira",
                'created_at' => $now
            ],
            [
                'name'       => "Jamalpur",
                'slug'       => "jamalpur",
                'created_at' => $now
            ],
            [
                'name'       => "Mymensingh",
                'slug'       => "mymensingh",
                'created_at' => $now
            ],
            [
                'name'       => "Netrokona",
                'slug'       => "netrokona",
                'created_at' => $now
            ],
            [
                'name'       => "Sherpur",
                'slug'       => "sherpur",
                'created_at' => $now
            ],
            [
                'name'       => "Bogra",
                'slug'       => "bogra",
                'created_at' => $now
            ],
            [
                'name'       => "Joypurhat",
                'slug'       => "joypurhat",
                'created_at' => $now
            ],
            [
                'name'       => "Naogaon",
                'slug'       => "naogaon",
                'created_at' => $now
            ],
            [
                'name'       => "Natore",
                'slug'       => "natore",
                'created_at' => $now
            ],
            [
                'name'       => "Chapai Nawabganj",
                'slug'       => "chapai-nawabganj",
                'created_at' => $now
            ],
            [
                'name'       => "Pabna",
                'slug'       => "pabna",
                'created_at' => $now
            ],
            [
                'name'       => "Rajshahi",
                'slug'       => "rajshahi",
                'created_at' => $now
            ],
            [
                'name'       => "Sirajganj",
                'slug'       => "sirajganj",
                'created_at' => $now
            ],
            [
                'name'       => "Dinajpur",
                'slug'       => "dinajpur",
                'created_at' => $now
            ],
            [
                'name'       => "Gaibandha",
                'slug'       => "gaibandha",
                'created_at' => $now
            ],
            [
                'name'       => "Kurigram",
                'slug'       => "kurigram",
                'created_at' => $now
            ],
            [
                'name'       => "Lalmonirhat",
                'slug'       => "lalmonirhat",
                'created_at' => $now
            ],
            [
                'name'       => "Nilphamari",
                'slug'       => "nilphamari",
                'created_at' => $now
            ],
            [
                'name'       => "Panchagarh",
                'slug'       => "panchagarh",
                'created_at' => $now
            ],
            [
                'name'       => "Rangpur",
                'slug'       => "rangpur",
                'created_at' => $now
            ],
            [
                'name'       => "Thakurgaon",
                'slug'       => "thakurgaon",
                'created_at' => $now
            ],
            [
                'name'       => "Habiganj",
                'slug'       => "habiganj",
                'created_at' => $now
            ],
            [
                'name'       => "Moulvibazar",
                'slug'       => "moulvibazar",
                'created_at' => $now
            ],
            [
                'name'       => "Sunamganj",
                'slug'       => "sunamganj",
                'created_at' => $now
            ],
            [
                'name'       => "Sylhet",
                'slug'       => "sylhet",
                'created_at' => $now
            ],
        ];

        DB::table('districts')->insert($districts);
    }
}
