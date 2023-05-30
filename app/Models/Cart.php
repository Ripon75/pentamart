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
        'note',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'pg_id'      => 'integer',
        'address_id' => 'integer',
        'note'       => 'string',
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
            ->withPivot('size_id', 'color_id', 'quantity', 'item_price', 'sell_price', 'item_discount')
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

        $itemPrice  = $product->price;
        $offerPrice = $product->offer_price;
        $discount   = $product->discount;
        $sellPrice  = $offerPrice > 0 ? $offerPrice : $itemPrice;

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
                'size_id'       => $sizeId,
                'color_id'      => $colorId,
                'quantity'      => $quantity,
                'item_price'    => $itemPrice,
                'sell_price'    => $sellPrice,
                'item_discount' => $discount
            ]);
        } else {
            $res = $cart->items()->updateExistingPivot($itemId, ['quantity' => $quantity]);
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
        $cart->note  = null;
        $cart->save();

        return Utility::sendResponse($res, 'Cart empty successfuly');
    }

    public function addMetaData($request)
    {
        $pgId = $request->input('pg_id', null);
        $note = $request->input('note', null);

        $cart = $this->getCurrentCustomerCart();

        if ($note) {
            $cart->note = $note;
        }
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

    public function getSubTotalAmount()
    {
        $itemsSubtotalAmount = $this->items->sum(function ($item) {
            $itemPrice = $item->pivot->item_price;
            $quantity  = $item->pivot->quantity;

            return $itemPrice * $quantity;
        });

        return $itemsSubtotalAmount;
    }

    public function getSubTotalAmountWithDeliveryCharge()
    {
        $itemsSubtotalAmount     = $this->getSubTotalAmount();
        $deliveryCharge          = $this->deliveryGateway->price;
        $totalWithDeliveryCharge = $itemsSubtotalAmount + $deliveryCharge;

        return $totalWithDeliveryCharge;
    }
}
