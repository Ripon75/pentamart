<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Order;
use App\Classes\Bkash;
use App\Classes\Utility;
use App\Models\Status;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Exports\OrdersExport;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public $util;
    public $currency;

    public function __construct()
    {
        $this->currency = 'tk';
        $this->util     = new Utility;
    }

    public function index(Request $request)
    {
        $now           = Carbon::now();
        $startDate     = $request->input('start_date', null);
        $endDate       = $request->input('end_date', null);
        $action        = $request->input('action', null);
        $areaId        = $request->input('area_id', null);
        $pGateway      = $request->input('pg_id', null);
        $phoneNumber   = $request->input('phone_number', null);
        $orderId       = $request->input('order_id', null);
        $statusId      = $request->input('status_id', null);
        $prescription  = $request->input('is_prescription', null);
        $refCode       = $request->input('ref_code', null);
        $customerName  = $request->input('customer_name', null);
        $endDate       = $endDate ?? $now;
        $paginate      = config('crud.paginate.default');
        $sellPartnerId = Auth::user()->sell_partner_id;

        $orderObj = new Order();
        $orderObj = $orderObj->with(['status']);

        if ($startDate && $endDate) {
            $startDate = $startDate.' 00:00:00';
            $endDate   = $endDate.' 23:59:59';
            $orderObj  = $orderObj->whereBetween('ordered_at', [$startDate, $endDate]);
        }

        if ($areaId) {
            $orderObj = $orderObj->whereHas('shippingAddress', function ($query) use ($areaId) {
                $query->where('area_id', $areaId);
            });
        }
        // User name wise filter
        if ($customerName) {
            $orderObj = $orderObj->whereHas('user', function ($query) use ($customerName) {
                $query->where('name', 'like', "%{$customerName}%");
            });
        }

        // User contact wise filter
        if ($phoneNumber) {
            $orderObj = $orderObj->whereHas('user', function ($query) use ($phoneNumber) {
                $query->where('phone_number', 'like', "%{$phoneNumber}%");
            });
        }

        if ($sellPartnerId) {
            $orderObj = $orderObj->where('sell_partner_id', $sellPartnerId);
        }

        if ($pGateway) {
            $orderObj = $orderObj->where('pg_id', $pGateway);
        }

        if ($orderId) {
            $orderObj = $orderObj->where('id', $orderId);
        }

        if ($statusId) {
            $orderObj = $orderObj->where('current_status_id', $statusId);
        }

        if ($prescription) {
            if ($prescription === 'yes') {
                $orderObj = $orderObj->whereHas('prescriptions');
            }
            if ($prescription === 'no') {
                $orderObj = $orderObj->doesntHave('prescriptions');
            }
        }

        if ($refCode) {
            $orderObj = $orderObj->where('ref_code', $refCode);
        }

        $result = $orderObj->orderBy('ordered_at', 'desc')->paginate($paginate);

        if ($action === 'export') {
            $maxPaginate = config('crud.paginate.max');
            $result = $orderObj->orderBy('ordered_at', 'desc')->paginate($maxPaginate);
            return Excel::download(new OrdersExport($result), 'orders.xlsx');
        }

        $areas       = Area::orderBy('name', 'asc')->get();
        $dGateways   = DeliveryGateway::where('status', 'activated')->orderBy('name', 'asc')->get();
        $pGateways   = PaymentGateway::where('status', 'activated')->orderBy('name', 'asc')->get();
        $orderStatus = Status::where('seller_visibility', 1)->get();

        return view('adminend.pages.order.index', [
            'result'      => $result,
            'areas'       => $areas,
            'dGateways'   => $dGateways,
            'pGateways'   => $pGateways,
            'orderStatus' => $orderStatus
        ]);
    }

    public function edit(Request $request, $id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->find($id);

        if (!$order) {
            abort(404);
        }
        $areas             = Area::orderBy('name', 'asc')->get();
        $deliveryGateways  = DeliveryGateway::where('status', 'activated')->get();
        $paymentGateways   = PaymentGateway::where('status', 'activated')->get();
        $shippingAddresses = Address::where('user_id', $order->user_id)->get();
        $orderStatus       = $order->getNextStatus($order->status_id);

        return view('adminend.pages.order.edit', [
            'order'             => $order,
            'areas'             => $areas,
            'deliveryGateways'  => $deliveryGateways,
            'paymentGateways'   => $paymentGateways,
            'shippingAddresses' => $shippingAddresses,
            'orderStatus'       => $orderStatus,
            'currency'          => $this->currency
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

        $paymentMethodId      = $request->input('pg_id');
        $addressId            = $request->input('address_id');
        $orderedAt            = $request->input('ordered_at');
        $statusId             = $request->input('status_id', null);
        $deliveryCharge       = $request->input('delivery_charge', 0);
        $totalSpecialDiscount = $request->input('total_special_discount', 0);
        $items                = $request->input('items');
        $address              = $request->input('address');
        $phoneNumber          = $request->input('phone_number');
        $areaID               = $request->input('area_id');
        $paymentStatus        = $request->input('payment_status');

        $order = Order::find($id);

        if (!$order) {
            abort(404);
        }

        // Set order status
        $order->setStatus($statusId);
        // Update shipping address
        if ($addressId) {
            $shippingAddress               = Address::find($addressId);
            $shippingAddress->address      = $address;
            $shippingAddress->phone_number = $phoneNumber;
            $shippingAddress->area_id      = $areaID;
            $shippingAddress->save();
        }

        $order->pg_id                  = $paymentMethodId;
        $order->address_id             = $addressId;
        $order->ordered_at             = $orderedAt;
        $order->created_by             = Auth::id();
        $order->delivery_charge        = $deliveryCharge;
        $order->total_special_discount = $totalSpecialDiscount;
        $order->is_paid                = $paymentStatus;
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
        }

        return back()->with('success', 'Order updated successfully');
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
            'currency' => $this->currency
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

    public function shippingLabel($id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }, 'status'])->find($id);

        if (!$order) {
            abort(404);
        }

        return view('adminend.pages.order.shipping-label', [
            'order' => $order
        ]);
    }

    public function purchaseOrder($id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }, 'status'])->find($id);

        if (!$order) {
            abort(404);
        }

        return view('adminend.pages.order.purchase-order', [
            'order' => $order
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

    public function manualCreate(Request $request)
    {
        $areas             = Area::orderBy('name', 'asc')->get();
        $deliveryGateways  = DeliveryGateway::where('status', 'activated')->get();
        $paymentGateways   = PaymentGateway::where('status', 'activated')->get();
        $orderStatus       = Status::where('seller_visibility', 1)->get();

        return view('adminend.pages.order.create', [
            'areas'             => $areas,
            'deliveryGateways'  => $deliveryGateways,
            'paymentGateways'   => $paymentGateways,
            'orderStatus'       => $orderStatus
        ]);
    }

    public function manualStore(Request $request)
    {
        $request->validate([
            'items'                  => ['required'],
            'address_id'    => ['required'],
            'pg_id'      => ['required'],
            'shipping_address_title' => ['required_if:address_id,0'],
            'shipping_address_line'  => ['required_if:address_id,0'],
            'area_id'                => ['required_if:address_id,0'],
            'customer_name'          => ['required_if:user_id,0'],
            'others_title'           => ['required_if:shipping_address_title,Others'],
            'search_phone_number'    => ['required']
        ],
        [
            'shipping_address_title.required_if' => 'The address title field is required',
            'shipping_address_line.required_if'  => 'The address field is required',
            'area_id.required_if'                => 'The area field is required',
            'customer_name.required_if'          => 'The customer name field is required',
            'others_title.required_if'           => 'The others title field is required',
            'pg_id.required'         => 'The payment method is required',
            'search_phone_number.required'       => 'The user phone is required',
        ]);

        $items             = $request->input('items', null);
        $userId            = $request->input('user_id', null);
        $addressId         = $request->input('address_id', null);
        $paymentMethodId   = $request->input('pg_id', null);
        $searchPhoneNumber = $request->input('search_phone_number', null);
        $deliveryCharge    = $request->input('delivery_charge', null);
        $customerName      = $request->input('customer_name', null);
        $paymentStatus     = $request->input('payment_status', false);
        $orderedAt         = $request->input('ordered_at', false);

        $orderedAt = $orderedAt ? $orderedAt : Carbon::now();

        // When existing user was not selected
        if (!$userId) {
            if (str_starts_with($searchPhoneNumber, '0')) {
                $searchPhoneNumber = '88'.$searchPhoneNumber;
            } else {
                $searchPhoneNumber = $searchPhoneNumber;
            }
            // Search user by given phone number
            $checkUser = User::where('phone_number', $searchPhoneNumber)->first();
            if ($checkUser) {
                $userId = $checkUser->id;
            } else {
                // Create new user by given phone number and customer name
                $userObj = new User();
                $password = 123456789;

                $userObj->phone_number        = $searchPhoneNumber;
                $userObj->password            = Hash::make($password);
                $userObj->terms_and_conditons = 1;
                $userObj->ac_active           = 1;
                $userObj->name                = $customerName;
                $res = $userObj->save();
                if ($res) {
                    $userId = $userObj->id;
                }
            }
        }

        // Create new address when shipping address was not selected
        if ($addressId == 0) {
            $addressTitle = $request->input('shipping_address_title', null);
            $addressLine  = $request->input('shipping_address_line', null);
            $phoneNumber  = $request->input('phone_number', null);
            $areaId       = $request->input('area_id', null);
            $otherTitle   = $request->input('others_title', false);

            $addressTitle = $otherTitle ? $otherTitle : $addressTitle;

            // Check shipping address was already exist
            $checkShippingAddress = Address::where('title', $addressTitle)->where('user_id', $userId)->first();
            if ($checkShippingAddress) {
                return back()->with('title_exist', 'The address title already taken');
            }

            $phoneNumber = $phoneNumber ? $phoneNumber : $searchPhoneNumber;

            $userAddressObj = new Address();

            $userAddressObj->title        = $addressTitle;
            $userAddressObj->address      = $addressLine;
            $userAddressObj->phone_number = $phoneNumber;
            $userAddressObj->user_id      = $userId;
            $userAddressObj->area_id      = $areaId;
            $res = $userAddressObj->save();
        }

        // Create new order
        $orderObj = new Order();

        $orderObj->user_id         = $userId;
        $orderObj->address_id      = $addressId == 0 ? $userAddressObj->id : $addressId;
        $orderObj->pg_id           = $paymentMethodId;
        $orderObj->delivery_charge = $deliveryCharge;
        $orderObj->is_paid         = $paymentStatus;
        $orderObj->ordered_at      = $orderedAt;
        $orderObj->created_by      = Auth::id();
        $res = $orderObj->save();

        if ($res) {
            // Create order details
            $now = Carbon::now();
            $itemIds = [];
            foreach ($items as $item) {
                $itemIds[$item['product_id']] = [
                    'quantity'  => $item['quantity'],
                    'pack_size' => $item['pack_size'],
                    'item_mrp'  => $item['item_mrp'],
                    'price'     => $item['price'],
                    'discount'  => $item['discount'],
                ];
            }
            $res = $orderObj->items()->sync($itemIds);

            // Update order total_items_discount, order_net_value and coupon_value
            $orderObj->updateOrderValue($orderObj);

            // Dispatch manual order create event

            $request->session()->forget('items');

            // Create payment transaction
            $paymentTrx = new PaymentTransaction();

            $paymentTrxRes = $paymentTrx->make($orderObj->id, null, 'sale', $paymentMethodId, 'pending');

            if ($res) {
                return back()->with('message', 'Order create successfully');
            }
        } else {
            return back()->with('message', 'Order does not create successfully');
        }
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
