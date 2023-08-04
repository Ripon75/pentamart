<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use App\Models\District;
use App\Models\Address;
use App\Classes\Utility;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
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

        $areas       = District::orderBy('name', 'asc')->get();
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
        $districts   = District::orderBy('name', 'asc')->get();
        $orderStatus = Status::orderBy('name', 'asc')->get();

        return view('adminend.pages.order.create', [
            'districts'   => $districts,
            'orderStatus' => $orderStatus,
        ]);
    }

    public function manualStore(Request $request)
    {
        $request->validate(
            [
                'items'               => ['required'],
                'address_id'          => ['required'],
                'address_title'       => ['required_if:address_id,0'],
                'address_line'        => ['required_if:address_id,0'],
                'district_id'         => ['required_if:address_id,0'],
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

        $districts         = District::orderBy('name', 'asc')->get();
        $shippingAddresses = Address::where('user_id', $order->user_id)->get();
        $orderStatus       = Status::orderBy('name', 'asc')->get();

        return view('adminend.pages.order.edit', [
            'order'             => $order,
            'districts'         => $districts,
            'shippingAddresses' => $shippingAddresses,
            'orderStatus'       => $orderStatus,
            'currency'          => 'tk'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'items'       => ['required'],
                'status_id'   => ['required', 'integer'],
                'shipping_id' => ['required', 'integer'],
                'district_id' => ['required', 'integer'],
                'address'     => ['required'],
            ]
        );

        $shippingId      = $request->input('shipping_id');
        $statusId        = $request->input('status_id', null);
        $deliveryCharge  = $request->input('delivery_charge', 0);
        $currentItems    = $request->input('items');
        $address         = $request->input('address');
        $phoneNumber     = $request->input('phone_number');
        $districtId      = $request->input('district_id');
        $isPaid          = $request->input('is_paid');

        // format items array
        $currentItems = collect($currentItems);
        $currentItems = $currentItems->flatten(2);

        $order = Order::find($id);
        $previousItems = $order->items;

        try {
            $order = Order::find($id);

            // Update shipping address
            if ($shippingId) {
                $shippingAddress               = Address::find($shippingId);
                $shippingAddress->district_id  = $districtId;
                $shippingAddress->phone_number = $phoneNumber;
                $shippingAddress->save();
            }

            $order->pg_id           = 1;
            $order->address         = $address;
            $order->status_id       = $statusId;
            $order->delivery_charge = $deliveryCharge;
            $order->is_paid         = $isPaid;
            $res = $order->save();
            if ($res) {
                $itemIds = [];
                foreach ($currentItems as $item) {
                    $itemIds[] = [
                        'order_id'        => $order->id,
                        'item_id'         => $item['product_id'],
                        'color_id'        => $item['color_id'],
                        'size_id'         => $item['size_id'],
                        'quantity'        => $item['quantity'],
                        'item_buy_price'  => $item['buy_price'],
                        'item_mrp'        => $item['mrp'],
                        'item_sell_price' => $item['sell_price'],
                        'item_discount'   => $item['discount']
                    ];
                }

                // Update items  stock
                $order->updateItemStock($previousItems, $currentItems, $statusId);

                // ditach and  attach order items
                $order->items()->detach();
                $order->items()->sync($itemIds);

                // attach order status
                $order->status()->syncWithoutDetaching([$statusId]);

                // Update order value
                $order->updateOrderValue($order);

                return back()->with('success', 'Order updated successfully');
            }
        } catch (\Exception $e) {
            info($e);

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
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'integer'],
            'item_id'  => ['required', 'integer'],
            'color_id' => ['required', 'integer'],
            'size_id'  => ['required', 'integer']
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $orderId = $request->input('order_id', null);
        $itemId  = $request->input('item_id', null);
        $colorId = $request->input('color_id', null);
        $sizeId  = $request->input('size_id', null);

        $order = Order::find($orderId);

        if (!$order) {
            return $this->sendError('Order not found');
        }

        try {
            DB::beginTransaction();

            $order->items()->wherePivot('item_id', $itemId)
                ->wherePivot('color_id', $colorId)
                ->wherePivot('size_id', $sizeId)
                ->detach();

            DB::commit();
            return $this->sendResponse(true, 'Item removed successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();

            return $this->sendError('Something went wrong');
        }
    }

    public function makePaid(Request $request)
    {
        $request->validate([
            'order_id' => ['required']
        ]);

        $orderId = $request->input('order_id', null);

        PaymentTransaction::whereIn('order_id', $orderId)->update(['status' => 'completed']);

        Order::whereIn('id', $orderId)->update(['is_paid' => 1]);

        return $this->sendResponse(null, 'Order paid successfully');
    }
}
