<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            ImageConveter::class,
            LaratrustSeeder::class,
            AreaSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeederNew::class,
            PaymentGatewaySeeder::class,
            StatusSeeder::class,
            SectionSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            // ProductSizeSeeder::class,
            // ProductColorSeeder::class,
        ]);
    }
}
