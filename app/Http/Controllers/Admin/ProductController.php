<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Symptom;
use App\Models\Category;
use App\Models\DosageForm;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $id              = $request->input('id', null);
        $name            = $request->input('name', null);
        $status          = $request->input('status', null);
        $startDate       = $request->input('start_date', null);
        $endDate         = $request->input('end_date', null);
        $defaultPaginate = config('crud.paginate.default');

        $products = new Product();
        $products = $products->with($products->_defaultWith);

        // Filter product name
        if ($id) {
            $products = $products->where('id', $id);
        }

        // Filter product name
        if ($name) {
            $products = $products->where('name', 'like', "%{$name}%");
        }

        // Filter status
        if ($status) {
            $products = $products->where('status', $status);
        }

        // Date range wise filter
        if ($startDate && $endDate) {
            $startDate = $startDate . ' 00:00:00';
            $endDate   = $endDate . ' 23:59:59';
            $products       = $products->whereBetween('created_at', [$startDate, $endDate]);
        }

        $products = $products->orderBy('created_at', 'desc')->paginate($defaultPaginate);

        return view('adminend.pages.product.index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $brands     = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('adminend.pages.product.create', [
            'brands'      => $brands,
            'categories'  => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', "unique:products,name"],
            'brand_id'    => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'price'       => ['required']
        ]);

        $name         = $request->input('name', null);
        $brandId      = $request->input('brand_id', null);
        $categoryId   = $request->input('category_id', null);
        $price        = $request->input('price', 0);
        $offerPrice   = $request->input('offer_price', 0);
        $offerPercent = $request->input('offer_percent', 0);
        $currentStock = $request->input('current_stock', 0);
        $status       = $request->input('status', 'active');
        $description  = $request->input('description', null);

        try {
            DB::beginTransaction();

            $product = new Product();

            $product->name          = $name;
            $product->slug          = $name;
            $product->brand_id      = $brandId;
            $product->category_id   = $categoryId;
            $product->price         = $price;
            $product->offer_price   = $offerPrice ?? 0;
            $product->offer_percent = $offerPercent ?? 0;
            $product->status        = $status;
            $product->current_stock = $currentStock ?? 0;
            $product->description   = $description;
            $product->created_by    = Auth::id();
            $res = $product->save();
            if ($res) {
                if ($request->hasFile('image_src')) {
                    $imageSRC   = $request->file('image_src');
                    $uploadPath = $product->getImageUploadPath();
                    $imagePath  = Storage::put($uploadPath, $imageSRC);
                    // $storePath  = Storage::path($imagePath);
                    // $watermarkImgPath = public_path('images/logos/watermark.png');

                    // open an image file
                    // $img = Image::make($storePath);

                    // now you are able to resize the instance
                    // $img->resize(1024, 1024);

                    // and insert a watermark for example
                    // $img->insert($watermarkImgPath, 'center');
                    // Storage::disk('public')->delete($storePath);

                    // finally we save the image as a new file
                    // $img->save($storePath);

                    $product->image_src = $imagePath;
                    $product->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something is wrong');
        }
    }

    public function edit($id)
    {
       $product = Product::find($id);

       if (!$product) {
            abort(404);
       }

        $brands     = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('adminend.pages.product.edit',[
            'product'    => $product,
            'brands'     => $brands,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => ['required', "unique:products,name,$id"],
            'brand_id'    => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'price'       => ['required']
        ]);

        $name         = $request->input('name', null);
        $brandId      = $request->input('brand_id', null);
        $categoryId   = $request->input('category_id', null);
        $price        = $request->input('price', 0);
        $offerPrice   = $request->input('offer_price', 0);
        $offerPercent = $request->input('offer_percent', 0);
        $currentStock = $request->input('current_stock', 0);
        $status       = $request->input('status', 'active');
        $description  = $request->input('description', null);

        try {
            DB::beginTransaction();
            $product = Product::find($id);
            if (!$product) {
                abort(404);
            }

            $product->name          = $name;
            $product->slug          = $name;
            $product->brand_id      = $brandId;
            $product->category_id   = $categoryId;
            $product->price         = $price;
            $product->offer_price   = $offerPrice ?? 0;
            $product->offer_percent = $offerPercent ?? 0;
            $product->status        = $status;
            $product->current_stock = $currentStock ?? 0;
            $product->description   = $description;
            $product->created_by    = Auth::id();
            $res = $product->save();

            if ($res) {
                if ($request->hasFile('image_src')) {
                    $oldImagePath = $product->getOldPath($product->image_src);
                    if ($oldImagePath) {
                        Storage::disk('public')->delete($oldImagePath);
                    }

                    $imageSRC   = $request->file('image_src');
                    $uploadPath = $product->getImageUploadPath();
                    $imagePath  = Storage::put($uploadPath, $imageSRC);
                    // $storePath  = Storage::path($imagePath);
                    // $watermarkImgPath = public_path('images/logos/watermark.png');

                    // open an image file
                    // $img = Image::make($storePath);

                    // now you are able to resize the instance
                    // $img->resize(1024, 1024);

                    // and insert a watermark for example
                    // $img->insert($watermarkImgPath, 'center');
                    // Storage::disk('public')->delete($storePath);

                    // finally we save the image as a new file
                    // $img->save($storePath);

                    $product->image_src = $imagePath;
                    $product->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went to wrong');
        }
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
