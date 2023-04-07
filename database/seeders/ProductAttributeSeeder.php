<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Family;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $csvFile   = fopen(base_path("database/data/product-attributes.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($csvFile, 5000, ",")) !== false) {
            if (!$firstline) {
                $attributeName  = $data['0'];
                $inputType      = $data['1'];
                $required       = $data['2'];
                $visibleOnFront = $data['3'];
                $comparable     = $data['4'];
                $options        = $data['5'];
                $groupName      = $data['6'];
                $familyName     = $data['7'];
                $categoryName   = $data['8'];

                if (!$attributeName || !$familyName || !$categoryName) {
                    return false;
                }

                $inputType      = $inputType ? Str::slug($inputType, '-') : 'text';
                $required       = Str::slug($required, '-');
                $required       = $required === 'yes' ? true : false;
                $visibleOnFront = Str::slug($visibleOnFront, '-');
                $visibleOnFront = $visibleOnFront === 'yes' ? true : false;
                $comparable     = Str::slug($comparable, '-');
                $comparable     = $comparable === 'yes' ? true : false;
                $options        = explode(",", $options);

                // Check is $familyName is exist or not
                // If not exist create new
                $prodAttrFamilyObj = Family::where('name', $familyName)->first();
                if (!$prodAttrFamilyObj) {
                    $prodAttrFamilyObj               = new Family();
                    $prodAttrFamilyObj->slug         = Str::slug($familyName, '-');
                    $prodAttrFamilyObj->name         = $categoryName;
                    $prodAttrFamilyObj->user_defined = false;
                    $prodAttrFamilyObj->save();
                }

                // Check is $categoryName is exist or not
                // If not exist create new
                $categoryObj = Category::where('name', $categoryName)->first();
                if (!$categoryObj) {
                    $categoryObj            = new Category();
                    $categoryObj->slug      = Str::slug($categoryName, '-');
                    $categoryObj->name      = $categoryName;
                    $categoryObj->family_id = $prodAttrFamilyObj->id;
                    $categoryObj->status    = 'activated';
                    $categoryObj->save();
                }

                // Check is $attributeName is exist or not
                // If not exist create new
                $prodAttrObj = Attribute::where('name', $attributeName)->first();
                if (!$prodAttrObj) {
                    $prodAttrObj                   = new Attribute();
                    $prodAttrObj->slug             = Str::slug($attributeName, '-');
                    $prodAttrObj->name             = $attributeName;
                    $prodAttrObj->input_type       = $inputType;
                    $prodAttrObj->required         = $required;
                    $prodAttrObj->visible_on_front = $visibleOnFront;
                    $prodAttrObj->comparable       = $comparable;
                    $prodAttrObj->user_defined     = false;
                    $prodAttrObj->save();

                    $prodAttrFamilyObj->attributes()->attach($prodAttrObj->id);
                }

                // Loop the $options
                // Check is each $options is exist or not
                // If not exist create new
                if (count($options)) {
                    foreach ($options as $opt) {
                        if ($opt) {
                            $productAttributeOptObj = AttributeOption::where('label', $opt)
                                ->where('attribute_id', $prodAttrObj->id)->first();

                            if (!$productAttributeOptObj) {
                                $productAttributeOptObj               = new AttributeOption();
                                $productAttributeOptObj->attribute_id = $prodAttrObj->id;
                                $productAttributeOptObj->value        = Str::slug($opt, '-');
                                $productAttributeOptObj->label        = $opt;
                                $productAttributeOptObj->save();
                            }

                        }
                    }
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
