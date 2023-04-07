<?php

namespace App\Http\Controllers\Seller;

use DB;
use Auth;
use Image;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Symptom;
use App\Models\Category;
use App\Rules\NotNumeric;
use App\Models\DosageForm;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductPriceLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct() {
        $this->modelObj = new Product();
    }

    public function index(Request $request)
    {
        $paginate    = config('crud.paginate.default');
        $id          = $request->input('id', null);
        $name        = $request->input('name', null);
        $status      = $request->input('status', null);
        $counterType = $request->input('counter_type', null);
        $startDate   = $request->input('start_date', null);
        $endDate     = $request->input('end_date', null);
        $userId      = Auth::id();
        
        $paginate = $this->modelObj->_checkPaginate($paginate);
        // $obj      = $this->modelObj->with($this->modelObj->_defaultWith);
        
        $obj = new Product();
        $obj = $obj->with([
            'brand:id,slug,company_id,name',
            'brand.company:id,slug,name',
            'generic:id,slug,name',
            'categories:id,name,slug',
            'dosageForm:id,slug,name',
            'tags'
        ]);

        $obj = $obj->where('created_by_id', $userId);

        // Filter product name
        if($id) {
            $obj = $obj->where('id', $id);
        }

        // Filter product name
        if($name) {
            $obj = $obj->where('name', 'like', "%{$name}%");
        }

        // Filter status
        if($status) {
            $obj = $obj->where('status', $status);
        }

        // Filter status
        if($counterType) {
            $obj = $obj->where('counter_type', $counterType);
        }

        // Date range wise filter
        if ($startDate && $endDate) {
            $startDate = $startDate.' 00:00:00';
            $endDate   = $endDate.' 23:59:59';
            $obj       = $obj->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $obj->orderBy('created_at', 'desc')->paginate($paginate);

        return view('sellercenter.pages.product.index', [
            'result' => $data
        ]);
    }

    public function create(Request $request)
    {
        $brands      = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories  = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $generics    = Generic::select('id', 'name')->orderBy('name', 'asc')->get();
        $dosageForms = DosageForm::select('id', 'name')->orderBy('name', 'asc')->get();
        $symptoms    = Symptom::select('id', 'name')->orderBy('name', 'asc')->get();
        $companies   = Company::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('sellercenter.pages.product.create', [
            'brands'      => $brands,
            'categories'  => $categories,
            'generics'    => $generics,
            'dosageForms' => $dosageForms,
            'symptoms'    => $symptoms,
            'companies'   => $companies
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => ['required', "unique:products", new NotNumeric],
            'dosage_form_id' => ['required'],
            'company_id'     => ['required'],
            'generic_id'     => ['required'],
            'mrp'            => ['required'],
            'pack_size'      => ['required'],
            'num_of_pack'    => ['required'],
            'pack_name'      => ['required'],
            'uom'            => ['required']
        ]);

        // Get input value form request
        $name              = $request->input('name', null);
        $mrp               = $request->input('mrp', 0);
        $sellingPrice      = $request->input('selling_price', 0);
        $sellingPercent    = $request->input('selling_percent', 0);
        $status            = $request->input('status', 'draft');
        $brandId           = $request->input('brand_id', null);
        $genericId         = $request->input('generic_id', null);
        $categoryIds       = $request->input('category_ids', null);
        $symptomIds        = $request->input('symptom_ids', null);
        $dosageFormId      = $request->input('dosage_form_id', null);
        $companyId         = $request->input('company_id', null);
        $description       = $request->input('description', null);
        $metaTitle         = $request->input('meta_title', null);
        $metaKeyword       = $request->input('meta_keywords', null);
        $metaDescription   = $request->input('meta_description', null);
        $tagNames          = $request->input('tag_names', null);
        $packSize          = $request->input('pack_size', null);
        $packName          = $request->input('pack_name', null);
        $numOfPack         = $request->input('num_of_pack', null);
        $counterType       = $request->input('counter_type', null);
        $posProductId      = $request->input('pos_product_id', null);
        $uom               = $request->input('uom', null);
        $singleSellAllow   = $request->input('is_single_sell_allow', 0);
        $isRefrigerated    = $request->input('is_refrigerated', 0);
        $isExpressDelivery = $request->input('is_express_delivery', 0);

        $mrp = $mrp ? $mrp : 0;
        $sellingPrice = $sellingPrice ? $sellingPrice : 0;

        $obj = new Product();

        $obj->name                 = $name;
        $obj->slug                 = $name;
        $obj->mrp                  = $mrp;
        $obj->selling_price        = $sellingPrice;
        $obj->selling_percent      = $sellingPercent;
        $obj->status               = $status;
        $obj->brand_id             = $brandId;
        $obj->generic_id           = $genericId;
        $obj->dosage_form_id       = $dosageFormId;
        $obj->company_id           = $companyId;
        $obj->description          = $description;
        $obj->meta_title           = $metaTitle;
        $obj->meta_keywords        = $metaKeyword;
        $obj->meta_description     = $metaDescription;
        $obj->pack_size            = $packSize;
        $obj->pack_name            = $packName;
        $obj->num_of_pack          = $numOfPack;
        $obj->counter_type         = $counterType;
        $obj->pos_product_id       = $posProductId;
        $obj->uom                  = $uom;
        $obj->is_single_sell_allow = $singleSellAllow;
        $obj->is_refrigerated      = $isRefrigerated;
        $obj->is_express_delivery  = $isExpressDelivery;
        $obj->created_by_id        = Auth::id();
        $res = $obj->save();

        if ($res) {
            $obj->categories()->sync($categoryIds);
            $obj->symptoms()->sync($symptomIds);

            // Save product price log
            ProductPriceLog::_store($obj->id, $mrp, $sellingPrice, 0, 0);

            if($request->hasFile('image')) {
                $file       = $request->file('image');
                $uploadPath = $obj->_getImageUploadPath();
                $path       = Storage::put($uploadPath, $file);
                $storepath  = Storage::path($path);
                $watermarkImgPath = public_path('images/logos/watermark.png');

                // open an image file
                $img = Image::make($storepath);

                // now you are able to resize the instance
                $img->resize(1024, 1024);

                // and insert a watermark for example
                $img->insert($watermarkImgPath, 'center');
                Storage::disk('public')->delete($storepath);

                // finally we save the image as a new file
                $img->save($storepath);

                $obj->image_src = $path;
                $obj->save();
            }

            if ($tagNames) {
                $tagObj = new Tag();
                $tagObj->attachTags($tagNames, $obj);
            }

            return back()->with('message', 'Product created successfully');
        }
    }

    public function edit(Request $request, $id)
    {
        $result = $this->modelObj->_show($id);

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

        return view('sellercenter.pages.product.edit', [
            'data'        => $result['data'],
            'brands'      => $brands,
            'categories'  => $categories,
            'generics'    => $generics,
            'dosageForms' => $dosageForms,
            'symptoms'    => $symptoms,
            'tagNames'    => $tagNames,
            'companies'   => $companies
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => ['required', "unique:products,name,$id", new NotNumeric],
            'dosage_form_id' => ['required'],
            'company_id'     => ['required'],
            'generic_id'     => ['required'],
            'mrp'            => ['required'],
            'pack_size'      => ['required'],
            'num_of_pack'    => ['required'],
            'pack_name'      => ['required']
        ]);

        $obj = Product::find($id);
        if (!$obj) {
            return false;
        }

        // Get old mrp and selling price
        $oldMRP = 0;
        $oldSellingPrice = 0;
        $oldMRP = $obj->mrp;
        $oldSellingPrice = $obj->selling_price;

        // Get input value form request
        $name              = $request->input('name', null);
        $mrp               = $request->input('mrp', 0);
        $sellingPrice      = $request->input('selling_price', 0);
        $sellingPercent    = $request->input('selling_percent', 0);
        $status            = $request->input('status', 'draft');
        $brandId           = $request->input('brand_id', null);
        $genericId         = $request->input('generic_id', null);
        $categoryIds       = $request->input('category_ids', null);
        $symptomIds        = $request->input('symptom_ids', null);
        $dosageFormId      = $request->input('dosage_form_id', null);
        $companyId         = $request->input('company_id', null);
        $description       = $request->input('description', null);
        $metaTitle         = $request->input('meta_title', null);
        $metaKeyword       = $request->input('meta_keywords', null);
        $metaDescription   = $request->input('meta_description', null);
        $tagNames          = $request->input('tag_names', null);
        $packSize          = $request->input('pack_size', null);
        $packName          = $request->input('pack_name', null);
        $numOfPack         = $request->input('num_of_pack', null);
        $counterType       = $request->input('counter_type', null);
        $posProductId      = $request->input('pos_product_id', null);
        $uom               = $request->input('uom', null);
        $singleSellAllow   = $request->input('is_single_sell_allow', 0);
        $isRefrigerated    = $request->input('is_refrigerated', 0);
        $isExpressDelivery = $request->input('is_express_delivery', 0);

        $mrp = $mrp ? $mrp : 0;
        $sellingPrice = $sellingPrice ? $sellingPrice : 0;

        // Assigned request input value into object
        $obj->name                 = $name;
        $obj->slug                 = $name;
        $obj->mrp                  = $mrp;
        $obj->selling_price        = $sellingPrice;
        $obj->selling_percent      = $sellingPercent;
        $obj->status               = $status;
        $obj->brand_id             = $brandId;
        $obj->generic_id           = $genericId;
        $obj->dosage_form_id       = $dosageFormId;
        $obj->company_id           = $companyId;
        $obj->description          = $description;
        $obj->meta_title           = $metaTitle;
        $obj->meta_keywords        = $metaKeyword;
        $obj->meta_description     = $metaDescription;
        $obj->pack_size            = $packSize;
        $obj->pack_name            = $packName;
        $obj->num_of_pack          = $numOfPack;
        $obj->counter_type         = $counterType;
        $obj->pos_product_id       = $posProductId;
        $obj->uom                  = $uom;
        $obj->is_single_sell_allow = $singleSellAllow;
        $obj->is_refrigerated      = $isRefrigerated;
        $obj->is_express_delivery  = $isExpressDelivery;
        $obj->created_by_id        = Auth::id();
        $res = $obj->save();

        if ($res) {
            $obj->categories()->sync($categoryIds);
            $obj->symptoms()->sync($symptomIds);

            // Save product price log
            ProductPriceLog::_store($obj->id, $mrp, $sellingPrice, $oldMRP, $oldSellingPrice);

            if($request->hasFile('image')) {
                $oldImagePath = $obj->image_src_value;
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $file       = $request->file('image');
                $uploadPath = $obj->_getImageUploadPath();
                $path       = Storage::put($uploadPath, $file);
                $storepath  = Storage::path($path);
                $watermarkImgPath = public_path('images/logos/watermark.png');

                // open an image file
                $img = Image::make($storepath);

                // now you are able to resize the instance
                $img->resize(1024, 1024);

                // and insert a watermark for example
                $img->insert($watermarkImgPath, 'center');
                Storage::disk('public')->delete($storepath);

                // finally we save the image as a new file
                $img->save($storepath);

                $obj->image_src = $path;
                $obj->save();
            }

            if ($tagNames) {
                $tagObj = new Tag();
                $tagObj->attachTags($tagNames, $obj);
            }

            return back()->with('message', 'Product updated successfully');
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
                $posProductID   = trim($data['0']);
                $name           = trim($data['1']); // product name
                $packSize       = trim($data['2']);
                $mrp            = trim($data['3']);
                $dosageFormName = trim($data['4']);
                $strength       = trim($data['5']);
                $uom            = trim($data['6']);
                $packName       = trim($data['7']);
                $purchasePrice  = trim($data['8']);
                $salePrice      = trim($data['9']);
                $dealerPrice    = trim($data['10']);
                $brandName      = trim($data['11']);
                $genericName    = trim($data['12']);
                $companyName    = trim($data['13']);
                $numOfPack      = trim($data['14']);
                $tags           = trim($data['15']);
                $categoryName   = trim($data['16']);
                $symptoms       = trim($data['17']);

                $tags     = explode(',', $tags);
                $symptoms = explode(',', $symptoms);

                $packSize = $packSize ? $packSize : 1;
                $packSize = (int)$packSize;

                if ($packName == 'NULL' || $packName == 'null' || $packName == '') {
                    $packName = 'Pieces';
                }

                $mrp       = (float)$mrp;
                $salePrice = (float)$salePrice;

                try {
                    DB::beginTransaction();

                    $dosageFormID = null;
                    if ($dosageFormName) {
                        $dosageFormSlug = Str::slug($dosageFormName, '-');
                        $dosageForm = DosageForm::where('slug', $dosageFormSlug)->first();
                        if ($dosageForm) {
                            $dosageFormID = $dosageForm->id;
                        } else {
                            $dosageFormObj         = new DosageForm();
                            $dosageFormObj->slug   = $dosageFormSlug;
                            $dosageFormObj->name   = $dosageFormName;
                            $dosageFormObj->status = 'activated';
                            $dosageFormObj->save();
                            $dosageFormID = $dosageFormObj->id;
                        }
                    }

                    $companyID = null;
                    if ($companyName) {
                        $companySlug = Str::slug($companyName, '-');
                        $company = Company::where('slug', $companySlug)->first();
                        if ($company) {
                            $companyID = $company->id;
                        } else {
                            $companyObj       = new Company();
                            $companyObj->slug = $companySlug;
                            $companyObj->name = $companyName;
                            $companyObj->save();
                            $companyID = $companyObj->id;
                        }
                    }

                    $brandID = null;
                    if ($brandName) {
                        $brandSlug = Str::slug($brandName, '-');
                        $brand = Brand::where('slug', $brandSlug)->first();
                        if ($brand) {
                            $brandID = $brand->id;
                        } else {
                            $brandObj             = new Brand();
                            $brandObj->slug       = $brandSlug;
                            $brandObj->name       = $brandName;
                            $brandObj->company_id = $companyID;
                            $brandObj->status     = 'activated';
                            $brandObj->save();
                            $brandID = $brandObj->id;
                        }
                    }

                    $genericID = null;
                    if ($genericName) {
                        $genericSlug = Str::slug($genericName, '-');
                        $generic = Generic::where('slug', $genericSlug)->first();
                        if ($generic) {
                            $genericID = $generic->id;
                        } else {
                            $genericObj           = new Generic();
                            $genericObj->slug     = $genericSlug;
                            $genericObj->name     = $genericName;
                            $genericObj->strength = $strength;
                            $genericObj->save();
                            $genericID = $genericObj->id;
                        }
                    }

                    $categoryID = null;
                    if ($categoryName) {
                        $categorySlug = Str::slug($categoryName, '-');
                        $category = Category::where('slug', $categorySlug)->first();
                        if ($category) {
                            $categoryID = $category->id;
                        } else {
                            $categoryObj         = new Category();
                            $categoryObj->slug   = $categorySlug;
                            $categoryObj->name   = $categoryName;
                            $categoryObj->status = 'activated';
                            $categoryObj->save();
                            $categoryID = $categoryObj->id;
                        }
                    }

                    $numOfPack = $numOfPack ? $numOfPack : 1;

                    $productRes = false;
                    if ($name && $mrp) {
                        $productSlug = Str::slug($name, '-');
                        $product = Product::where('slug', $productSlug)->first();
                        // if product found then update product
                        if ($product) {
                            // Calculate offer/selling price
                            // $salePrice = ($product->mrp * 10) / 100;
                            // $salePrice = number_format($salePrice, 2);
                            // $salePrice = $product->mrp - $salePrice;

                            $product->name            = $name;
                            $product->slug            = $productSlug;
                            $product->dosage_form_id  = $dosageFormID;
                            $product->brand_id        = $brandID;
                            $product->company_id      = $companyID;
                            $product->generic_id      = $genericID;
                            $product->pos_product_id  = $posProductID;
                            $product->mrp             = $mrp;
                            $product->selling_price   = 0;
                            $product->selling_percent = 0;
                            $product->status          = 'activated';
                            $product->pack_size       = $packSize;
                            $product->uom             = $uom;
                            $product->pack_name       = $packName;
                            $product->num_of_pack     = 10;
                            $product->save();

                            $product->image_src = "images/products/{$now->year}/{$posProductID}.jpg";
                            $productRes = $product->save();
                            info('Update ' . $product->id);
                        } else {
                            // Calculate offer/selling price
                            // $salePrice = ($mrp * 10) / 100;
                            // $salePrice = number_format($salePrice, 2);
                            // $salePrice = $mrp - $salePrice;

                            $productObj                  = new Product();
                            $productObj->name            = $name;
                            $productObj->slug            = $productSlug;
                            $productObj->dosage_form_id  = $dosageFormID;
                            $productObj->brand_id        = $brandID;
                            $productObj->company_id      = $companyID;
                            $productObj->generic_id      = $genericID;
                            $productObj->pos_product_id  = $posProductID;
                            $productObj->mrp             = $mrp;
                            $productObj->selling_price   = 0;
                            $productObj->selling_percent = 0;
                            $productObj->status          = 'activated';
                            $productObj->pack_size       = $packSize;
                            $productObj->uom             = $uom;
                            $productObj->pack_name       = $packName;
                            $productObj->num_of_pack     = 10;
                            $productObj->save();

                            $productObj->image_src      = "images/products/{$now->year}/{$posProductID}.jpg";
                            $productRes = $productObj->save();
                            info('Create ' . $productObj->id);
                        }
                    }
                    if ($productRes) {
                        // Find or create tags and attach with product
                        foreach ($tags as $tagName) {
                            if ($tagName) {
                                $ttag = Tag::where('name', $tagName)->first();
                                if (!$ttag) {
                                    $ttag       = new Tag();
                                    $ttag->slug = Str::slug($tagName, '-');
                                    $ttag->name = $tagName;
                                    $ttag->save();
                                }

                                $productObj->tags()->sync([$ttag->id]);
                            }
                        }
                        // Find or create tags and attach with product
                        foreach ($symptoms as $symptomName) {
                            if ($symptomName) {
                                $symptomObj = Symptom::where('name', $symptomName)->first();
                                if (!$symptomObj) {
                                    $symptomObj       = new Symptom();
                                    $symptomObj->slug = Str::slug($symptomName, '-');
                                    $symptomObj->name = $symptomName;
                                    $symptomObj->save();
                                }

                                $productObj->symptoms()->sync([$symptomObj->id]);
                            }
                        }
                        // Attach category with product
                        if ($categoryID) {
                            $productObj->categories()->attach($categoryID);
                        }
                    }
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

        return redirect()->route('admin.products.bulk')->with('message', 'File upload succesfully done');
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
