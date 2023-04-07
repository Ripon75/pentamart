<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BSGSOfferController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');
        $result = Offer::with(['productsBSGSBuy'])->where('type', 'bsgs')->paginate($paginate);

        return view('adminend.pages.offers.offerOnBSGS.index', [
            'result' => $result
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.offers.offerOnBSGS.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', "unique:offers,name"],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date'],
            'items'      => ['required', 'array'],
            'status'     => ['requiredre']
        ]);

        $status    = $request->input('status', null);
        $name      = $request->input('name', null);
        $startDate = $request->input('start_date', null);
        $endDate   = $request->input('end_date', null);
        $slug      = Str::slug($name, '-');
        $items     = $request->input('items', []);

        try {
            DB::beginTransaction();

            $offerObj = new Offer();

            $offerObj->name       = $name;
            $offerObj->slug       = $slug;
            $offerObj->status     = $status;
            $offerObj->type       = 'bsgs';
            $offerObj->start_date = $startDate;
            $offerObj->end_date   = $endDate;
            $res = $offerObj->save();

            if ($res) {
                $itemIds = [];
                foreach ($items as $item) {
                    $buyProductId  = $item['buy_product_id'];
                    $byQty        = $item['by_qty'];
                    $getProductId = $item['get_product_id'];
                    $getQty       = $item['get_qty'];
                    $itemIds[$buyProductId] = [
                        'buy_product_id' => $buyProductId,
                        'buy_qty'        => $byQty,
                        'get_product_id' => $getProductId,
                        'get_qty'        => $getQty
                    ];
                }

                $offerObj->productsBSGS()->sync($itemIds);
            }
            DB::commit();
            return back()->with('message', 'BSGS offer created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went to wrong');
        }
    }

    public function show($id)
    {
        $offer = Offer::with(['productsBSGSBuy' => function($query) {
            $query->withTrashed();
        }])->find($id);

        return view('adminend.pages.offers.offerOnBSGS.show', [
            'offer' => $offer
        ]);
    }

    public function edit(Request $request, $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}
