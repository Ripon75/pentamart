<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('123456789');
        $now = Carbon::now();
        User::insert([
            [
                'id'         => 1,
                'name'       => 'Leemon Chandra',
                'email'      => 'leemon@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 2,
                'name'       => 'Atik Hasan',
                'email'      => 'atikhasan@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 3,
                'name'       => 'Salman Khan',
                'email'      => 'salman@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 4,
                'name'       => 'Ripon Ahmed',
                'email'      => 'ripon@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 5,
                'name'       => 'Sajjad Hossin',
                'email'      => 'sajjad@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 6,
                'name'       => 'Rasel Khan',
                'email'      => 'rasel@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 7,
                'name'       => 'Shahriar',
                'email'      => 'shahriar@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 8,
                'name'       => 'Pranto',
                'email'      => 'pranto@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 9,
                'name'       => 'Rafsan',
                'email'      => 'rafsan@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 10,
                'name'       => 'Anik Hasan',
                'email'      => 'anik@test.com',
                'password'   => $password,
                'created_at' => $now
            ],
            [
                'id'         => 11,
                'name'       => 'Razib Chandra',
                'email'      => 'razib@test.com',
                'password'   => $password,
                'created_at' => $now
            ]
        ]);
    }
}
