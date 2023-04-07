<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');
        $purchaseOrders = Purchase::with(['purchaseItems'])->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.purchaseOrder.index', [
            'purchaseOrders' => $purchaseOrders
        ]);
    }

    public function create(Request $request)
    {
        $confirmStatusId = config('crud.confirmed_status_id');
        $paginate = config('crud.paginate.default');

        $orders = Order::with(['items'])->where('current_status_id', $confirmStatusId)
        ->orderBy('created_at', 'DESC')->paginate($paginate);

        return view('adminend.pages.purchaseOrder.create', [
            'orders' => $orders
        ]);
    }

    public function store(Request $request)
    {
        // $validator = $request->validate([
        //     'orders.*.*.pharmacy_id' => 'required',
        //     'orders.*.*.purchase_price' => 'required'
        // ]);

        $orders = $request->input('orders', []);
        $userId = Auth::id();
        $now    = Carbon::now();
        $purchaseIds = [];

        $collection = collect($orders);
        $pharmacyGroupData = $collection->flatten(1)->groupBy('pharmacy_id');

        try {
            DB::beginTransaction();
            
            foreach ($pharmacyGroupData as $key => $data) {
                $purchaseObj                  = new Purchase;
                $purchaseObj->purchased_by_id = $userId;
                $purchaseObj->order_id        = $data[0]['order_id'];
                $purchaseObj->pharmacy_id     = $key;
                $purchaseObj->purchased_at    = $now;
                $res = $purchaseObj->save();
                if ($res) {
                    $purchaseIds[] = $purchaseObj->id;
                    foreach ($data as $key => $item) {
                        $purchaseItemObj                  = new PurchaseItem;
                        $purchaseItemObj->purchased_id    = $purchaseObj->id;
                        $purchaseItemObj->item_id         = $item['item_id'];
                        $purchaseItemObj->mrp             = $item['mrp'];
                        $purchaseItemObj->selling_price   = $item['selling_price'];
                        $purchaseItemObj->purchased_price = $item['purchase_price'] ?? 0;
                        $purchaseItemObj->quantity        = $item['quantity'];
                        $purchaseItemObj->save();
                    }
                }
                DB::commit();
            }

            $purchahseOrders = Purchase::with(['purchaseItems', 'purchaseItems.item:id,name'])->whereIn('id', $purchaseIds)->get();

            return view('adminend.pages.purchaseOrder.purchase-invoices', [
                'purchahseOrders' => $purchahseOrders
            ]);

            return back()->with('message', 'Purchase order created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
            return back()->with('error', 'Something went to wrong');
        }
    }
}
