<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Events\OrderCreate;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\District;

class OrderController extends Controller
{
    public function dashboard()
    {
        $orders      = Order::count();
        $ordersValue = Order::sum('payable_price');

        return view('frontend.pages.my-dashboard', [
            'orders'      => $orders,
            'ordersValue' => $ordersValue
        ]);
    }

    public function index()
    {
        $paginate = config('crud.paginate.default');

        $orders = Order::where('user_id', Auth::id())->latest()->paginate($paginate);

        return view('frontend.pages.my-order', [
            'orders'   => $orders,
            'currency' => 'tk'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => ['required_if:address_id,null'],
            'district_id'    => ['required_if:address_id,null', "integer"],
            'thana'          => ['required_if:address_id,null', "max:20"],
            'address'        => ['required_if:address_id,null', "max:500"],
            'phone_number'   => ['required_if:address_id,null', "declined_if:required_if,regex:/^[0-9]+$/", "declined_if:required_if,digits:11"],
            'phone_number_2' => ['nullable', 'regex:/^[0-9]+$/', 'digits:11']
        ],
        [
            'title.required_if'        => 'Please select address title.',
            'thana.required_if'        => 'The thana field is required.',
            'address.required_if'      => 'The address field is required.',
            'phone_number.required_if' => 'The phone_number field is required.',
        ]);

        $addressId    = $request->input('address_id', null);
        $couponId     = $request->input('coupon_id', null);
        $note         = $request->input('note', null);
        $userName     = $request->input('user_name', null);
        $title        = $request->input('title', null);
        $address      = $request->input('address', null);
        $phoneNumber  = $request->input('phone_number', null);
        $phoneNumber2 = $request->input('phone_number_2', null);
        $districtId   = $request->input('district_id', null);
        $thana        = $request->input('thana', null);
        $authUser     = Auth::user();

        $userName = $userName ? $userName : $authUser->name;

        if ($addressId) {
            $addressObj = Address::find($addressId);
        } else {
            $addressObj = Address::where('title', $title)->first();
            if (!$addressObj) {
                $addressObj = new Address();
            }

            $addressObj->user_name      = $userName;
            $addressObj->title          = $title;
            $addressObj->address        = $address;
            $addressObj->user_id        = $authUser->id;
            $addressObj->phone_number   = $phoneNumber;
            $addressObj->phone_number_2 = $phoneNumber2;
            $addressObj->district_id    = $districtId;
            $addressObj->thana          = $thana;
            $addressObj->save();
        }

        $address        = $addressObj->address;
        $deliveryCharge = District::where('id', $addressObj->district_id)->value('delivery_charge');

        try {
            DB::beginTransaction();

            $orderObj = new Order();
            $cartObj  = new Cart();

            // Get current customer cart
            $cart = $cartObj->getCurrentCustomerCart();
            if (count($cart->items) == 0) {
                return false;
            }

            $orderObj->user_id         = Auth::id();
            $orderObj->pg_id           = 1;
            $orderObj->status_id       = 1;
            $orderObj->address_id      = $addressId;
            $orderObj->address         = $address;
            $orderObj->coupon_id       = $couponId;
            $orderObj->is_paid         = 0;
            $orderObj->delivery_charge = $deliveryCharge;
            $orderObj->note            = $note;
            $res = $orderObj->save();
            if ($res) {
                $itemIds = [];
                foreach ($cart->items as $item) {
                    $itemIds[] = [
                        'order_id'        => $orderObj->id,
                        'item_id'         => $item->pivot->item_id,
                        'color_id'        => $item->pivot->color_id,
                        'size_id'         => $item->pivot->size_id,
                        'quantity'        => $item->pivot->quantity,
                        'item_mrp'        => $item->pivot->item_mrp,
                        'item_buy_price'  => $item->pivot->item_buy_price,
                        'item_sell_price' => $item->pivot->item_sell_price,
                        'item_discount'   => $item->pivot->item_discount
                    ];
                }

                $res = $orderObj->items()->sync($itemIds);

                // Update order total_items_discount, order_net_value and coupon_value
                $orderObj->updateOrderValue($orderObj);

                // update items stock
                $orderObj->removedItemStock($orderObj);

                // Dispatch order create event
                OrderCreate::dispatch($orderObj);

                // attach order status id
                $orderObj->status()->attach(1);

                // Create payment transaction
                $orderId      = $orderObj->id;
                $payablePrice = $orderObj->payable_price;

                $paymentTrx = new PaymentTransaction();
                $paymentTrx->make($orderId, $payablePrice, 'sale', 1, 'pending');
                DB::commit();

                // removed all cart iems
                $cart->emptyCart();

                return redirect()->route('my.order.success');
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return redirect()->route('my.order.failed');
        }
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

        return view('frontend.pages.my-order-details', [
            'order'           => $order,
            'currency'        => 'Tk',
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
}
