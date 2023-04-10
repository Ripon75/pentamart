<?php

namespace App\Models;

use Image;
use Carbon\Carbon;
use App\Classes\Model;
use App\Rules\NotNumeric;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\ProductThumbCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes, Searchable, HasFactory;
    // use \OwenIt\Auditing\Auditable;  implements Auditable

    protected $table      = 'products';
    protected $_className = 'Product';

    // All view templates
    protected $_views = [
        'index'  => 'adminend.pages.product.index',
        'create' => 'adminend.pages.product.create',
        'edit'   => 'adminend.pages.product.edit',
        'show'   => 'adminend.pages.product.show',
        'bulk'   => 'adminend.pages.product.bulk',
        // 'show'   => 'frontend.pages.product-single'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.products.index',
        'create' => 'admin.products.create',
        'edit'   => 'admin.products.edit',
        'show'   => 'admin.products.show'
    ];

    protected $_columns = [
        'id' => [
            'cast'   => 'integer',
            'filter' => [
                'type'     => 'default',
                'opration' => '='
            ]
        ],
        'slug' => [
            'cast'     => 'string',
            'fillable' => true,
            'filter'   => [
                'type'     => 'default',
                'opration' => 'like_left'
            ]
        ],
        'name' => [
            'cast'       => 'string',
            'fillable'   => true
        ],
        'dosage_form_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'brand_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'generic_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'company_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'mrp' => [
            'cast'     => 'decimal:2',
            'fillable' => true
        ],
        'selling_price' => [
            'cast'     => 'decimal:2',
            'fillable' => true
        ],
        'selling_percent' => [
            'cast'     => 'decimal:2',
            'fillable' => true
        ],
        'status' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'description' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'meta_title' => [
            'cast'       => 'string',
            'fillable'   => true
        ],
        'meta_keywords' => [
            'cast'       => 'string',
            'fillable'   => true
        ],
        'meta_description' => [
            'cast'       => 'string',
            'fillable'   => true
        ],
        'is_single_sell_allow' => [
            'cast'       => 'boolean',
            'fillable'   => true
        ],
        'uom' => [
            'cast'       => 'string',
            'fillable'   => true
        ],
        'created_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'updated_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'deleted_at' => [
            'cast' => 'datetime:Y-m-d H:i:s'
        ]
    ];

    protected $_defaultWith = [
        'brand:id,slug,company_id,name',
        'brand.company:id,slug,name',
        'generic:id,slug,name',
        'categories:id,name,slug',
        'dosageForm:id,slug,name',
        'tags'
    ];

    public function searchableAs()
    {
        return 'medicart_products_index';
    }

    public function toSearchableArray()
    {
        return [
            'id'            => (int) $this->id,
            'name'          => $this->name,
            'mrp'           => (float) $this->mrp,
            'selling_price' => (float) $this->selling_price,
            'status'        => $this->status,
            'meta_keywords' => $this->meta_keywords,
            'counter_type'  => $this->counter_type,
            'created_at'    => $this->created_at,
            'generic'       => $this->generic->name ?? null
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->status === 'activated' ? true : false;
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with($this->_defaultWith);
    }

    // Relation start ======================================================================
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function generic()
    {
        return $this->belongsTo(Generic::class);
    }

    public function dosageForm()
    {
        return $this->belongsTo(DosageForm::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id')->withTimestamps();
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'product_symptom')->withTimestamps();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function offersQty()
    {
        return $this->belongsToMany(Offer::class, 'offer_product', 'product_id', 'offer_id')
                    ->withPivot('quantity', 'discount_percent', 'discount_amount')->withTimestamps();
    }


    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_item', 'item_id', 'section_id')->withTimestamps();
    }

    // Relation end ======================================================================

    public function getImageSrcAttribute($value)
    {
        // return $value ? $value : '/images/sample/ace.jpg';
        if ($value) {
            if (Storage::disk('public')->exists($value)) {
                return Storage::url($value);
            } else {
                // TODO: get this file url from a config
                // return '/images/sample/product-placeholder2.png';
                return '/images/sample/watch.jpeg';
            }
        } else {
            // TODO: get this file url from a config
            //  return '/images/sample/product-placeholder2.png';
            return '/images/sample/watch.jpeg';
        }

    }

     // get image source
    public function getImageSrcValueAttribute()
    {
        return $this->attributes['image_src'];
    }

    public function getBoxSizeAttribute($value)
    {
        return '10 Pc';
    }

    // Scope start ======================================================================
    public function scopeActive($query)
    {
        $query->where('status', 'activated');
    }

    public function scopeGetDefaultMetaData($query)
    {
        $now = Carbon::now();

        return $query->select(
            'id', 'name', 'generic_id', 'brand_id', 'dosage_form_id', 'mrp', 'selling_price', 'slug',
            DB::raw("
                CASE
                    WHEN selling_price > 0 THEN (selling_price*pack_size)
                    ELSE (mrp*pack_size)
                    END as 'unit_price'
            "),
            'image_src', 'pack_size', 'pack_name', 'num_of_pack', 'counter_type', 'company_id', 'is_single_sell_allow', 'uom'
        )
        ->with([
            'generic:id,name,slug',
            'brand:id,company_id,name,slug',
            'brand.company:id,name,slug',
            'dosageForm:id,name,slug',
            'categories:id,name,slug',
            'company:id,name,slug'
        ])
        ->where('status', 'activated')
        ->where('mrp', '>', 0);
    }


    public function scopeThumbs($query)
    {
        return $query->with($this->_defaultWith)
                     ->where('status', 'activated');
    }

    // Scope end ======================================================================

    public function _index($request, $resource = false)
    {
        $paginate    = $request->input('paginate');
        $id          = $request->input('id', null);
        $name        = $request->input('name', null);
        $status      = $request->input('status', null);
        $counterType = $request->input('counter_type', null);
        $startDate   = $request->input('start_date', null);
        $endDate     = $request->input('end_date', null);

        $paginate = $this->_checkPaginate($paginate);
        $obj      = $this->with($this->_defaultWith);

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

        $msg = $this->_getMessage('index');
        return $this->_makeResponse(true, $data, $msg);
    }

    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {
        $oldMRP = null;
        $oldSellingPrice = null;
        $obj = null;
        $rules = [];
        if ($action === 'store') {
            $rules = [
                'name'           => ['required', "unique:{$this->table}", new NotNumeric],
                'dosage_form_id' => ['required'],
                'company_id'     => ['required'],
                'generic_id'     => ['required'],
                'mrp'            => ['required'],
                'pack_size'      => ['required'],
                'num_of_pack'    => ['required'],
                'pack_name'      => ['required'],
                'uom'            => ['required']
            ];
            $request->validate($rules);
            $obj = new Self();

        } else {
            $rules = [
                'name'           => ['required', new NotNumeric],
                'dosage_form_id' => ['required'],
                'company_id'     => ['required'],
                'generic_id'     => ['required'],
                'mrp'            => ['required'],
                'pack_size'      => ['required'],
                'num_of_pack'    => ['required'],
                'pack_name'      => ['required']
            ];
            // $request->validate($rules);

            $obj = Self::find($id);
            if (!$obj) { // If the product not found
                $msg = $this->_getMessage('not_found');
                return $this->_makeResponse(false, null, $msg);
            }

            // Get old mrp and selling price
            $oldMRP = $obj->mrp;
            $oldSellingPrice = $obj->selling_price;
        }

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
            $action = $action === 'store' ? $action : 'update';

            $obj->categories()->sync($categoryIds);
            $obj->symptoms()->sync($symptomIds);

            // Save product price log
            ProductPriceLog::_store($obj->id, $mrp, $sellingPrice, $oldMRP, $oldSellingPrice);

            if($request->hasFile('image')) {
                $oldImagePath = $action === 'store' ? '' : $obj->attributes['image_src'];
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $file       = $request->file('image');
                $uploadPath = $this->_getImageUploadPath();
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

            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        } else {
            $action = $action === 'store' ? 'failed_store' : 'failed_update';
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        }
    }

    public function _getThumbs($take = 24)
    {
        $take = $take > 100 ? 100 : $take;
        $products = Self::thumbs()->take($take)->get();

        $res = new ProductThumbCollection($products);

        return $res;
    }
}
