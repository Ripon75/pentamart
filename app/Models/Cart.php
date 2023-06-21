<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Classes\Utility;
use Illuminate\Support\Facades\DB;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'user_id',
        'pg_id',
        'address_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'pg_id'      => 'integer',
        'address_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    // Relation start
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->belongsToMany(Product::class, 'cart_item', 'cart_id', 'item_id')
            ->withPivot('size_id', 'color_id', 'quantity', 'item_buy_price','item_mrp', 'item_sell_price', 'item_discount')
            ->withTimestamps();
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
    // Relation end

    public function addItem($request)
    {
        $request->validate([
            'item_id'  => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'color_id' => ['nullable', 'integer'],
            'size_id'  => ['nullable', 'integer']
        ]);

        $itemId   = $request->input('item_id');
        $quantity = $request->input('quantity');
        $colorId  = $request->input('color_id');
        $sizeId   = $request->input('size_id');
        $isUpdate = $request->input('is_update');

        if ($quantity <= 0) {
            return $this->removeItem($request);
        }

        $product = Product::find($itemId);

        if(!$product) {
            return $this->s(false, null, 'Product not found');
        }

        $itemBuyPrice  = $product->buy_price;
        $itemMRP       = $product->mrp;
        $offerPrice    = $product->offer_price;
        $itemDiscount  = $product->discount;
        $itemSellPrice = $offerPrice > 0 ? $offerPrice : $itemMRP;

        $cart = $this->getCurrentCustomerCart();
        if (!$isUpdate) {
            if (count($cart->items)) {
                foreach ($cart->items as $item) {
                    if ($item->id == $itemId && $item->pivot->size_id == $sizeId && $item->pivot->color_id == $colorId) {
                        return Utility::sendError('Product already added to cart');
                    }
                }
            }

            $res = $cart->items()->attach($itemId, [
                'size_id'         => $sizeId,
                'color_id'        => $colorId,
                'quantity'        => $quantity,
                'item_buy_price'  => $itemBuyPrice,
                'item_mrp'        => $itemMRP,
                'item_sell_price' => $itemSellPrice,
                'item_discount'   => $itemDiscount
            ]);
        } else {
            // $res = $cart->items()->updateExistingPivot($itemId, ['quantity' => $quantity]);

            $res = $cart->items()
                ->wherePivot('item_id', $itemId)
                ->wherePivot('color_id', $colorId)
                ->wherePivot('size_id', $sizeId)
                ->update(['quantity' => $quantity]);
        }
        return Utility::sendResponse($res, 'Item added successfully');
    }

    public function removeItem($request)
    {
        $request->validate([
            'item_id' => ['required', 'integer'],
        ]);

        $itemId  = $request->input('item_id');
        $colorId = $request->input('color_id');
        $sizeId  = $request->input('size_id');

        $res = DB::table('cart_item')->where('item_id', $itemId)->where('size_id', $sizeId)
        ->where('color_id', $colorId)->delete();

        // $cart = $this->getCurrentCustomerCart();
        // $res  = $cart->items()->detach($itemId);

        return Utility::sendResponse($res, 'Item removed successfuly');
    }

    public function emptyCart()
    {
        $cart = $this->getCurrentCustomerCart();
        $res = $cart->items()->detach();

        $cart->pg_id = 1;
        $cart->save();

        return Utility::sendResponse($res, 'Cart empty successfuly');
    }

    public function addMetaData($request)
    {
        $pgId = $request->input('pg_id', null);

        $cart = $this->getCurrentCustomerCart();

        if ($pgId) {
            $cart->pg_id = $pgId;
        }
        $res = $cart->save();

        return $res;
    }

    public function getCurrentCustomerCart()
    {
        if (Auth::check()) {
            $authUser = Auth::user();
            $cart     = $authUser->cart;
            if ($cart) {
                return $cart;
            } else {
                return $this->createCustomerCart($authUser->id);
            }
        } else {
            return false;
        }
    }

    // Create current customer cart
    public function createCustomerCart($userId)
    {
        $cart = new Self;
        $cart->user_id = $userId;
        $cart->save();

        return $cart;
    }

    public function getTotalSellPrice()
    {
        $totalSellPrice = $this->items->sum(function ($item) {
            $itemSellPrice = $item->pivot->item_sell_price;
            $quantity      = $item->pivot->quantity;

            return $itemSellPrice * $quantity;
        });

        return $totalSellPrice;
    }
}
