<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DosageForm;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Brand;
use Carbon\Carbon;

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

        $csvFile   = fopen(base_path("database/data/medicalDevices.csv"), "r");
        $firstline = true;


        while (($data = fgetcsv($csvFile, 2500, ",")) !== false) {
            if (!$firstline) {
                $name = $data['1'];
                $slug = Str::slug($name, '-');

                $price = $data['3'];
                $price = (float)$price;

                $offerPrice = $data['7'];
                $offerPrice = (float)$offerPrice;

                $brandID = null;
                $brandName = $data['10'];
                if ($brandName) {
                    $brand = Brand::where('name', $brandName)->first();
                    if ($brand) {
                        $brandID = $brand->id;
                    } else {
                        $slug = Str::slug($brandName, '-');
                        $brandObj = new Brand();
                        $brandObj->slug = $slug;
                        $brandObj->name = $brandName;
                        $brandObj->status = 'activated';
                        $brandObj->save();
                        $brandID = $brandObj->id;
                    }
                }

                if ($name && $price) {
                    $productObj                 = new Product();
                    $productObj->name           = $name;
                    $productObj->slug           = $slug;
                    $productObj->brand_id       = $brandID;
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
