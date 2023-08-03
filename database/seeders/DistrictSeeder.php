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
                'name'            => 'Dhaka',
                'slug'            => 'dhaka',
                'status'          => 'active',
                'delivery_charge' => 60,
                'created_at'      => $now
            ],
            [
                'name'            => 'Barguna',
                'slug'            => 'barguna',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Barisal',
                'slug'            => 'barisal',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Bhola',
                'slug'            => 'bhola',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Jhalokati',
                'slug'            => 'jhalokati',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Patuakhali',
                'slug'            => 'patuakhali',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Pirojpur',
                'slug'            => 'pirojpur',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Bandarban',
                'slug'            => 'bandarban',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Brahmanbaria',
                'slug'            => 'brahmanbaria',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Chandpur',
                'slug'            => 'chandpur',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Chittagong',
                'slug'            => 'chittagong',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => 'Comilla',
                'slug'            => 'comilla',
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Cox's Bazar",
                'slug'            => "cox's-bazar",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Feni",
                'slug'            => "feni",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Khagrachhari",
                'slug'            => "khagrachhari",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Lakshmipur",
                'slug'            => "lakshmipur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Noakhali",
                'slug'            => "noakhali",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Rangamati",
                'slug'            => "rangamati",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Faridpur",
                'slug'            => "faridpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Gazipur",
                'slug'            => "gazipur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Gopalganj",
                'slug'            => "gopalganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Kishoreganj",
                'slug'            => "kishoreganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Madaripur",
                'slug'            => "madaripur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Manikganj",
                'slug'            => "manikganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Munshiganj",
                'slug'            => "munshiganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Narayanganj",
                'slug'            => "narayanganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Narsingdi",
                'slug'            => "narsingdi",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Rajbari",
                'slug'            => "rajbari",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Shariatpur",
                'slug'            => "shariatpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Tangail",
                'slug'            => "tangail",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Bagerhat",
                'slug'            => "bagerhat",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Chuadanga",
                'slug'            => "chuadanga",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Jessore",
                'slug'            => "jessore",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Jhenaidah",
                'slug'            => "jhenaidah",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Khulna",
                'slug'            => "khulna",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Kushtia",
                'slug'            => "kushtia",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Magura",
                'slug'            => "magura",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Meherpur",
                'slug'            => "meherpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Narail",
                'slug'            => "narail",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Satkhira",
                'slug'            => "satkhira",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Jamalpur",
                'slug'            => "jamalpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Mymensingh",
                'slug'            => "mymensingh",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Netrokona",
                'slug'            => "netrokona",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Sherpur",
                'slug'            => "sherpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Bogra",
                'slug'            => "bogra",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Joypurhat",
                'slug'            => "joypurhat",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Naogaon",
                'slug'            => "naogaon",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Natore",
                'slug'            => "natore",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Chapai Nawabganj",
                'slug'            => "chapai-nawabganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Pabna",
                'slug'            => "pabna",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Rajshahi",
                'slug'            => "rajshahi",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Sirajganj",
                'slug'            => "sirajganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Dinajpur",
                'slug'            => "dinajpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Gaibandha",
                'slug'            => "gaibandha",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Kurigram",
                'slug'            => "kurigram",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Lalmonirhat",
                'slug'            => "lalmonirhat",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Nilphamari",
                'slug'            => "nilphamari",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Panchagarh",
                'slug'            => "panchagarh",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Rangpur",
                'slug'            => "rangpur",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Thakurgaon",
                'slug'            => "thakurgaon",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Habiganj",
                'slug'            => "habiganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Moulvibazar",
                'slug'            => "moulvibazar",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Sunamganj",
                'slug'            => "sunamganj",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
            [
                'name'            => "Sylhet",
                'slug'            => "sylhet",
                'status'          => 'active',
                'delivery_charge' => 100,
                'created_at'      => $now
            ],
        ];

        DB::table('districts')->insert($districts);
    }
}
