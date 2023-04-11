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

        $i = 0;
        foreach (array_chunk($allData, 1000) as $chunkData) {
            $products = [];
            foreach ($chunkData as $sdata) {
                $i++;
                $brandID      = null;
                $strength     = null;
                $metaKeywords = null;

                $metaKeywords = $sdata['display_name'];

                if (array_key_exists('id', $sdata['brand'])) {
                    $brandID = $sdata['brand']['id'];
                    $metaKeywords = "{$metaKeywords} {$sdata['brand']['display_name']}";
                }
                if (array_key_exists('id', $sdata['dosageForm'])) {
                    $metaKeywords = "{$metaKeywords} {$sdata['dosageForm']['display_name']}";
                }
                if (array_key_exists('id', $sdata['generic'])) {
                    $strength  = $sdata['generic']['strength'];
                    $metaKeywords = "{$metaKeywords} {$sdata['generic']['display_name']} {$strength}";
                }

                $tempProduct = [
                    'id'               => $i,
                    'slug'             => $sdata['name'],
                    'name'             => $sdata['display_name'],
                    'brand_id'         => $brandID,
                    'price'            => $sdata['price'],
                    'status'           => 'active',
                    'created_at'       => Carbon::now()
                ];
                $products[] = $tempProduct;
            }
            DB::table('products')->insert($products);
        }
    }
}
