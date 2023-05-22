<?php

namespace App\Models;

// use Image;
use Intervention\Image\Facades\Image;
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

    public $_defaultWith = [
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

    public function getImageUploadPath()
    {
        return 'images/products';
    }

    public function getOldPath($path)
    {
        return str_replace('http://localhost:3000/storage/', '/', $path);
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
            'id', 'name', 'brand_id', 'category_id', 'current_stock', 'price', 'offer_price',
            'discount', 'offer_percent', 'slug','image_src', 'description'
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

    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {

    }

    public function _getThumbs($take = 24)
    {
        $take = $take > 100 ? 100 : $take;
        $products = Self::thumbs()->take($take)->get();

        $res = new ProductThumbCollection($products);

        return $res;
    }
}
