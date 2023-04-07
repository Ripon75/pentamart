<?php

namespace App\Models;

use App\Models\User;
use App\Classes\Model;
use App\Models\Product;
use App\Classes\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $className = 'Cart';

    protected $_columns = [
        'id' => [
            'cast'     => 'integer'
        ],
        'customer_id' => [
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
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->belongsToMany(Product::class, 'cart_item', 'cart_id', 'item_id')
                    ->withPivot('quantity', 'item_pack_size', 'item_mrp', 'price', 'discount')
                    ->withTimestamps();
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'shipping_address_id', 'id');
    }

    public function deliveryGateway()
    {
        return $this->belongsTo(DeliveryGateway::class, 'delivery_type_id', 'id');
    }
    // Relation end

    public function _addItem($request)
    {
        $request->validate([
            'item_id'       => ['required', 'integer'],
            'item_quantity' => ['required', 'integer'],
        ]);

        $itemId          = $request->input('item_id');
        $itemQuantity    = $request->input('item_quantity');
        $isLocalStoreage = $request->input('is_local_storage', false);

        if ($itemQuantity <= 0) {
            return $this->_removeItem($request);
        }

        $cart       = false;
        $price      = 0;
        $offerPrice = 0;
        $discount   = 0;

        // Step 01: Check the item/product is exist in products table
        $product = Product::find($itemId);

        if(!$product) {
            return $this->_makeResponse(false, null, 'Product not found');
        }

        if ($isLocalStoreage) {
            $itemQuantity = $product->pack_size;
        }

        $mrp      = $product->mrp;
        $packSize = $product->pack_size;

        $utility = new Utility ();

        
        if ($product->selling_price > 0) {
            $discount   = $mrp - $product->selling_price;
            $offerPrice = $mrp - $discount;
        }

        $res = $utility->checkOffer($itemId, $itemQuantity);
        if ($res) {
            $discount   = $mrp - $res['result'];
            $offerPrice = $mrp - $discount;
        }

        $price = $discount > 0 ? $offerPrice : $mrp;

        if (!$price) {
            return $this->_makeResponse(false, null, 'Product have no price');
        }

        // Step 02:A: Check that customer is login or not
        $cart = $this->_getCurrentCustomerCart();

        if (!$cart) {
            $customerId = Auth::id();
            $cart = $this->_createAndAssignCustomer($customerId);
        }

        // Step 05: Check the item is already exist in that cart?
        // $item = $cart->items()->where('id', $itemId)->first(); // <- No need to check that item is exist or not, because we use sync() function.
        // Step 06: If item is exist, sync that item quantity & price
        $cart->items()->detach($itemId);
        $res = $cart->items()->attach($itemId, [
                'quantity'          => $itemQuantity,
                'item_pack_size'    => $packSize,
                'item_mrp'          => $mrp,
                'price'             => $price,
                'discount'          => $discount
            ]
        );

        return $this->_makeResponse(true, $res, 'Item added successfully');
    }

    public function _removeItem($request)
    {
        $request->validate([
            'item_id'      => ['required', 'integer'],
        ]);

        $itemId = $request->input('item_id');

        $product = Product::find($itemId);

        if(!$product) {
            return $this->_makeResponse(false, null, 'Product not found');
        }

        $cart = $this->_getCurrentCustomerCart();
        $res  = $cart->items()->detach($itemId);

        return $this->_makeResponse(true, $res, 'Item removed successfuly');
    }

    public function _emptyCart()
    {
        $cart = $this->_getCurrentCustomerCart();
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

        $cart = $this->_getCurrentCustomerCart();

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

    // Create customer and assign into cart
    public function _createAndAssignCustomer($customerId)
    {
        $cart = new Self();
        $cart->customer_id = $customerId;
        $cart->save();

        return $cart;
    }

    public function _createAnonymousCart()
    {
        return $this->_createAndAssignCustomer(null);
    }

    public function _getCurrentCustomerCart()
    {
        if (Auth::check()) {
            $customer = Auth::user();
            $cart     = $customer->cart;
            if($cart) {
                return $cart;
            }
        }

        return false;
    }

    private function _itemExist($cart, $itemId, $packID)
    {
        return 'Item Exist';
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
