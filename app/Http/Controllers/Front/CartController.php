<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Area;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
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
        $products        = [];
        $selelctedColors = [];
        $selelctedSizes  = [];

        $carObj   = new Cart();
        $cart     = $carObj->getCurrentCustomerCart();
        if ($cart) {
            $products = $cart->items()->orderBy('id', 'desc')->getDefaultMetaData()->get();
        }

        foreach ($products as $product) {
            $colors  = json_decode($product->colors, true);
            $sizes   = json_decode($product->sizes, true);
            $colorId = $product->pivot->color_id;
            $sizeId  = $product->pivot->size_id;

            foreach ($colors as $color) {
                if (isset($color['id']) && $color['id'] === $colorId) {
                    $selelctedColors[] = $color;
                }
            }

            foreach ($sizes as $size) {
                if (isset($size['id']) && $size['id'] === $sizeId) {
                    $selelctedSizes[] = $size;
                }
            }
        }

        $areas              = Area::orderBy('name', 'asc')->get();
        $paymentGateways    = PaymentGateway::where('status', 'active')->get();
        $cartTotalSellPrice = Auth::user()->cart->getTotalSellPrice();
        $currency           = 'tk';

        return view('frontend.pages.cart', [
            'cart'               => $cart,
            'areas'              => $areas,
            'products'           => $products,
            'selelctedColors'    => $selelctedColors,
            'selelctedSizes'     => $selelctedSizes,
            'paymentGateways'    => $paymentGateways,
            'cartTotalSellPrice' => $cartTotalSellPrice,
            'currency'           => $currency
        ]);
    }

    public function checkout()
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
        $paymentGateways = PaymentGateway::where('status', 'active')->get();
        $currency         = 'tk';

        return view('frontend.pages.checkout', [
            'cart'             => $cart,
            'areas'            => $areas,
            'products'         => $products,
            'userAddress'      => $userAddress,
            'deliveryGateways' => $deliveryGateways,
            'paymentGateways' => $paymentGateways,
            'currency'         => $currency
        ]);
    }

    public function addItem(Request $request)
    {
        $res = $this->cartObj->addItem($request);

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

        return back()->with('success', 'Item remove successfully');
    }

    public function emptyCart()
    {
        $res = $this->cartObj->emptyCart();

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
            $cart->save();

            return $this->sendResponse(null, 'Shipping address updated successfully');
        }
    }
}
