<?php

namespace App\Models;

use App\Classes\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPack extends Model
{
    use HasFactory;

    protected $table      = 'product_packs';
    protected $_className = 'Product Pack';

     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.productPack.index',
        'create' => 'adminend.pages.productPack.create',
        'edit'   => 'adminend.pages.productPack.edit',
        'show'   => 'adminend.pages.productPack.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.product-packs.index',
        'create' => 'admin.product-packs.create',
        'edit'   => 'admin.product-packs.edit',
        'show'   => 'admin.product-packs.show'
    ];

    protected $fillable = [
        'product_id',
        'uom_id',
        'name',
        'slug',
        'piece',
        'price',
        'min_order_qty',
        'max_order_qty',
        'description'
    ];

    protected $casts = [
        'id'            => 'integer',
        'product_id'    => 'integer',
        'uom_id'        => 'integer',
        'name'          => 'string',
        'slug'          => 'string',
        'piece'         => 'string',
        'price'         => 'decimal:2',
        'min_order_qty' => 'integer',
        'max_order_qty' => 'integer',
        'description'   => 'string',
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H:i:s',
        'deleted_at'    => 'datetime:Y-m-d H:i:s'
    ];

    // Relation start
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function uom()
    {
        return $this->belongsTo(UOM::class);
    }
    // Relation end

    public function getPriceAttribute($value) {
        return round($value, 1);
    }

    // Store or update
    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {
        // TODO: Creating Form Requests
        $obj   = null;
        $rules = [];

        $rules = [
            'product_id' => ['required'],
            'uom_id'     => ['required'],
            'piece'      => ['required'],
            'price'      => ['required']
        ];

        // $request->validate($rules);

        if ($action === 'store') {
            $obj = new Self();

        } else {
            $obj = Self::find($id);

            if (!$obj) { // If the product not found
                $msg = $this->_getMessage('not_found');
                return $this->_makeResponse(false, null, $msg);
            }
        }

        $productId   = $request->input('product_id', null);
        $uomId       = $request->input('uom_id', null);
        $name        = $request->input('name', null);
        $piece       = $request->input('piece', null);
        $price       = $request->input('price', 0);
        $minOrderQty = $request->input('min_order_qty', 1);
        $maxOrderQty = $request->input('max_order_qty', 100);
        $description = $request->input('description', null);

        $minOrderQty = $minOrderQty ? $minOrderQty : 1;
        $maxOrderQty = $maxOrderQty ? $maxOrderQty : 100;

        $obj->product_id    = $productId;
        $obj->uom_id        = $uomId;
        $obj->name          = $name;
        $obj->slug          = $name;
        $obj->piece         = $piece;
        $obj->price         = $price;
        $obj->min_order_qty = $minOrderQty;
        $obj->max_order_qty = $maxOrderQty;
        $obj->description   = $description;
        $res                = $obj->save();

        if ($res) {
            $action = $action === 'store' ? $action : 'update';
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        } else {
            $action = $action === 'store' ? 'failed_store' : 'failed_update';
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        }
    }
}
