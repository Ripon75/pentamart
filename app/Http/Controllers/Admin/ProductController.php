<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Size;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
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
            $products  = $products->whereBetween('created_at', [$startDate, $endDate]);
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
        $colors     = Color::select('id', 'name')->orderBy('name', 'asc')->whereNotIn('id', [1])->get();
        $sizes      = Size::select('id', 'name')->orderBy('name', 'asc')->whereNotIn('id', [1])->get();

        return view('adminend.pages.product.create', [
            'brands'     => $brands,
            'categories' => $categories,
            'colors'     => $colors,
            'sizes'      => $sizes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['required', "unique:products,name"],
            'brand_id'      => ['required', 'integer'],
            'category_id'   => ['required', 'integer'],
            // 'color_ids'     => ['nullable', 'array'],
            // 'size_ids'      => ['nullable', 'array'],
            'current_stock' => ['required', 'integer'],
            'buy_price'     => ['required'],
            'mrp'           => ['required']
        ]);

        $name         = $request->input('name', null);
        $brandId      = $request->input('brand_id', null);
        $categoryId   = $request->input('category_id', null);
        $colorIds     = $request->input('color_ids', []);
        $sizeIds      = $request->input('size_ids', []);
        $BuyPrice     = $request->input('buy_price', 0);
        $mrp          = $request->input('mrp', 0);
        $offerPrice   = $request->input('offer_price', 0);
        $offerPercent = $request->input('offer_percent', 0);
        $currentStock = $request->input('current_stock', 0);
        $status       = $request->input('status', 'active');
        $description  = $request->input('description', null);
        $slug         = Str::slug($name, '-');

        // calculate discount
        $discount = 0;
        if ($offerPrice > 0) {
            $discount = $mrp - $offerPrice;
        }

        try {
            DB::beginTransaction();

            $product = new Product();

            $product->name          = $name;
            $product->slug          = $slug;
            $product->brand_id      = $brandId;
            $product->category_id   = $categoryId;
            $product->buy_price     = $BuyPrice;
            $product->mrp           = $mrp;
            $product->offer_price   = $offerPrice ?? 0;
            $product->discount      = $discount;
            $product->offer_percent = $offerPercent ?? 0;
            $product->status        = $status;
            $product->current_stock = $currentStock ?? 0;
            $product->description   = $description;
            $product->created_by    = Auth::id();
            $res = $product->save();
            if ($res) {
                // sync colors and sizes
                $product->colors()->sync($colorIds);
                $product->sizes()->sync($sizeIds);

                // upload file
                if ($request->hasFile('img_src')) {
                    $imgSRC     = $request->file('img_src');
                    $uploadPath = $product->getImageUploadPath();
                    $imgPath    = Storage::put($uploadPath, $imgSRC);
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

                    $product->img_src = $imgPath;
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
        $colors     = Color::select('id', 'name')->orderBy('name', 'asc')->whereNotIn('id', [1])->get();
        $sizes      = Size::select('id', 'name')->orderBy('name', 'asc')->whereNotIn('id', [1])->get();

        // Selected colors and sizes id
        $selectedColorIDs = Arr::pluck($product->colors->toArray(), 'id');
        $selectedSizeIDs   = Arr::pluck($product->sizes->toArray(), 'id');

        return view('adminend.pages.product.edit',[
            'product'          => $product,
            'brands'           => $brands,
            'categories'       => $categories,
            'colors'           => $colors,
            'sizes'            => $sizes,
            'selectedColorIDs' => $selectedColorIDs,
            'selectedSizeIDs'  => $selectedSizeIDs
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => ['required', "unique:products,name,$id"],
            'brand_id'      => ['required', 'integer'],
            'category_id'   => ['required', 'integer'],
            'color_ids'     => ['nullable', 'array'],
            'size_ids'      => ['nullable', 'array'],
            'current_stock' => ['required', 'integer'],
            'buy_price'     => ['required'],
            'mrp'           => ['required']
        ]);

        $name         = $request->input('name', null);
        $brandId      = $request->input('brand_id', null);
        $categoryId   = $request->input('category_id', null);
        $colorIds     = $request->input('color_ids', []);
        $sizeIds      = $request->input('size_ids', []);
        $buyPrice     = $request->input('buy_price', 0);
        $mrp          = $request->input('mrp', 0);
        $offerPrice   = $request->input('offer_price', 0);
        $offerPercent = $request->input('offer_percent', 0);
        $currentStock = $request->input('current_stock', 0);
        $status       = $request->input('status', 'active');
        $description  = $request->input('description', null);
        $slug         = Str::slug($name, '-');

        // calculate discount
        $discount = 0;
        if ($offerPrice > 0) {
            $discount = $mrp - $offerPrice;
        }

        try {
            DB::beginTransaction();
            $product = Product::find($id);
            if (!$product) {
                abort(404);
            }

            $product->name          = $name;
            $product->slug          = $slug;
            $product->brand_id      = $brandId;
            $product->category_id   = $categoryId;
            $product->buy_price     = $buyPrice;
            $product->mrp           = $mrp;
            $product->offer_price   = $offerPrice ?? 0;
            $product->discount      = $discount;
            $product->offer_percent = $offerPercent ?? 0;
            $product->status        = $status;
            $product->current_stock = $currentStock ?? 0;
            $product->description   = $description;
            $product->created_by    = Auth::id();
            $res = $product->save();

            if ($res) {
                // sync colors and sizes
                $product->colors()->sync($colorIds);
                $product->sizes()->sync($sizeIds);

                // upload file
                if ($request->hasFile('img_src')) {
                    $oldImgPath = $product->getOldPath($product->img_src);
                    if ($oldImgPath) {
                        Storage::disk('public')->delete($oldImgPath);
                    }

                    $imgSRC     = $request->file('img_src');
                    $uploadPath = $product->getImageUploadPath();
                    $imgPath    = Storage::put($uploadPath, $imgSRC);
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

                    $product->img_src = $imgPath;
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

    public function bulk()
    {
        return view('adminend.pages.product.bulk');
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

                $imageName    = trim($data['0']);
                $brandName    = trim($data['1']);
                $categoryName = trim($data['2']);
                $productName  = trim($data['3']);
                $price        = trim($data['4']);
                $offerPrice   = trim($data['5']);
                $description  = trim($data['6']);

                try {
                    DB::beginTransaction();

                    $brandId = null;
                    if ($brandName) {
                        $brandSlug = Str::slug($brandName, '-');
                        $brand = Brand::where('slug', $brandSlug)->first();
                        if ($brand) {
                            $brandId = $brand->id;
                        } else {
                            $brand         = new Brand();
                            $brand->slug   = $brandSlug;
                            $brand->name   = $brandName;
                            $brand->status = 'active';
                            $brand->save();
                            $brandId = $brand->id;
                        }
                    }

                    $categoryId = null;
                    if ($categoryName) {
                        $cagtegorySlug = Str::slug($categoryName, '-');
                        $category = Category::where('slug', $cagtegorySlug)->first();
                        if ($category) {
                            $categoryId = $category->id;
                        } else {
                            $category         = new Category();
                            $category->slug   = $cagtegorySlug;
                            $category->name   = $categoryName;
                            $category->status = 'active';
                            $category->save();
                            $categoryId = $category->id;
                        }
                    }

                    // Calculate offer percent
                    $offerPercent = 0;

                    // $productRes = false;
                    if ($productName && $price) {
                        $productSlug = Str::slug($productName, '-');
                        $product = Product::where('slug', $productSlug)->first();
                        // if product found then update product
                        if ($product) {
                            $product->name          = $productName;
                            $product->slug          = $productSlug;
                            $product->brand_id      = $brandId;
                            $product->price         = $price;
                            $product->offer_price   = $offerPrice;
                            $product->offer_percent = $offerPercent;
                            $product->status        = 'active';
                            $product->description   = $description;
                            $product->created_by    = Auth::id();
                            $product->save();

                            $product->image_src = "images/products/{$imageName}.jpg";
                            $product->save();
                            info('Update ' . $imageName);
                        } else {
                            $productObj                = new Product();
                            $productObj->name          = $productName;
                            $productObj->slug          = $productSlug;
                            $productObj->brand_id      = $brandId;
                            $productObj->category_id   = $categoryId;
                            $productObj->price         = $price;
                            $productObj->offer_price   = 0;
                            $productObj->offer_percent = 0;
                            $productObj->status        = 'active';
                            $productObj->description   = $description;
                            $productObj->created_by    = Auth::id();
                            $productObj->save();

                            $productObj->image_src = "images/products/{$imageName}.jpg";
                            $productObj->save();
                            info('Create ' . $imageName);
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

        return back()->with('message', 'File upload succesfully done');
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = ['csv']; //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                return $this->sendError('File size is very large');
            }
        } else {
            return $this->sendError('Invalid file format');
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
