<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeederNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Artisan::call('scout:flush "App\\Models\\Product"');

        $csvFile   = fopen(base_path("database/data/NonmediciProduct.csv"), "r");
        $firstline = true;


        while (($data = fgetcsv($csvFile, 2500, ",")) !== false) {
            if (!$firstline) {
                $name = $data['1'];
                $slug = Str::slug($name, '-');

                $price = $data['3'];
                $price = (float)$price;

                $offerPrice = $data['7'];
                $offerPrice = (float)$offerPrice;

                if ($price > $offerPrice) {
                    $offerPrice = $offerPrice;
                } else {
                    $offerPrice = 0;
                }

                if ($name && $price) {
                    $productObj                 = new Product();
                    $productObj->name           = $name;
                    $productObj->slug           = $slug;
                    $productObj->brand_id       = rand(1, 3);
                    $productObj->category_id    = rand(1, 4);
                    $productObj->price          = $price;
                    $productObj->offer_price    = $offerPrice;
                    $productObj->status         = 'active';
                    $productObj->image_src      = null;
                    $productObj->save();
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
