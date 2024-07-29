<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now      = Carbon::now();
        $password = Hash::make('123456789');

        User::insert([
            [
                'id'           => 1,
                'name'         => 'Supperadmin',
                "phone_number" => "01764997485",
                'email'        => 'supperadmin@gmail.com.com',
                'password'     => $password,
                'is_active'    => true,
                'created_at'   => $now,
            ]
        ]);
    }
}
