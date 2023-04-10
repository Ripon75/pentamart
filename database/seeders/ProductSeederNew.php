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
        // Product::truncate();

        // Artisan::call('scout:flush "App\\Models\\Product"');
        $numOfPack = [2,5,10,20,50];

        $csvFile   = fopen(base_path("database/data/medicalDevices.csv"), "r");
        $firstline = true;


        while (($data = fgetcsv($csvFile, 2500, ",")) !== false) {
            if (!$firstline) {
                $posProductID = $data['0'];
                $name = $data['1'];
                $slug = Str::slug($name, '-');

                $packSize = $data['2'];
                $packSize = $packSize ? $packSize : 1;
                $packSize = (int)$packSize;

                $packName = $data['5'];
                if ($packName == 'NULL' || $packName == 'null' || $packName == '') {
                    $packName = 'Pieces';
                }

                $price = $data['3'];
                $price = (float)$price;

                $salePrice = $data['7'];
                $salePrice = (float)$salePrice;

                $dosageFormID = null;
                $dosageFormName = $data['4'];
                if ($dosageFormName) {
                    $dosageForm = DosageForm::where('name', $dosageFormName)->first();
                    if ($dosageForm) {
                        $dosageFormID = $dosageForm->id;
                    } else {
                        $slug = Str::slug($dosageFormName, '-');
                        $dosageFormObj = new DosageForm();
                        $dosageFormObj->slug = $slug;
                        $dosageFormObj->name = $dosageFormName;
                        $dosageFormObj->status = 'activated';
                        $dosageFormObj->save();
                        $dosageFormID = $dosageFormObj->id;
                    }
                }

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

                $genericID = null;
                $strength  = $data['5'];
                $genericName = $data['11'];
                if ($genericName) {
                    $generic = Generic::where('name', $genericName)->first();
                    if ($generic) {
                        $genericID = $generic->id;
                    } else {
                        $slug = Str::slug($genericName, '-');
                        $genericObj = new Generic();
                        $genericObj->slug = $slug;
                        $genericObj->name = $genericName;
                        $genericObj->strength = $strength;
                        $genericObj->save();
                        $genericID = $genericObj->id;
                    }
                }

                if ($name && $price) {
                    $productObj                 = new Product();
                    $productObj->name           = $name;
                    $productObj->slug           = $slug;
                    $productObj->dosage_form_id = $dosageFormID;
                    $productObj->brand_id       = $brandID;
                    $productObj->generic_id     = $genericID;
                    $productObj->pos_product_id = $posProductID;
                    $productObj->mrp            = $price;
                    $productObj->selling_price  = $salePrice;
                    $productObj->status         = 'activated';
                    $productObj->pack_size      = $packSize;
                    $productObj->pack_name      = $packName;
                    $productObj->num_of_pack    = $numOfPack[rand(0, 4)];
                    $productObj->image_src      = "images/products/2022/8/22/{$posProductID}.jpg";
                    $productObj->save();
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
