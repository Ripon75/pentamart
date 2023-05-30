<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Events\OrderCreate;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class OrderController extends Controller
{
    public function dashboard()
    {
        $orders = Order::withSum('items as total_amount', DB::raw('order_item.sell_price * order_item.quantity'))
            ->where('user_id', Auth::id())
            ->get();

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

    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');

        $orders = Order::withSum('items as total_amount', DB::raw('(order_item.sell_price * order_item.quantity)'))
        ->where('user_id', Auth::id())
        ->latest()
        ->paginate($paginate);

        $paymentGateways = PaymentGateway::whereNotIn('id', [1])->orderBy('name', 'asc')->get();

        return view('frontend.pages.my-order', [
            'orders'          => $orders,
            'currency'        => 'Tk',
            'paymentGateways' => $paymentGateways
        ]);
    }

    public function store(Request $request)
    {
        $note     = $request->input('note', null);
        $couponId = $request->input('coupon_id', null);

        try {
            DB::beginTransaction();

            $user     = Auth::user();
            $orderObj = new Order();
            $cartObj  = new Cart();

            // Get current customer cart
            $cart = $cartObj->getCurrentCustomerCart();
            $cart = Cart::find($cart->id);
            if (count($cart->items) == 0) {
                return back();
            }

            // Save note inside cart
            $cart->note = $note;
            $cart->save();

            $deliveryGatewayCharge = 0;
            $deliveryGateway = DeliveryGateway::where('status', 'active')->first();
            if ($deliveryGateway) {
                $deliveryGatewayCharge = $deliveryGateway->price;
            }

            // Check coupon code applied on delivery charge
            $deliveryChargeDiscount = 0;
            if ($couponId) {
                $coupon = Coupon::find($couponId);
                if ($coupon && $coupon->applicable_on === 'delivery_fee') {
                    $deliveryChargeDiscount = $coupon->discount_amount;
                }
            }

            if ($deliveryGatewayCharge >= $deliveryChargeDiscount) {
                $deliveryCharge = $deliveryGatewayCharge - $deliveryChargeDiscount;
            }

            $orderObj->user_id         = $user->id;
            $orderObj->pg_id           = 1;
            $orderObj->address_id      = $cart->address_id;
            $orderObj->address         = $cart->address->address ?? null;
            $orderObj->coupon_id       = $couponId;
            $orderObj->is_paid         = 0;
            $orderObj->delivery_charge = $deliveryCharge;
            $orderObj->note            = $note;
            $orderObj->created_by      = $user->id;
            $res = $orderObj->save();
            if ($res) {
                $itemIds = [];
                foreach ($cart->items as $item) {
                    $itemIds[$item->pivot->item_id] = [
                        'size_id'       => $item->pivot->size_id,
                        'color_id'      => $item->pivot->color_id,
                        'quantity'      => $item->pivot->quantity,
                        'item_price'    => $item->pivot->item_price,
                        'sell_price'    => $item->pivot->sell_price,
                        'item_discount' => $item->pivot->item_discount
                    ];
                }

                $res = $orderObj->items()->sync($itemIds);

                // Update order total_items_discount, order_net_value and coupon_value
                $orderObj->updateOrderValue($orderObj);

                $cart->emptyCart();
                // Dispatch order create event
                OrderCreate::dispatch($orderObj);

                // Create payment transaction
                $orderId    = $orderObj->id;
                $paymentTrx = new PaymentTransaction();
                $paymentTrx->make($orderId, null, 'sale', 1, 'pending');
                DB::commit();

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
