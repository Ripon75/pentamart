<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Auditable
{
    use HasFactory, Searchable, Userstamps, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'category_id',
        'price',
        'offer_price',
        'discount',
        'offer_percent',
        'current_stock',
        'status',
        'image_src',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name'          => 'string',
        'slug'          => 'string',
        'brand_id'      => 'integer',
        'category_id'   => 'integer',
        'price'         => 'decimal:2',
        'offer_price'   => 'decimal:2',
        'discount'      => 'decimal:2',
        'offer_percent' => 'decimal:2',
        'current_stock' => 'integer',
        'status'        => 'string',
        'image_src'     => 'string',
        'description'   => 'string',
        'created_by'    => 'integer',
        'updated_by'    => 'integer',
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H:i:s',
        'deleted_at'    => 'datetime:Y-m-d H:i:s'
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
}
