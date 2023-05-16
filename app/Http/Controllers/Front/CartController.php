<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Area;
use App\Models\Address;
use App\Classes\Utility;
use App\Models\DeliveryGateway;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public $cartObj;

    function __construct() {
        $this->cartObj = new Cart();
    }

    public function cartItem()
    {
        $products = [];
        $carObj   = new Cart();
        $cart     = $carObj->getCurrentCustomerCart();
        if ($cart) {
            $products = $cart->items()->orderBy('id', 'desc')->getDefaultMetaData()->get();
        }

        $areas            = Area::orderBy('name', 'asc')->get();
        $userAddress      = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $deliveryGateways = DeliveryGateway::where('status', 'active')->get();
        $paymentGateways  = PaymentGateway::where('status', 'active')->get();
        $currency         = 'Tk';

        return view('frontend.pages.cart', [
            'cart'             => $cart,
            'areas'            => $areas,
            'products'         => $products,
            'userAddress'      => $userAddress,
            'deliveryGateways' => $deliveryGateways,
            'paymentGateways'  => $paymentGateways,
            'currency'         => $currency
        ]);
    }

    public function addItem(Request $request)
    {
        $res = $this->cartObj->addItem($request);

        Utility::setUserEvent('add-to-cart', $request->all());

        return $res;
    }

    public function addMetaData(Request $request)
    {
        $res = $this->cartObj->addMetaData($request);
        return $res;
    }

    public function removeItem(Request $request)
    {
        $this->cartObj->removeItem($request);

        Utility::setUserEvent('remove-from-cart', $request->all());

        return back()->with('success', 'Item remove successfully');
    }

    public function emptyCart(Request $request)
    {
        $res = $this->cartObj->emptyCart();

        Utility::setUserEvent('empty-cart', $request->all());

        return $res;
    }

    public function cartItemCount()
    {
        $cartCount = 0;
        $cart      = $this->cartObj->getCurrentCustomerCart();
        if ($cart) {
            $cartCount = $cart->items->count() ?? 0;
        }

        return $cartCount;
    }

    public function addShippingAdress(Request $request)
    {
        $request->validate([
            'address_id' => ['required', 'integer']
        ]);

        $addressId = $request->input('address_id', null);

        $cart = $this->cartObj->getCurrentCustomerCart();
        if ($addressId) {
            $cart->address_id = $addressId;
            $res = $cart->save();

            return $res = [
                'code'    => 200,
                'message' => 'Shipping address updated successfully'
            ];
        }
    }
}
