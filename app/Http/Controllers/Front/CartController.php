<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Cart;
use App\Models\Order;
use App\Classes\Utility;
use App\Models\UserAddress;
use App\Events\OrderCreate;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class CartController extends Controller
{
    public $cartObj;

    function __construct() {
        $this->cartObj = new Cart();
    }

    public function cartItem()
    {
        return view('frontend.pages.cart');
    }

    public function addItem(Request $request)
    {
        $res = $this->cartObj->_addItem($request);

        Utility::setUserEvent('add-to-cart', $request->all());

        return $res;
    }

    public function addMetaData(Request $request)
    {
        $res = $this->cartObj->_addMetaData($request);
        return $res;
    }

    public function removeItem(Request $request)
    {
        $this->cartObj->_removeItem($request);

        Utility::setUserEvent('remove-from-cart', $request->all());

        return back()->with('success', 'Item remove successfully');
    }

    public function emptyCart(Request $request)
    {
        $res = $this->cartObj->_emptyCart();

        Utility::setUserEvent('empty-cart', $request->all());

        return $res;
    }

    public function mergeCart()
    {
        return 'Merge cart';
    }

    public function cartItemCount()
    {
        $cartCount = 0;
        $cart      = $this->cartObj->_getCurrentCustomerCart();
        if ($cart) {
            $cartCount = $cart->items->count() ?? 0;
        }

        return $cartCount;
    }

    public function addShippingAdress(Request $request)
    {
        $request->validate([
            'shipping_address_id' => ['required', 'integer']
        ]);

        $shippingAddressId = $request->input('shipping_address_id', null);

        $cart = $this->cartObj->_getCurrentCustomerCart();
        if ($shippingAddressId) {
            $cart->shipping_address_id = $shippingAddressId;
            $res = $cart->save();

            return $res = [
                'code'    => 200,
                'message' => 'Shipping address updated successfully'
            ];
        }
    }

    //Return upload prescription view
    public function uploadPrescription()
    {
        $carObj           = new Cart();
        $cart             = $carObj->_getCurrentCustomerCart();
        $products         = $cart->items()->orderBy('id', 'desc')->getDefaultMetaData()->get();
        $areas            = Area::orderBy('name', 'asc')->get();
        $userAddress      = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $deliveryGateways = DeliveryGateway::where('status', 'activated')->get();
        $paymentGateways  = PaymentGateway::where('status', 'activated')->get();

        return view('frontend.pages.cart-prescription', [
            'cart'             => $cart,
            'areas'            => $areas,
            'products'         => $products,
            'userAddress'      => $userAddress,
            'deliveryGateways' => $deliveryGateways,
            'paymentGateways'  => $paymentGateways
        ]);
    }

    // Store prescripton
    public function prescriptionStore(Request $request)
    {
        $request->validate([
            'files'               => ['required'],
            'delivery_gateway_id' => ['required', 'integer'],
            'shipping_address_id' => ['required', 'integer'],
            'payment_method_id'   => ['required', 'integer']
        ]);

        $deliveryGatewayId = $request->input('delivery_gateway_id', null);
        $shippingAddressId = $request->input('shipping_address_id', null);
        $paymentMethodId   = $request->input('payment_method_id', null);
        $note              = $request->input('note', null);
        $userId            = Auth::id();
        $now               = Carbon::now();
        $cart              = Cart::where('customer_id', $userId)->first();
        $deliveryCharge    = 0;
        if ($cart) {
            $deliveryCharge = $cart->deliveryGateway->price ?? 0;
        }

        try {
            DB::beginTransaction();
            // Create order
            $orderObj = new Order();

            $orderObj->user_id             = $userId;
            $orderObj->delivery_type_id    = $deliveryGatewayId;
            $orderObj->payment_method_id   = $paymentMethodId;
            $orderObj->shipping_address_id = $shippingAddressId;
            $orderObj->coupon_id           = null;
            $orderObj->ordered_at          = $now;
            $orderObj->delivery_charge     = $deliveryCharge;
            $orderObj->note                = $note;
            $orderObj->created_by          = $userId;
            $res = $orderObj->save();

            // Upload prescriptions
            if ($res && $request->hasFile('files')) {
                $files           = $request->file('files');
                $prescriptionObj = new Prescription();
                $uploadPath      = $prescriptionObj->_getImageUploadPath();
                foreach ($files as $file) {
                    $path = Storage::put($uploadPath, $file);
                    Prescription::insert([
                            'order_id' => $orderObj->id,
                            'user_id'  => $userId,
                            'status'   => 'submitted',
                            'img_src'  => $path
                        ]);
                }
            }
            // Create transaction and dispatch event
            if ($res) {
                OrderCreate::dispatch($orderObj, $now);
                $orderID       = $orderObj->id;
                $paymentTrx    = new PaymentTransaction();
                $paymentTrx->make($orderID, null, 'sale', $paymentMethodId, 'pending');
                DB::commit();
                return redirect()->route('my.order.success');
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went to wrong');
        }


    }

    public function showPrescription($id)
    {
        $prescriptions = Prescription::where('order_id', $id)->get();

        if (!$prescriptions) {
            abort(404);
        }

        return view('frontend.pages.show-prescriptions', [
            'prescriptions' => $prescriptions
        ]);
    }

    public function drawerCart()
    {
        $products = [];
        $cartObj  = new Cart();
        $cart     = $cartObj->_getCurrentCustomerCart();
        if ($cart) {
            $products = $cart->items()->orderBy('id', 'desc')->getDefaultMetaData()->get();
        }

        $utility = new Utility();

        return $utility->makeResponse($products, 'All cart item', 200);
    }
}
