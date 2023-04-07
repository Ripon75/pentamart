<?php

namespace App\Http\Controllers\admin;

use Setting;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Order;
use App\Classes\Bkash;
use App\Models\Product;
use App\Classes\Utility;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Exports\OrdersExport;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
use App\Events\ManualOrderCreate;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public $currency;

    public function __construct()
    {
        $this->currency = Setting::getValue('app_currency_symbol', null, 'Tk');
        $this->util     = new Utility;
    }

    public function index(Request $request)
    {
        $now           = Carbon::now();
        $startDate     = $request->input('start_date', null);
        $endDate       = $request->input('end_date', null);
        $action        = $request->input('action', null);
        $areaId        = $request->input('area_id', null);
        $dGateway      = $request->input('delivery_type_id', null);
        $pGateway      = $request->input('payment_method_id', null);
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

        if ($dGateway) {
            $orderObj = $orderObj->where('delivery_type_id', $dGateway);
        }

        if ($pGateway) {
            $orderObj = $orderObj->where('payment_method_id', $pGateway);
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
        $orderStatus = OrderStatus::where('seller_visibility', 1)->get();

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
        $shippingAddresses = UserAddress::where('user_id', $order->user_id)->get();
        $orderStatus       = $order->getNextStatus($order->current_status_id);

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
            'delivery_type_id'    => ['required', 'integer'],
            'payment_method_id'   => ['required', 'integer'],
            'shipping_address_id' => ['required', 'integer'],
            'area_id'             => ['required', 'integer'],
            'address'             => ['required'],
        ],
        [
            'shipping_address_id.required' => 'Please select shipping address'
        ]);

        $deliveryTypeId       = $request->input('delivery_type_id');
        $paymentMethodId      = $request->input('payment_method_id');
        $shippingAddressId    = $request->input('shipping_address_id');
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
        if ($shippingAddressId) {
            $shippingAddress               = UserAddress::find($shippingAddressId);
            $shippingAddress->address      = $address;
            $shippingAddress->phone_number = $phoneNumber;
            $shippingAddress->area_id      = $areaID;
            $shippingAddress->save();
        }

        if ($deliveryTypeId === '-1') {
            $deliveryTypeId = null;
        }

        // Update order and order details
        $order->delivery_type_id       = $deliveryTypeId;
        $order->payment_method_id      = $paymentMethodId;
        $order->shipping_address_id    = $shippingAddressId;
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
        $orderStatus       = OrderStatus::where('seller_visibility', 1)->get();

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
            'shipping_address_id'    => ['required'],
            'delivery_type_id'       => ['required'],
            'payment_method_id'      => ['required'],
            'shipping_address_title' => ['required_if:shipping_address_id,0'],
            'shipping_address_line'  => ['required_if:shipping_address_id,0'],
            'area_id'                => ['required_if:shipping_address_id,0'],
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
            'delivery_type_id.required'          => 'The delivery method is required',
            'payment_method_id.required'         => 'The payment method is required',
            'search_phone_number.required'       => 'The user phone is required',
        ]);

        $items             = $request->input('items', null);
        $userId            = $request->input('user_id', null);
        $shippingAddressId = $request->input('shipping_address_id', null);
        $deliveryTypeId    = $request->input('delivery_type_id', null);
        $paymentMethodId   = $request->input('payment_method_id', null);
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
        if ($shippingAddressId == 0) {
            $addressTitle = $request->input('shipping_address_title', null);
            $addressLine  = $request->input('shipping_address_line', null);
            $phoneNumber  = $request->input('phone_number', null);
            $areaId       = $request->input('area_id', null);
            $otherTitle   = $request->input('others_title', false);

            $addressTitle = $otherTitle ? $otherTitle : $addressTitle;

            // Check shipping address was already exist
            $checkShippingAddress = UserAddress::where('title', $addressTitle)->where('user_id', $userId)->first();
            if ($checkShippingAddress) {
                return back()->with('title_exist', 'The address title already taken');
            }

            $phoneNumber = $phoneNumber ? $phoneNumber : $searchPhoneNumber;

            $userAddressObj = new UserAddress();

            $userAddressObj->title        = $addressTitle;
            $userAddressObj->address      = $addressLine;
            $userAddressObj->phone_number = $phoneNumber;
            $userAddressObj->user_id      = $userId;
            $userAddressObj->area_id      = $areaId;
            $res = $userAddressObj->save();
        }

        // Create new order
        $orderObj = new Order();

        if ($deliveryTypeId === '-1') {
            $deliveryTypeId = null;
        }

        $orderObj->user_id             = $userId;
        $orderObj->shipping_address_id = $shippingAddressId == 0 ? $userAddressObj->id : $shippingAddressId;
        $orderObj->delivery_type_id    = $deliveryTypeId;
        $orderObj->payment_method_id   = $paymentMethodId;
        $orderObj->delivery_charge     = $deliveryCharge;
        $orderObj->is_paid             = $paymentStatus;
        $orderObj->ordered_at          = $orderedAt;
        $orderObj->created_by          = Auth::id();
        $orderObj->sell_partner_id     = Auth::user()->sell_partner_id;
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
            ManualOrderCreate::dispatch($orderObj, $now);

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
        return $this->util->makeResponse(null, 'Order paid successfully', 200);
    }

    public function prescriptionShow($id)
    {
        $prescriptions = Prescription::where('order_id', $id)->get();

        if (!$prescriptions) {
            abort(404);
        }

        return view('adminend.pages.prescription.show', [
            'prescriptions' => $prescriptions
        ]);
    }

    // For medipos
    public function sendOrderMedipos(Request $request)
    {
        $request->validate([
            'business_id' => ['required'],
            'branch_id'   => ['required'],
            'order_id'    => ['required']
        ]);

        $token      = $request->input('token');
        $businessId = $request->input('business_id', null);
        $branchId   = $request->input('branch_id', null);
        $orderId    = $request->input('order_id', null);

        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->find($orderId);

        if (!$order) {
            abort(404);
        }

        $baseURL = config('pos.api.base_url');
        $url     = "{$baseURL}/api/online/order/data/private/create";
        // $baseURL = "http://192.168.11.7/coreapi/public/index.php";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}"
            ])->post($url, [
            'business_id' => $businessId,
            'branch_id'   => $branchId,
            'order'       => $order
        ]);

        if ($response && $response['type']) {
            $order->pos_business_id = $businessId;
            $order->pos_branch_id   = $branchId;
            $order->save();

            return $this->util->makeResponse($response, $response['msg'], 200);
        } else {
            return $this->util->makeResponse($response, $response['msg'], 201);
        }
    }

    public function statusUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required'],
            'status'   => ['required'],
            'area_id'  => ['required']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->util->makeResponse(null, $validator->errors(), 403);
        }

        $token   = $request->input('token');
        $status  = $request->input('status');
        $orderId = $request->input('order_id', null);
        $areaId  = $request->input('area_id', null);
        $businessId = null;
        $branchId   = null;
        $areaName   = null;
        
        $order = Order::find($orderId);
        if ($order) {
            $businessId = $order->pos_business_id;
            $branchId = $order->pos_branch_id;
        }

        if (!$businessId || !$branchId) {
            return $this->util->makeResponse(null, 'Business or branch not found', 404);
        }

        $areaObj = Area::find($areaId);
        if ($areaObj) {
            $areaName = $areaObj->name;
        }

        $baseURL = config('pos.api.base_url');
        $url     = "{$baseURL}/api/online/order/data/private/status/change";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}"
            ])->post($url, [
            'business_id'     => $businessId,
            'branch_id'       => $branchId,
            'online_order_id' => $orderId,
            'status'          => $status,
            'area_name'       => $areaName,
        ]);

        return $response;
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

    public function bulkOrderCreate()
    {
        return view('adminend.pages.order.onclogy-bulk-order');
    }

    public function bulkOrderStore(Request $request)
    {
        $request->validate([
            'uploaded_file' => ['required', 'file', 'mimes:csv']
        ]);

        $now = Carbon::now();

        $file = $request->file('uploaded_file');

        $filename  = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();  //Get extension of uploaded file
        $tempPath  = $file->getRealPath();
        $fileSize  = $file->getSize();                     //Get size of uploaded file in bytes
        //Check for file extension and size
        $this->checkUploadedFileProperties($extension, $fileSize);
        //Where uploaded file will be stored on the server
        $location = 'uploads'; //Created an "uploads" folder for that
        // Upload file
        $file->move($location, $filename);
        // In case the uploaded file path is to be stored in the database
        $filepath = public_path($location . "/" . $filename);
        // Reading file
        $file = fopen($filepath, "r");

        $firstline = true;
        $refineData = [];

        while (($data = fgetcsv($file, 2500, ",")) !== false) {
            if (!$firstline) {
                // Get All data from csv
                $invoiceID    = trim($data['0']);
                $invoiceDate  = trim($data['1']);
                $productName  = trim($data['2']);
                $productRate  = trim($data['3']);
                $selligPrice  = trim($data['4']);
                $invoiceQty   = trim($data['5']);
                $customerName = trim($data['6']);
                $phoneNumber  = trim($data['7']);
                $address      = trim($data['8']);
                $areaName     = trim($data['9']);

                $_productSlug  = Str::slug($productName, '_');

                if (str_starts_with($phoneNumber, '0')) {
                    $phoneNumber = '88'.$phoneNumber;
                } else {
                    $phoneNumber = '880'.$phoneNumber;
                }

                // Generate array by unique index
                if (array_key_exists($invoiceID, $refineData)){
                    if (array_key_exists($_productSlug, $refineData[$invoiceID])) {
                        $refineData[$invoiceID][$_productSlug]['qty'] = $invoiceQty ? ($refineData[$invoiceID][$_productSlug]['qty'] + $invoiceQty) : $refineData[$invoiceID][$_productSlug]['qty'];
                    } else {
                        $refineData[$invoiceID][$_productSlug] = [
                            'date'          => $invoiceDate,
                            'product_name'  => $productName,
                            'product_mrp'   => $productRate ? $productRate : 0,
                            'selling_price' => $selligPrice ? $selligPrice : 0,
                            'qty'           => $invoiceQty ? $invoiceQty : 1,
                            'customer_name' => $customerName,
                            'phone_number'  => $phoneNumber,
                            'address'       => $address,
                            'area'          => $areaName
                        ];
                    }
                } else {
                    $refineData[$invoiceID][$_productSlug] = [
                        'date'          => $invoiceDate,
                        'product_name'  => $productName,
                        'product_mrp'   => $productRate ? $productRate : 0,
                        'selling_price' => $selligPrice ? $selligPrice : 0,
                        'qty'           => $invoiceQty ? $invoiceQty : 1,
                        'customer_name' => $customerName,
                        'phone_number'  => $phoneNumber,
                        'address'       => $address,
                        'area'          => $areaName
                    ];
                }
            }
            $firstline = false;
        }
        fclose($file);

        $mkey = null;
        try {
            DB::beginTransaction();
            // Insert order
            foreach ($refineData as $key => $items) {
                $mkey = $key;
                info($mkey);
                $orderItems = [];
                $orderObj = new Order();

                foreach ($items as $item) {
                    $customerID = null;
                    $password   = 'tdl@123456789#';

                    $invoiceDate  = $item['date'];
                    $productName  = $item['product_name'];
                    $mrp          = $item['product_mrp'];
                    $selligPrice  = $item['selling_price'];
                    $invoiceQty   = $item['qty'];
                    $customerName = $item['customer_name'];
                    $phoneNumber  = $item['phone_number'];
                    $address      = $item['address'];
                    $area         = $item['area'];

                    // Find or create order
                    $productID = null;
                    if ($productName) {
                        $productSlug = Str::slug($productName, '-');
                        $product     = Product::where('slug', $productSlug)->first();
                        if ($product) {
                            $productID = $product->id;
                        } else {
                            $salePercent = 0;
                            if ($selligPrice > 0 && $mrp) {
                                $discount    = $mrp - $selligPrice;
                                $salePercent = ($discount * 100) / $mrp;
                                $salePercent = number_format($salePercent, 0);
                            }

                            $productObj                  = new Product;
                            $productObj->slug            = $productSlug;
                            $productObj->name            = $productName;
                            $productObj->company_id      = 52;
                            $productObj->brand_id        = 55;
                            $productObj->mrp             = $mrp;
                            $productObj->selling_price   = $selligPrice;
                            $productObj->selling_percent = $salePercent;
                            $productObj->status          = 'activated';
                            $productObj->pack_name       = 'Pieces';
                            $productObj->pack_size       = 1;
                            $productObj->num_of_pack     = 5;
                            $productObj->save();
                            $productID = $productObj->id;
                        }
                    }

                    // Discount calculation
                    $discount = 0;
                    if ($selligPrice > 0) {
                        $discount = $mrp - $selligPrice;
                    }

                    // Geenerate order items
                    $orderItems[$productID] = [
                        'quantity'  => $invoiceQty,
                        'pack_size' => 1,
                        'item_mrp'  => $mrp,
                        'price'     => $selligPrice,
                        'discount'  => $discount,
                    ];

                    //Find or create customer
                    if ($phoneNumber) {
                        $customer = User::where('phone_number', $phoneNumber)->first();
                        if ($customer) {
                            $customerID = $customer->id;
                        } else {
                            $customerObj                      = new User();
                            $customerObj->name                = $customerName;
                            $customerObj->phone_number        = $phoneNumber;
                            $customerObj->password            = Hash::make($password);
                            $customerObj->terms_and_conditons = 1;
                            $customerObj->ac_active           = 1;
                            $customerObj->save();
                            $customerID = $customerObj->id;
                        }
                    }

                    // Find or create address
                    $areaID = null;
                    $addresssID = null;
                    if ($address) {
                        $userAddressObj = UserAddress::where('user_id', $customerID)->first();
                        if ($userAddressObj) {
                            $addresssID = $userAddressObj->id;
                        } else {
                            $userAddrObj               = new UserAddress();
                            $userAddrObj->title        = 'Home';
                            $userAddrObj->address      = $address;
                            $userAddrObj->user_id      = $customerID;
                            $userAddrObj->phone_number = $phoneNumber;

                            // Find or create area
                            if ($area) {
                                $areaSlug = Str::slug($area, '-');
                                $areaObj     = Area::where('slug', $areaSlug)->first();
                                if ($areaObj) {
                                    $areaID = $areaObj->id;
                                } else {
                                    $areaObj       = new Area();
                                    $areaObj->slug = $areaSlug;
                                    $areaObj->name = $area;
                                    $areaObj->save();
                                    $areaID = $areaObj->id;
                                }
                            }
                            $userAddrObj->area_id = $areaID;
                            $userAddrObj->save();
                            $addresssID = $userAddrObj->id;
                        }
                    }
                }

                // Create order
                $invoiceDate                   = Carbon::createFromFormat('m/d/Y', $invoiceDate)->format('Y-m-d');
                $orderObj->user_id             = $customerID;
                $orderObj->delivery_type_id    = 1;
                $orderObj->payment_method_id   = 1;
                $orderObj->shipping_address_id = $addresssID;
                $orderObj->is_paid             = 1;
                $orderObj->ref_code            = $key;
                $orderObj->delivery_charge     = 0;
                $orderObj->ordered_at          = $invoiceDate;
                $orderObj->created_by          = Auth::id();
                $res = $orderObj->save();
                if ($res) {
                    // Create order items
                    $orderObj->items()->sync($orderItems);
                    // Update order price
                    $orderObj->updateOrderValue($orderObj);
                    // Dispatch manual order create event
                    ManualOrderCreate::dispatch($orderObj, $now);
                    // Create payment transaction
                    $paymentTrx    = new PaymentTransaction();
                    $paymentTrxRes = $paymentTrx->make($orderObj->id, null, 'sale', 1, 'pending');
                }
            }
            DB::commit();

            return back()->with('message', 'File upload succesfully done');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went to wrong');
        }
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = ['csv']; //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    public function UploadPrescription($id)
    {
        return view('adminend.pages.order.upload-prescription', [
            'orderId' => $id
        ]);
    }

    public function UploadPrescriptionStore(Request $request, $id)
    {
        $request->validate([
            'files' => ['required']
        ]);

        $orderObj = Order::find($id);
        if (!$orderObj) {
            abort(404);
        }

        try {
            DB::beginTransaction();
            // Upload prescription
            if ($request->hasFile('files')) {
                $files           = $request->file('files');
                $prescriptionObj = new Prescription();
                $uploadPath      = $prescriptionObj->_getImageUploadPath();
                foreach ($files as $file) {
                    $path = Storage::put($uploadPath, $file);
                    Prescription::insert([
                        'order_id' => $orderObj->id,
                        'user_id'  => $orderObj->user_id,
                        'status'   => 'submitted',
                        'img_src'  => $path
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }

        return back()->with('message', 'File uploaded successfully done');
    }
}
