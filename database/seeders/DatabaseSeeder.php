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
            CountrySeeder::class,
            AreaTypeSeeder::class,
            AreaSeeder::class,
            CompanySeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            DosageFormSeeder::class,
            GenericSeeder::class,
            // ProductSeeder::class,
            ProductSeederNew::class,
            PaymentGatewaySeeder::class,
            DeliveryGatewaySeeder::class,
            OrderStatusSeeder::class,
            SettingSeeder::class,
            SectionSeeder::class,
        ]);
    }
}
