<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

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

        $csvFile   = fopen(base_path("database/data/products.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2500, ",")) !== false) {
            if (!$firstline) {
                $name = $data['0'];
                $slug = Str::slug($name, '-');

                $mrp = $data['1'];
                $mrp = (float)$mrp;

                $offerPrice = $data['2'];
                $offerPrice = (float)$offerPrice;

                $offerPercent = $data['3'];
                $offerPercent = (float)$offerPercent;

                $currentStock = $data['4'];
                $currentStock = (float)$currentStock;

                if ($name && $mrp) {
                    $productObj                = new Product();
                    $productObj->name          = $name;
                    $productObj->slug          = $slug;
                    $productObj->brand_id      = rand(1, 3);
                    $productObj->category_id   = rand(1, 4);
                    $productObj->buy_price     = $mrp - 50;
                    $productObj->mrp           = $mrp;
                    $productObj->offer_price   = $offerPrice;
                    $productObj->offer_percent = $offerPercent;
                    $productObj->current_stock = $currentStock;
                    $productObj->status        = 'active';
                    $productObj->img_src       = null;
                    $productObj->save();
                }
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
