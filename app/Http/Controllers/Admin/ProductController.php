<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Symptom;
use App\Models\Category;
use App\Models\DosageForm;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct() {
        $this->modelObj = new Product();
    }

    public function create(Request $request)
    {
        $view = $this->modelObj->_getView('create');

        $brands      = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories  = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $generics    = Generic::select('id', 'name')->orderBy('name', 'asc')->get();
        $dosageForms = DosageForm::select('id', 'name')->orderBy('name', 'asc')->get();
        $symptoms    = Symptom::select('id', 'name')->orderBy('name', 'asc')->get();
        $companies   = Company::select('id', 'name')->orderBy('name', 'asc')->get();

        return view($view, [
            'brands'      => $brands,
            'categories'  => $categories,
            'generics'    => $generics,
            'dosageForms' => $dosageForms,
            'symptoms'    => $symptoms,
            'companies'   => $companies
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result      = $this->modelObj->_show($id);

        if ($result['data']['tags']) {
            $tagNames = [];
            foreach ($result['data']['tags'] as $tag) {
                $tagNames [] = $tag->name;
            }
            $tagNames = implode("," ,$tagNames);
        }

        $brands      = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories  = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $generics    = Generic::select('id', 'name')->orderBy('name', 'asc')->get();
        $dosageForms = DosageForm::select('id', 'name')->orderBy('name', 'asc')->get();
        $symptoms    = Symptom::select('id', 'name')->orderBy('name', 'asc')->get();
        $companies   = Company::select('id', 'name')->orderBy('name', 'asc')->get();
        $view        = $this->modelObj->_getView('edit');

        return view($view, $result, [
            'brands'      => $brands,
            'categories'  => $categories,
            'generics'    => $generics,
            'dosageForms' => $dosageForms,
            'symptoms'    => $symptoms,
            'tagNames'    => $tagNames,
            'companies'   => $companies
        ]);
    }

    public function bulk(Request $request)
    {
        $view = $this->modelObj->_getView('bulk');
        return view($view);
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'uploaded_file' => ['required', 'file', 'mimes:csv']
        ]);

        $now = Carbon::now();

        $file = $request->file('uploaded_file');

        $filename  = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();  //Get extension of uploaded file
        $tempPath  = $file->getRealPath();
        $fileSize  = $file->getSize();                     //Get size of uploaded file in bytes
        //Check for file extension and size
        $this->checkUploadedFileProperties($extension, $fileSize);
        //Where uploaded file will be stored on the server
        $location = 'uploads'; //Created an "uploads" folder for that
        // Upload file
        $file->move($location, $filename);
        // In case the uploaded file path is to be stored in the database
        $filepath = public_path($location . "/" . $filename);
        // Reading file
        $file = fopen($filepath, "r");

        $firstline = true;

        while (($data = fgetcsv($file, 2500, ",")) !== false) {
            if (!$firstline) {
                // Get All data from csv
                $imageName         = trim($data['0']) ?? null;
                $mediposId         = trim($data['1']) ?? null;
                $brandName         = trim($data['2']) ?? null;
                $productName       = trim($data['3']);
                $companyId         = trim($data['4']) ?? null;
                $genericName       = trim($data['5']) ?? null;
                $mrp               = trim($data['6']) ?? 0;
                $dosageFormId      = trim($data['7']) ?? null;
                $counterType       = trim($data['8']) ?? 'none';
                $packSize          = trim($data['9']) ?? 1;
                $packName          = trim($data['10']) ?? null;
                $numberOfPack      = trim($data['11']) ?? 10;
                $uom               = trim($data['12']) ?? null;
                $isSingleSellAllow = trim($data['13']) ?? 0;
                $isRefrigerated    = trim($data['14']) ?? 0;
                $isExpressDelivery = trim($data['15']) ?? 0;
                $description       = trim($data['16']) ?? 0;
                // $tags           = trim($data['18']);
                // $categoryName   = trim($data['19']);
                // $symptoms       = trim($data['20']);

                // $tags     = explode(',', $tags);
                // $symptoms = explode(',', $symptoms);

                $mrp = (float)$mrp;

                try {
                    DB::beginTransaction();

                    $brandId = null;
                    if ($brandName) {
                        $brandSlug = Str::slug($brandName, '-');
                        $brand = Brand::where('slug', $brandSlug)->first();
                        if ($brand) {
                            $brandId = $brand->id;
                        } else {
                            $brandObj             = new Brand();
                            $brandObj->slug       = $brandSlug;
                            $brandObj->name       = $brandName;
                            $brandObj->company_id = $companyId;
                            $brandObj->status     = 'activated';
                            $brandObj->save();
                            $brandId = $brandObj->id;
                        }
                    }

                    $genericId = null;
                    if ($genericName) {
                        $genericSlug = Str::slug($genericName, '-');
                        $generic = Generic::where('slug', $genericSlug)->first();
                        if ($generic) {
                            $genericId = $generic->id;
                        } else {
                            $genericObj           = new Generic();
                            $genericObj->slug     = $genericSlug;
                            $genericObj->name     = $genericName;
                            // $genericObj->strength = $strength;
                            $genericObj->save();
                            $genericId = $genericObj->id;
                        }
                    }

                    // $productRes = false;
                    if ($productName && $mrp) {
                        $productSlug = Str::slug($productName, '-');
                        $product = Product::where('slug', $productSlug)->first();
                        // if product found then update product
                        if ($product) {
                            $product->name                 = $productName;
                            $product->slug                 = $productSlug;
                            $product->dosage_form_id       = $dosageFormId;
                            $product->brand_id             = $brandId;
                            $product->company_id           = $companyId;
                            $product->generic_id           = $genericId;
                            $product->pos_product_id       = $mediposId;
                            $product->mrp                  = $mrp;
                            $product->selling_price        = 0;
                            $product->selling_percent      = 0;
                            $product->status               = 'activated';
                            $product->description          = $description;
                            $product->counter_type         = $counterType;
                            $product->pack_size            = $packSize;
                            $product->pack_name            = $packName;
                            $product->num_of_pack          = $numberOfPack;
                            $product->uom                  = $uom;
                            $product->is_single_sell_allow = $isSingleSellAllow;
                            $product->is_refrigerated      = $isRefrigerated;
                            $product->is_express_delivery  = $isExpressDelivery;
                            $product->created_by_id        = Auth::id();
                            $product->save();

                            $product->image_src = "images/products/{$now->year}/{$now->month}/{$imageName}.jpg";
                            $productRes = $product->save();
                            info('Update ' . $imageName);
                            info('Update ' . $product->id);
                        } else {
                            $productObj                       = new Product();
                            $productObj->name                 = $productName;
                            $productObj->slug                 = $productSlug;
                            $productObj->dosage_form_id       = $dosageFormId;
                            $productObj->brand_id             = $brandId;
                            $productObj->company_id           = $companyId;
                            $productObj->generic_id           = $genericId;
                            $productObj->pos_product_id       = $mediposId;
                            $productObj->mrp                  = $mrp;
                            $productObj->selling_price        = 0;
                            $productObj->selling_percent      = 0;
                            $productObj->status               = 'activated';
                            $productObj->description          = $description;
                            $productObj->counter_type         = $counterType;
                            $productObj->pack_size            = $packSize;
                            $productObj->pack_name            = $packName;
                            $productObj->num_of_pack          = $numberOfPack;
                            $productObj->uom                  = $uom;
                            $productObj->is_single_sell_allow = $isSingleSellAllow;
                            $productObj->is_refrigerated      = $isRefrigerated;
                            $productObj->is_express_delivery  = $isExpressDelivery;
                            $productObj->created_by_id        = Auth::id();
                            $productObj->save();

                            $productObj->image_src      = "images/products/{$now->year}/{$now->month}/{$imageName}.jpg";
                            $productRes = $productObj->save();
                            info('Create ' . $imageName);
                            info('Create ' . $productObj->id);
                        }
                    }
                    // if ($productRes) {
                    //     // Find or create tags and attach with product
                    //     foreach ($tags as $tagName) {
                    //         if ($tagName) {
                    //             $ttag = Tag::where('name', $tagName)->first();
                    //             if (!$ttag) {
                    //                 $ttag       = new Tag();
                    //                 $ttag->slug = Str::slug($tagName, '-');
                    //                 $ttag->name = $tagName;
                    //                 $ttag->save();
                    //             }

                    //             $productObj->tags()->sync([$ttag->id]);
                    //         }
                    //     }
                    //     // Find or create tags and attach with product
                    //     foreach ($symptoms as $symptomName) {
                    //         if ($symptomName) {
                    //             $symptomObj = Symptom::where('name', $symptomName)->first();
                    //             if (!$symptomObj) {
                    //                 $symptomObj       = new Symptom();
                    //                 $symptomObj->slug = Str::slug($symptomName, '-');
                    //                 $symptomObj->name = $symptomName;
                    //                 $symptomObj->save();
                    //             }

                    //             $productObj->symptoms()->sync([$symptomObj->id]);
                    //         }
                    //     }
                    //     // Attach category with product
                    //     if ($categoryID) {
                    //         $productObj->categories()->attach($categoryID);
                    //     }
                    // }
                    DB::commit();
                } catch (\Exception $e) {
                    info($e);
                    DB::rollback();
                    return back()->with('error', 'Something went to wrong');
                }
            }
            $firstline = false;
        }
        fclose($file);

        return back()->with('message', 'File upload succesfully done');
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = ['csv']; //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $res = $product->delete();
            if ($res) {
                return back()->with('message', 'Product deleted successfully');
            }
        }
        return back()->with('error', 'Product not found');
    }
}
