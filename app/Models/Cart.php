<?php

namespace App\Models;

use App\Models\User;
use App\Classes\Model;
use App\Models\Product;
use App\Classes\Utility;
use Illuminate\Support\Facades\Auth;
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
        'delivery_type_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'payment_method_id' => [
            'cast'     => 'integer',
            'fillable' => true
        ],
        'shipping_address_id' => [
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
            ->withPivot('size_id', 'color_id', 'quantity', 'item_price', 'sell_price', 'discount')
            ->withTimestamps();
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function deliveryGateway()
    {
        return $this->belongsTo(DeliveryGateway::class, 'delivery_type_id', 'id');
    }
    // Relation end

    public function _addItem($request)
    {
        $request->validate([
            'item_id'  => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'size_id'  => ['nullable', 'integer'],
            'color_id' => ['nullable', 'integer']
        ]);

        $itemId   = $request->input('item_id');
        $quantity = $request->input('quantity');
        $sizeId   = $request->input('size_id');
        $colorId  = $request->input('color_id');

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
        if (count($cart->items)) {
            foreach ($cart->items as $item) {
                if ($item->id == $itemId && $item->pivot->size_id == $sizeId && $item->pivot->color_id == $colorId) {
                    return $this->_makeResponse(false, null, 'Product already added to cart');
                }
            }
        }

        // $cart->items()->detach($itemId);
        $res = $cart->items()->attach($itemId, [
                'size_id'    => $sizeId,
                'color_id'   => $colorId,
                'quantity'   => $quantity,
                'item_price' => $itemPrice,
                'sell_price' => $sellPrice,
                'discount'   => $discount
            ]
        );

        return $this->_makeResponse(true, $res, 'Item added successfully');
    }

    public function removeItem($request)
    {
        $request->validate([
            'item_id'      => ['required', 'integer'],
        ]);

        $itemId = $request->input('item_id');

        $product = Product::find($itemId);

        if(!$product) {
            return $this->_makeResponse(false, null, 'Product not found');
        }

        $cart = $this->getCurrentCustomerCart();
        $res  = $cart->items()->detach($itemId);

        return $this->_makeResponse(true, $res, 'Item removed successfuly');
    }

    public function _emptyCart()
    {
        $cart = $this->getCurrentCustomerCart();
        $res = $cart->items()->detach();

        $cart->delivery_type_id    = 1;
        $cart->payment_method_id   = 1;
        $cart->note                = null;
        $cart->save();

        return $this->_makeResponse(true, $res, 'Cart empty successfuly');
    }

    public function _addMetaData($request)
    {
        $deliveryTypeId  = $request->input('delevery_type_id', null);
        $paymentMethodId = $request->input('payment_method_id', null);
        $note            = $request->input('note', null);

        $cart = $this->getCurrentCustomerCart();

        if ($note) {
            $cart->note = $note;
        }
        if ($deliveryTypeId) {
            $cart->delivery_type_id = $deliveryTypeId;
        }
        if ($paymentMethodId) {
            $cart->payment_method_id = $paymentMethodId;
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

    public function _getSubTotalAmount()
    {
        $itemsSubtotalAmount = $this->items->sum(function ($item) {
            $price    = $item->pivot->price;
            $quantity = $item->pivot->quantity;

            return $price * $quantity;
        });

        return $itemsSubtotalAmount;
    }

    public function _getSubTotalAmountWithDeliveryCharge()
    {
        $itemsSubtotalAmount = $this->_getSubTotalAmount();
        $deliveryCharge      = $this->deliveryGateway->price;
        $totalWithDeliveryCharge = $itemsSubtotalAmount + $deliveryCharge;

        return $totalWithDeliveryCharge;
    }
}
