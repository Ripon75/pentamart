<?php

namespace App\Http\Controllers\Front;

use DB;
use Auth;
use Setting;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Classes\Bkash;
use App\Classes\Nagad;
use App\Classes\Utility;
use App\Events\OrderCreate;
use App\Models\UserAddress;
use App\Classes\SSLGateway;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Exports\OrdersExport;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
use App\Models\PaymentTransaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public $currency;

    public function __construct()
    {
        $this->currency = Setting::getValue('app_currency_symbol', null, 'Tk');
    }

    public function dashboard()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'customer-dashboard',
        ]);

        $orders = Order::withSum('items as total_amount', DB::raw('order_item.price * order_item.quantity'))
            ->where('user_id', Auth::id())->get();

        $totalAmount = 0;

        foreach ($orders as $order) {
            $deliveryCharge = $order->delivery_charge;
            $couponDiscount = ($order->coupon->discount_amount) ?? 0;
            $specialDiscout = $order->total_special_discount;
            $totalDiscount  = $couponDiscount + $specialDiscout;
            $totalAmount += ($order->total_amount + $deliveryCharge) - $totalDiscount;
        }

        $totalAmount = round($totalAmount);

        return view('frontend.pages.my-dashboard', [
            'orders'      => $orders,
            'totalAmount' => $totalAmount
        ]);
    }
    // Get all order
    public function index(Request $request)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'customer-order-list',
        ]);

        $paginate = config('crud.paginate.default');

        $orders = Order::withSum('items as total_amount', DB::raw('(order_item.price * order_item.quantity)'))
            ->where('user_id', Auth::id())->latest()->paginate($paginate);
        $paymentGateways = PaymentGateway::whereNotIn('id', [1])->orderBy('name', 'asc')->get();

        return view('frontend.pages.my-order', [
            'orders'          => $orders,
            'currency'        => $this->currency,
            'paymentGateways' => $paymentGateways
        ]);
    }

    // Create order
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => ['required', 'integer'],
            'payment_method_id'   => ['required', 'integer']
        ]);

        $paymentMethodId   = $request->input('payment_method_id', null);
        $shippingAddressId = $request->input('shipping_address_id', null);
        $prescriptionId    = $request->input('prescription_id', null);
        $status            = $request->input('status', null);
        $note              = $request->input('note', null);
        $couponId          = $request->input('coupon_code_id', null);


        // Check first order
        $isFirstOrder = false;
        $userOrderCount = count(Auth::user()->orders) ?? 0;
        if (!$userOrderCount) {
            $isFirstOrder = true;
        }

        // Check coupon code applied on delivery charge
        $deliveryCharge = 0;
        if ($couponId) {
            $coupon = Coupon::find($couponId);
            if ($coupon && $coupon->applicable_on === 'delivery_fee') {
                $deliveryCharge = $coupon->discount_amount;
            }
        }

        $user     = Auth::user();
        $orderObj = new Order();
        $cartObj  = new Cart();
        $now      = Carbon::now();

        // Get current customer cart
        $cart = $cartObj->_getCurrentCustomerCart();
        $cart = Cart::find($cart->id);
        if (count($cart->items) == 0) {
            return back();
        }

        // Save note inside cart
        $cart->note = $note;
        $cart->save();

        $deliveryGatewayCharge = $cart->deliveryGateway->price ?? 0;
        $deliveryCharge = $deliveryGatewayCharge - $deliveryCharge;
        $deliveryCharge = $isFirstOrder ? 0 : $deliveryCharge;

        // Check cart amount greater than 1000
        // if true than delivery charge will be zero
        $freeDeliveryCartAmount = config('crud.free_delivery_cart_amount');
        $cartTotalAmount = $cart->_getSubTotalAmount();
        if ($cartTotalAmount >= $freeDeliveryCartAmount) {
            $deliveryCharge = 0;
        }

        $orderObj->user_id             = $user->id;
        $orderObj->delivery_type_id    = ($cart->delivery_type_id) ?? 1;
        $orderObj->payment_method_id   = ($cart->payment_method_id) ?? 1;
        $orderObj->shipping_address_id = ($cart->shipping_address_id) ?? null;
        $orderObj->coupon_id           = $couponId ?? null;
        $orderObj->is_paid             = 0;
        $orderObj->delivery_charge     = $deliveryCharge;
        $orderObj->note                = $note;
        $orderObj->ordered_at          = $now;
        $orderObj->created_by          = $user->id;
        $orderRes = $orderObj->save();

        if ($orderRes) {
            $itemIds = [];
            foreach ($cart->items as $item) {
                $itemIds[$item->pivot->item_id] = [
                    'quantity'          => $item->pivot->quantity,
                    'pack_size'         => $item->pivot->item_pack_size,
                    'item_mrp'          => $item->pivot->item_mrp,
                    'price'             => $item->pivot->price,
                    'discount'          => $item->pivot->discount,
                    'pos_product_id'    => $item->pos_product_id
                ];
            }

            $res = $orderObj->items()->sync($itemIds);

            // Update order total_items_discount, order_net_value and coupon_value
            $orderObj->updateOrderValue($orderObj);

            if ($res) {
                 // Upload prescription
                if ($request->hasFile('files')) {
                    $files           = $request->file('files');
                    $prescriptionObj = new Prescription();
                    $uploadPath      = $prescriptionObj->_getImageUploadPath();
                    foreach ($files as $file) {
                        $path = Storage::put($uploadPath, $file);
                        Prescription::insert([
                            'order_id' => $orderObj->id,
                            'user_id'  => $user->id,
                            'status'   => 'submitted',
                            'img_src'  => $path
                        ]);
                    }
                }

                $cart->_emptyCart();
                // Dispatch order create event
                OrderCreate::dispatch($orderObj, $now);

                // Create payment transaction
                $orderId       = $orderObj->id;
                $paymentTrx    = new PaymentTransaction();
                $paymentTrxRes = $paymentTrx->make($orderId, null, 'sale', $paymentMethodId, 'pending');
                $amount        = $paymentTrxRes->amount;
                $trxId         = $paymentTrxRes->id;
                $customerPhone = $user->phone_number;

                Utility::setUserEvent('order-submit', [
                    'order' => $orderObj,
                    'user'  => $user
                ]);

                // Here 1 is the COD payment gateway ID
                if ($paymentMethodId == 1) {
                    return redirect()->route('my.order.success');
                } else if($paymentMethodId == 2) {
                    $numOfItems = count($itemIds);
                    return $this->executeSSLPayment($shippingAddressId, $user, $amount, $trxId, $numOfItems);
                } else if($paymentMethodId == 3) {
                    // $customerPhone = payerReference;
                    return $this->executeBkashPayment($amount, $trxId, $customerPhone);
                } else if ($paymentMethodId == 4){
                    return $this->executeNagadPayment($orderId, $amount);
                }else {
                    return redirect()->route('my.order.success');
                }
            }
        } else {
            Utility::setUserEvent('order-failed', [
                'user'  => $user
            ]);

            return redirect()->route('my.order.failed');
        }
    }

    public function makePayment(Request $request, $id)
    {
        $request->validate([
            'payment_method_id' => ['required']
        ]);

        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->find($id);

        $paymentMethodId = $request->input('payment_method_id', null);
        if ($paymentMethodId) {
            $order->payment_method_id = $paymentMethodId;
            $order->save();
        }

        Utility::setUserEvent('make-payment', [
            'order' => $order
        ]);

        if ($order && !$order->is_paid) {
            $paymentMethodId   = $order->payment_method_id;
            $shippingAddressId = $order->shipping_address_id;
            $user              = Auth::user();
            $numOfItems        = count($order->items);
            $customerPhone     = $user->phone_number;

            $paymentTrx = PaymentTransaction::where('order_id', $id)->first();
            if (!$paymentTrx) {
                abort(404);
            }
            $amount = $paymentTrx->amount;
            $trxId  = $paymentTrx->id;

            if ($paymentMethodId === 2) {
                return $this->executeSSLPayment($shippingAddressId, $user, $amount, $trxId, $numOfItems);
            } else if($paymentMethodId === 3){
                // $customerPhone = payerReference
                return $this->executeBkashPayment($amount, $trxId, $customerPhone);
            } else if ($paymentMethodId === 4){
                return $this->executeNagadPayment($id, $amount);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    // Execute SSL payment gateway
    public function executeSSLPayment($shippingAddressId, $user, $amount, $trxId, $numOfItems)
    {
        $shippingAddress = UserAddress::find($shippingAddressId);
        $productCats      = "ProductCategory";
        $productName      = "Productname";
        $productProfile   = "general";
        $customerName     = $user->name;
        $customerPhone    = $user->phone_number;
        $customerEmail    = $user->email;
        $customerAddress  = $shippingAddress->address;
        $customerCity     = "City";
        $customerPostcode = "0000";
        $customerCountry  = "Bangladesh";
        // $numOfItems       = count($itemIds);
        $multiCardName    = "";

        $sslGatewayObj = new SSLGateway();
        $paymentRes = $sslGatewayObj->requestSession(
            $amount, $trxId, $productCats, $productName, $productProfile,
            $customerName, $customerEmail, $customerAddress, $customerCity, $customerPostcode, $customerCountry, $customerPhone,
            $numOfItems, $multiCardName
        );

        $paymentResStatus = $paymentRes['status'];

        if ($paymentResStatus === "SUCCESS") {
            $redirectGatewayURL = $paymentRes['redirectGatewayURL'];
            // Redirect outside of my project route
            return redirect()->away($redirectGatewayURL);
        } else {
            return redirect()->route('callback.payment_gateway', ['ssl', 'failed']);
        }
    }

    // Execute bKash payment gateway
    public function executeBkashPayment($amount, $invoiceNumber, $payerReference)
    {
        $bKashObj = new Bkash();

        $paymentRes = $bKashObj->createPayment(
            $amount,
            $invoiceNumber,
            $payerReference,
            $currency = 'BDT',
            $mode = '0011',
            $intent = 'sale'
        );

        if ($paymentRes['statusCode'] === '0000') {
            $redirectGatewayURL = $paymentRes['bkashURL'];
            // Redirect outside of my project route
            return redirect()->away($redirectGatewayURL);
        } else {
            return redirect()->route('callback.payment_gateway', ['bkash', 'failed']);
        }
    }

    // Execute nagad payment gateway
    public function executeNagadPayment($orderId, $amount)
    {
        $randomNumber = rand();
        $orderId      = $orderId . "MC" . $randomNumber;

        $_SESSION['orderId'] = $orderId;

        $nagadObj = new Nagad();
        $response = $nagadObj->nagadPaymentRequest($orderId, $amount);
        return $response;
    }

    public function show($id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->where('user_id', Auth::id())->find($id);
        $paymentGateways = PaymentGateway::whereNotIn('id', [1])->orderBy('name', 'asc')->get();
        
        
        if (!$order) {
            abort(404);
        }

        Utility::setUserEvent('pageView', [
            'page'  => 'customer-order-details',
            'order' => $order
        ]);

        return view('frontend.pages.my-order-details', [
            'order'           => $order,
            'currency'        => $this->currency,
            'paymentGateways' => $paymentGateways
        ]);
    }

    public function orderSuccess()
    {
        return view('frontend.pages.order-success');
    }

    public function orderFailed()
    {
        return view('frontend.pages.order-failed');
    }

    // Delete order
    public function removeItem(Request $request)
    {
        $orderId = $request->input('order_id');

        if ($orderId) {
            $order = Order::find($orderId);
            if (!$order) {
                abort(404);
            }
            $order->delete();
            $order->items()->detach($orderId);

            return back();
        }
    }

    // Selected order add to cart
    public function reorder(Request $request, $orderID)
    {
        Utility::setUserEvent('re-order', [
            'order_id' => $orderID
        ]);

        $userId = Auth::id();
        $order  = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->find($orderID);

        if ($order && ($order->user_id === $userId)) {
            $cart = new Cart();
            $cart = $cart->_getCurrentCustomerCart();
            $cart->items()->detach();

            $itemIds = [];
            foreach ($order->items as $item) {
                $itemQuantity = $item->pivot->quantity;
                $packSize     = $item->pivot->pack_size;
                $itemMRP      = $item->pivot->item_mrp;
                $price        = $item->pivot->price;
                $discount     = $item->pivot->discount;

                $itemIds[$item->id] = [
                    'quantity'       => $itemQuantity,
                    'item_pack_size' => $packSize,
                    'item_mrp'       => $itemMRP,
                    'price'          => $price,
                    'discount'       => $discount
                ];
            }
            $res = $cart->items()->sync($itemIds);
            if ($res) {
                return redirect()->route('checkout');
            }
        } else {
            abort(404);
        }
    }
}
