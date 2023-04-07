<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');
        $result   = Offer::where('type', 'quantity')->paginate($paginate);

        return view('adminend.pages.offers.offerOnQuantity.index', [
            'result' => $result
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.offers.offerOnQuantity.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', "unique:offers,name"],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date'],
            'items'      => ['required', 'array'],
            'status'     => ['required']
        ]);

        $name      = $request->input('name', null);
        $status    = $request->input('status', null);
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
            $offerObj->type       = 'quantity';
            $offerObj->start_date = $startDate;
            $offerObj->end_date   = $endDate;
            $res = $offerObj->save();

            if ($res) {
                $itemIds = [];
                foreach ($items as $item) {
                    $productId       = $item['product_id'];
                    $quantity        = $item['quantity'];
                    $discountAmount  = $item['discount_amount'];
                    $discountPercent = $item['discount_percent'];
                    $itemIds[$productId] = [
                        'product_id'       => $productId,
                        'quantity'         => $quantity,
                        'discount_amount'  => $discountAmount,
                        'discount_percent' => $discountPercent,
                    ];
                }

                $offerObj->productsQty()->sync($itemIds);
            }
            DB::commit();
            return back()->with('message', 'Offer created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('message', 'Something went to wrong');
        }
    }

    public function show($id)
    {
        $offer = Offer::find($id);

        return view('adminend.pages.offers.offerOnQuantity.show', [
            'offer' => $offer
        ]);
    }

    public function edit(Request $request, $id)
    {
        $offer = Offer::with(['productsQty'])->find($id);

        return view('adminend.pages.offers.offerOnQuantity.edit', [
            'data' => $offer
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => ['required', "unique:offers,name,$id"],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date'],
            'items'      => ['required', 'array'],
            'status'     => ['required']
        ]);

        $name      = $request->input('name', null);
        $status    = $request->input('status', null);
        $startDate = $request->input('start_date', null);
        $endDate   = $request->input('end_date', null);
        $items     = $request->input('items', []);
        $slug      = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $offer = Offer::find($id);

            $offer->name       = $name;
            $offer->slug       = $slug;
            $offer->status     = $status;
            $offer->type       = 'quantity';
            $offer->start_date = $startDate;
            $offer->end_date   = $endDate;
            $res = $offer->save();

            if ($res) {
                $itemIds = [];
                foreach ($items as $item) {
                    $productId       = $item['product_id'];
                    $quantity        = $item['quantity'];
                    $discountAmount  = $item['discount_amount'];
                    $discountPercent = $item['discount_percent'];
                    $itemIds[$productId] = [
                        'product_id'       => $productId,
                        'quantity'         => $quantity,
                        'discount_amount'  => $discountAmount,
                        'discount_percent' => $discountPercent,
                    ];
                }
                $offer->productsQty()->sync($itemIds);
            }
            DB::commit();
            return back()->with('message', 'Offer updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went to wrong');
        }
    }
}
