<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = database_path('data/products.json');
        $jsonData = file_get_contents($filePath);
        $allData  = json_decode($jsonData, true);

        $packSize  = [1,3,5,10,12,14];
        $packName  = ['Tablets', 'Bottles', 'Pieces'];
        $numOfPack = [2,5,10,20,50];

        $i = 0;
        foreach (array_chunk($allData, 1000) as $chunkData) {
            $products = [];
            $productPacks = [];
            foreach ($chunkData as $sdata) {
                $i++;
                $brandID      = null;
                $genericID    = null;
                $strength     = null;
                $dosageFormID = null;
                $metaKeywords = null;

                $metaKeywords = $sdata['display_name'];

                if (array_key_exists('id', $sdata['brand'])) {
                    $brandID = $sdata['brand']['id'];
                    $metaKeywords = "{$metaKeywords} {$sdata['brand']['display_name']}";
                }
                if (array_key_exists('id', $sdata['dosageForm'])) {
                    $dosageFormID = $sdata['dosageForm']['id'];
                    $metaKeywords = "{$metaKeywords} {$sdata['dosageForm']['display_name']}";
                }
                if (array_key_exists('id', $sdata['generic'])) {
                    $genericID = $sdata['generic']['id'];
                    $strength  = $sdata['generic']['strength'];
                    $metaKeywords = "{$metaKeywords} {$sdata['generic']['display_name']} {$strength}";
                }

                $tempProduct = [
                    'id'               => $i,
                    'slug'             => $sdata['name'],
                    'name'             => $sdata['display_name'],
                    'dosage_form_id'   => $dosageFormID,
                    'brand_id'         => $brandID,
                    'generic_id'       => $genericID,
                    'mrp'              => $sdata['price'],
                    'status'           => 'activated',
                    'meta_title'       => $sdata['display_name'],
                    'meta_keywords'    => $metaKeywords,
                    'meta_description' => $metaKeywords,
                    'pack_size'        => $packSize[rand(0, 5)],
                    'pack_name'        => $packName[rand(0, 2)],
                    'num_of_pack'      => $numOfPack[rand(0, 4)],
                    'created_at'       => Carbon::now()
                ];
                $products[] = $tempProduct;

                $tempProductPack = [
                    'product_id'    => $i,
                    'uom_id'        => 1,
                    'name'          => '1 Piece',
                    'slug'          => '1-piece',
                    'piece'         => 1,
                    'price'         => $sdata['price'],
                    'min_order_qty' => 1,
                    'max_order_qty' => 100
                ];
                $productPacks[] = $tempProductPack;
            }
            DB::table('products')->insert($products);
            DB::table('product_packs')->insert($productPacks);
        }
    }
}
