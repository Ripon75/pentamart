<?php

namespace App\Models;

use Image;
use Carbon\Carbon;
use App\Classes\Model;
use App\Rules\NotNumeric;
use Laravel\Scout\Searchable;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\ProductThumbCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Auditable
{
    use SoftDeletes, Searchable, HasFactory, Userstamps;
    use \OwenIt\Auditing\Auditable;

    protected $table      = 'products';
    protected $_className = 'Product';

    // All view templates
    protected $_views = [
        'index'  => 'adminend.pages.product.index',
        'create' => 'adminend.pages.product.create',
        'edit'   => 'adminend.pages.product.edit',
        'show'   => 'adminend.pages.product.show',
        'bulk'   => 'adminend.pages.product.bulk'
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
        'brand_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'category_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'price' => [
            'cast'     => 'decimal:2',
            'fillable' => true
        ],
        'offer_price' => [
            'cast'     => 'decimal:2',
            'fillable' => true
        ],
        'offer_percent' => [
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
        'created_by' => [
            'fillable' => true
        ],
        'updated_by' => [
            'fillable' => true
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
        'brand:id,slug,name',
        'category:id,slug,name',
    ];

    public function searchableAs()
    {
        return 'pentamart_products_index';
    }

    public function toSearchableArray()
    {
        return [
            'id'            => (int) $this->id,
            'name'          => $this->name,
            'price'         => (float) $this->price,
            'offer_price'   => (float) $this->offer_price,
            'status'        => $this->status,
            'brand'         => $this->brand->name ?? null,
            'category'      => $this->category->name ?? null,
            'created_at'    => $this->created_at
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->status === 'active' ? true : false;
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with($this->_defaultWith);
    }

    // Relation start ======================================================================
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_item', 'item_id', 'section_id')->withTimestamps();
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id')->withTimestamps();
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id')->withTimestamps();
    }

    // Relation end ======================================================================

    public function getImageSrcAttribute($value)
    {
        if ($value) {
            if (Storage::disk('public')->exists($value)) {
                return Storage::url($value);
            } else {
                return '/images/sample/watch.jpeg';
            }
        } else {
            return '/images/sample/watch.jpeg';
        }

    }

    // get image source
    public function getImageSrcValueAttribute()
    {
        return $this->attributes['image_src'];
    }

    // Scope start ======================================================================
    public function scopeActive($query)
    {
        $query->where('status', 'active');
    }

    public function scopeGetDefaultMetaData($query)
    {
        $now = Carbon::now();

        return $query->select(
            'id', 'name', 'brand_id', 'category_id', 'price', 'offer_price',
            'discount', 'offer_percent', 'slug','image_src'
        )
        ->with([
            'brand:id,name,slug',
            'category:id,name,slug',
            'sizes',
            'colors'
        ])
        ->where('status', 'active')
        ->where('price', '>', 0);
    }


    public function scopeThumbs($query)
    {
        return $query->with($this->_defaultWith)
                     ->where('status', 'active');
    }

    // Scope end ======================================================================

    public function _index($request, $resource = false)
    {
        $paginate    = $request->input('paginate');
        $id          = $request->input('id', null);
        $name        = $request->input('name', null);
        $status      = $request->input('status', null);
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
        $oldPrice = null;
        $oldOfferPrice = null;
        $obj = null;
        $rules = [];
        if ($action === 'store') {
            $rules = [
                'name'           => ['required', "unique:{$this->table}", new NotNumeric],
                'brand_id'       => ['required'],
                'category_id'    => ['required'],
                'price'          => ['required'],
                'current_stock'  => ['required']
            ];
            $request->validate($rules);
            $obj = new Self();

        } else {
            $rules = [
                'name'           => ['required', new NotNumeric],
                'brand_id'       => ['required'],
                'category_id'    => ['required'],
                'price'          => ['required'],
                'current_stock'  => ['required']
            ];
            $request->validate($rules);

            $obj = Self::find($id);
            if (!$obj) {
                $msg = $this->_getMessage('not_found');
                return $this->_makeResponse(false, null, $msg);
            }

            // Get old mrp and selling price
            $oldPrice = $obj->price;
            $oldOfferPrice = $obj->offer_price;
        }

        // Get input value form request
        $name         = $request->input('name', null);
        $brandId      = $request->input('brand_id', null);
        $categoryId   = $request->input('category_id', null);
        $price        = $request->input('price', 0);
        $offerPrice   = $request->input('offer_price', 0);
        $currentStock = $request->input('current_stock', 0);
        $status       = $request->input('status', 'active');
        $description  = $request->input('description', null);

        $obj->name                 = $name;
        $obj->slug                 = $name;
        $obj->brand_id             = $brandId;
        $obj->category_id          = $categoryId;
        $obj->price                = $price;
        $obj->offer_price          = $offerPrice;
        $obj->status               = $status;
        $obj->current_stock        = $currentStock;
        $obj->description          = $description;
        $obj->created_by_id        = Auth::id();
        $res = $obj->save();

        if ($res) {
            $action = $action === 'store' ? $action : 'update';

            // Save product price log
            ProductPriceLog::_store($obj->id, $price, $offerPrice, $oldPrice, $oldOfferPrice);

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
