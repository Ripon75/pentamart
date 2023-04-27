<?php

namespace App\Models;

use App\Models\User;
use App\Classes\Model;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $className = 'Cart';

    protected $_columns = [
        'id' => [
            'cast'     => 'integer'
        ],
        'user_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'dg_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'pg_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'address_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'note' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'created_at'   => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'updated_at'   => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'deleted_at'   => [
            'cast'     => 'datetime:Y-m-d H:i:s'
        ]
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

    public function deliveryGateway()
    {
        return $this->belongsTo(DeliveryGateway::class, 'dg_id', 'id');
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
            return $this->_makeResponse(false, null, 'Product not found');
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
                        return $this->_makeResponse(false, null, 'Product already added to cart');
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
        return $this->_makeResponse(true, $res, 'Item added successfully');
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

        return $this->_makeResponse(true, $res, 'Item removed successfuly');
    }

    public function emptyCart()
    {
        $cart = $this->getCurrentCustomerCart();
        $res = $cart->items()->detach();

        $cart->dg_id = 1;
        $cart->pg_id = 1;
        $cart->note  = null;
        $cart->save();

        return $this->_makeResponse(true, $res, 'Cart empty successfuly');
    }

    public function addMetaData($request)
    {
        $dgId = $request->input('dg_id', null);
        $pgId = $request->input('pg_id', null);
        $note = $request->input('note', null);

        $cart = $this->getCurrentCustomerCart();

        if ($note) {
            $cart->note = $note;
        }
        if ($dgId) {
            $cart->dg_id = $dgId;
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
