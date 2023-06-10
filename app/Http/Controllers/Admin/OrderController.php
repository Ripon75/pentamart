<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Order;
use App\Classes\Bkash;
use App\Models\Status;
use App\Models\Address;
use App\Classes\Utility;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;
use App\Models\DeliveryGateway;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
class OrderController extends Controller
{
    protected $util;

    function __construct(Utility $Util)
    {
        $this->util = $Util;
    }

    public function index(Request $request)
    {
        $now           = Carbon::now();
        $paginate      = config('crud.paginate.default');
        $startDate     = $request->input('start_date', null);
        $endDate       = $request->input('end_date', null);
        $action        = $request->input('action', null);
        $areaId        = $request->input('area_id', null);
        $pGateway      = $request->input('pg_id', null);
        $phoneNumber   = $request->input('phone_number', null);
        $orderId       = $request->input('order_id', null);
        $statusId      = $request->input('status_id', null);
        $customerName  = $request->input('customer_name', null);
        $endDate       = $endDate ?? $now;

        $order = new Order();
        $order = $order->with(['status']);

        if ($startDate && $endDate) {
            $startDate = $startDate.' 00:00:00';
            $endDate   = $endDate.' 23:59:59';
            $order  = $order->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($areaId) {
            $order = $order->whereHas('shippingAddress', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            });
        }
        // User name wise filter
        if ($customerName) {
            $order = $order->whereHas('user', function ($query) use ($customerName) {
                $query->where('name', 'like', "%{$customerName}%");
            });
        }

        // User contact wise filter
        if ($phoneNumber) {
            $order = $order->whereHas('user', function ($query) use ($phoneNumber) {
                $query->where('phone_number', 'like', "%{$phoneNumber}%");
            });
        }

        if ($pGateway) {
            $order = $order->where('pg_id', $pGateway);
        }

        if ($orderId) {
            $order = $order->where('id', $orderId);
        }

        if ($statusId) {
            $order = $order->where('status_id', $statusId);
        }

        $result = $order->orderBy('created_at', 'desc')->paginate($paginate);

        if ($action === 'export') {
            $maxPaginate = config('crud.paginate.max');
            $result = $order->orderBy('created_at', 'desc')->paginate($maxPaginate);
            return Excel::download(new OrdersExport($result), 'orders.xlsx');
        }

        $areas       = Area::orderBy('name', 'asc')->get();
        $pgs         = PaymentGateway::where('status', 'active')->orderBy('name', 'asc')->get();
        $orderStatus = Status::orderBy('name', 'asc')->get();

        return view('adminend.pages.order.index', [
            'result'      => $result,
            'areas'       => $areas,
            'pgs'         => $pgs,
            'orderStatus' => $orderStatus
        ]);
    }

    public function manualCreate()
    {
        $areas          = Area::orderBy('name', 'asc')->get();
        $orderStatus    = Status::orderBy('name', 'asc')->get();
        $deliveryCharge = DeliveryGateway::select('price', 'promo_price')->where('status', 'active')->first();
        // $pgs         = PaymentGateway::where('status', 'active')->get();

        return view('adminend.pages.order.create', [
              // 'pgs'         => $pgs,
            'areas'          => $areas,
            'orderStatus'    => $orderStatus,
            'deliveryCharge' => $deliveryCharge
        ]);
    }

    public function manualStore(Request $request)
    {
        $request->validate(
            [
                'items'               => ['required'],
                'address_id'          => ['required'],
                'pg_id'               => ['required'],
                'address_title'       => ['required_if:address_id,0'],
                'address_line'        => ['required_if:address_id,0'],
                'area_id'             => ['required_if:address_id,0'],
                'customer_name'       => ['required_if:user_id,0'],
                'search_phone_number' => ['required']
            ],
            [
                'address_title.required_if'    => 'The address title field is required',
                'address_line.required_if'     => 'The address field is required',
                'area_id.required_if'          => 'The area field is required',
                'customer_name.required_if'    => 'The customer name field is required',
                'pg_id.required'               => 'The payment method is required',
                'search_phone_number.required' => 'The user phone is required',
            ]
        );

        $items             = $request->input('items', []);
        $userId            = $request->input('user_id', null);
        $addressId         = $request->input('address_id', null);
        $paymentMethodId   = $request->input('pg_id', null);
        $searchPhoneNumber = $request->input('search_phone_number', null);
        $deliveryCharge    = $request->input('delivery_charge', null);
        $customerName      = $request->input('customer_name', null);
        $isPaid            = $request->input('is_paid', false);

        try {
            DB::beginTransaction();
            // When existing user was not selected
            if (!$userId) {
                $searchPhoneNumber = $this->util->formatPhoneNumber($searchPhoneNumber);
                // Search user by given phone number
                $checkUser = User::where('phone_number', $searchPhoneNumber)->first();
                if ($checkUser) {
                    $userId = $checkUser->id;
                } else {
                    // Create new user by given phone number and customer name
                    $user = new User();

                    $user->name         = $customerName;
                    $user->phone_number = $searchPhoneNumber;
                    $res = $user->save();
                    if ($res) {
                        $userId = $user->id;
                    }
                }
            }

            // Create new address when shipping address was not selected
            if ($addressId == 0) {
                $addressTitle = $request->input('address_title', null);
                $addressLine  = $request->input('address_line', null);
                $phoneNumber  = $request->input('phone_number', null);
                $areaId       = $request->input('area_id', null);
                $phoneNumber  = $this->util->formatPhoneNumber($phoneNumber);
                $phoneNumber  = $phoneNumber ? $phoneNumber : $searchPhoneNumber;

                // Check shipping address was already exist
                $userAddress = Address::where('title', $addressTitle)->where('user_id', $userId)->first();
                if ($userAddress) {
                    $userAddress->title        = $addressTitle;
                    $userAddress->address      = $addressLine;
                    $userAddress->phone_number = $phoneNumber;
                    $userAddress->user_id      = $userId;
                    $userAddress->area_id      = $areaId;
                    $res = $userAddress->save();
                } else {
                    $userAddress = new Address();

                    $userAddress->title        = $addressTitle;
                    $userAddress->address      = $addressLine;
                    $userAddress->phone_number = $phoneNumber;
                    $userAddress->user_id      = $userId;
                    $userAddress->area_id      = $areaId;
                    $res = $userAddress->save();
                }
            }

            $addressId = $addressId ? $addressId : $userAddress->id;

            // Create new order
            $order = new Order();

            $order->user_id         = $userId;
            $order->pg_id           = 1;
            $order->status_id       = 1;
            $order->address_id      = $addressId;
            $order->address         = $userAddress->address;
            $order->delivery_charge = $deliveryCharge;
            $order->is_paid         = $isPaid;
            $res = $order->save();

            if ($res) {
                $itemIds = [];
                foreach ($items as $item) {
                    $itemIds[$item['product_id']] = [
                        'size_id'       => $item['size_id'],
                        'color_id'      => $item['color_id'],
                        'quantity'      => $item['quantity'],
                        'item_price'    => $item['price'],
                        'sell_price'    => $item['price'],
                        'item_discount' => $item['discount']
                    ];
                }
                $res = $order->items()->sync($itemIds);

                // Update order total_items_discount, order_net_value and coupon_value
                $order->updateOrderValue($order);

                // Set order status

                $request->session()->forget('items');

                // Create payment transaction
                $orderId       = $order->id;
                $payablePrice  = round($order->payable_price);
                $paymentTrx = new PaymentTransaction();

                $paymentTrx->make($orderId, $payablePrice, 'sale', $paymentMethodId, 'pending');
                DB::commit();

                return back()->with('success', 'Order created succfully');
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->find($id);

        if (!$order) {
            abort(404);
        }

        $areas             = Area::orderBy('name', 'asc')->get();
        $pgs               = PaymentGateway::where('status', 'activated')->get();
        $shippingAddresses = Address::where('user_id', $order->user_id)->get();
        // $orderStatus       = $order->getNextStatus($order->status_id);

        return view('adminend.pages.order.edit', [
            'order'             => $order,
            'areas'             => $areas,
            'pgs'   => $pgs,
            'shippingAddresses' => $shippingAddresses,
            'orderStatus'       => [],
            'currency'          => 'Tk'
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pg_id'      => ['required', 'integer'],
            'address_id' => ['required', 'integer'],
            'area_id'    => ['required', 'integer'],
            'address'    => ['required'],
        ],
        [
            'address_id.required' => 'Please select shipping address'
        ]);

        $paymentMethodId = $request->input('pg_id');
        $addressId       = $request->input('address_id');
        $statusId        = $request->input('status_id', null);
        $deliveryCharge  = $request->input('delivery_charge', 0);
        $items           = $request->input('items');
        $address         = $request->input('address');
        $phoneNumber     = $request->input('phone_number');
        $areaID          = $request->input('area_id');
        $isPaid          = $request->input('is_paid');

        try {
            DB::beginTransaction();

            $order = Order::find($id);

            // Update shipping address
            if ($addressId) {
                $shippingAddress               = Address::find($addressId);
                $shippingAddress->address      = $address;
                $shippingAddress->phone_number = $phoneNumber;
                $shippingAddress->area_id      = $areaID;
                $shippingAddress->save();
            }

            $order->pg_id           = $paymentMethodId;
            $order->address_id      = $addressId;
            $order->created_by      = Auth::id();
            $order->delivery_charge = $deliveryCharge;
            $order->is_paid         = $isPaid;
            $res = $order->save();
            if ($res) {
                if ($items) {
                    $itemIds = [];
                    foreach ($items as $item) {
                        $itemIds[$item['product_id']] = [
                            'quantity'          => $item['quantity'],
                            'item_mrp'          => $item['item_mrp'],
                            'price'             => $item['price'],
                            'discount'          => $item['discount'],
                            'pack_size'         => $item['pack_size']
                        ];
                    }
                    $res = $order->items()->sync($itemIds);
                }

                // Update order total_items_discount, order_net_value and coupon_value
                $order->updateOrderValue($order);

                // Update payment transaction
                $paymentTransaction = PaymentTransaction::where('order_id', $id)->first();
                if ($paymentTransaction) {
                    $paymentTransaction->amount = round($order->payable_order_value);
                    $paymentTransaction->save();
                }
                DB::commit();
            }

            return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function show($id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }, 'status'])->find($id);

        if (!$order) {
            abort(404);
        }

        return view('adminend.pages.order.show', [
            'order'    => $order,
            'currency' => 'Tk'
        ]);
    }

    public function invoice($id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }, 'status'])->find($id);

        if (!$order) {
            abort(404);
        }

        return view('adminend.pages.order.invoice', [
            'order' => $order
        ]);
    }

    public function multipleInvoice(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date']
        ]);

        $startDate = $request->input('start_date', null);
        $endDate   = $request->input('end_date', null);

        $orders = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->whereBetween('ordered_at', [$startDate, $endDate])->get();

        return view('adminend.pages.order.multiple-invoice', [
            'orders' => $orders
        ]);
    }

    // Remome order item
    public function orderItemRemove(Request $request)
    {
        $request->validate([
            'order_id'      => ['required'],
            'order_item_id' => ['required']
        ]);

        $orderRequstId      = $request->input('order_id', null);
        $orderItemRequestId = $request->input('order_item_id', null);

        $order = Order::find($orderRequstId);

        if (!$order) {
            abort(404);
        }

        $order->items()->detach($orderItemRequestId);

        return back();
    }

    public function makePaid(Request $request)
    {
        $request->validate([
            'order_id' => ['required']
        ]);

        $orderID = $request->input('order_id', null);

        PaymentTransaction::whereIn('order_id', $orderID)->update(['status' => 'completed']);
        Order::whereIn('id', $orderID)->update(['is_paid' => 1]);
        return $this->sendResponse(null, 'Order paid successfully');
    }

    public function refund(Request $request, $orderId, $paymentGateway)
    {
        $order = Order::with(['transaction'])->find($orderId);

        if (!$order) {
            abort(404);
        }

        if ($paymentGateway === 'bkash') {
            return view('adminend.pages.order.payment-refund', [
                'order' => $order
            ]);
        }
    }

    public function refundStore(Request $request)
    {
        $request->validate([
            'payment_id'            => ['required'],
            'payment_gateway_trxid' => ['required'],
            'price'                 => ['required']
        ]);

        $paymentID = $request->input('payment_id', null);
        $PGTRXID   = $request->input('payment_gateway_trxid', null);
        $price     = $request->input('price', 0);
        $sku       = $request->input('sku', null);
        $note      = $request->input('note', null);

        $bKash = new Bkash();

        $res = $bKash->refundTransaction($paymentID, $PGTRXID, $price, $sku, $note);
        return $res;
    }
}
