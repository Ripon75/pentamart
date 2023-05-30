<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliveryGateway;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class DeliveryGatewayController extends Controller
{
    public function index()
    {
        $defaultPagination = config('crud.paginate.default');

        $dgs = DeliveryGateway::orderBy('created_at', 'asc')->paginate($defaultPagination);

        return view('adminend.pages.deliveryGateway.index', [
            'dgs' => $dgs
        ]);
    }

    public function create()
    {
        return view('adminend.pages.deliveryGateway.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required'],
            'price'     => ['required'],
            'min_time'  => ['required'],
            'max_time'  => ['required'],
            'time_unit' => ['required']
        ]);

        $name       = $request->input('name', null);
        $price      = $request->input('price', null);
        $promoPrice = $request->input('promo_price', null);
        $minTime    = $request->input('min_time', null);
        $maxTime    = $request->input('max_time', null);
        $timeUnit   = $request->input('time_unit', null);
        $status     = $request->input('status', null);
        $slug       = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $dg = new DeliveryGateway();

            $dg->name        = $name;
            $dg->slug        = $slug;
            $dg->price       = $price;
            $dg->promo_price = $promoPrice;
            $dg->min_time    = $minTime;
            $dg->max_time    = $maxTime;
            $dg->time_unit   = $timeUnit;
            $dg->status      = $status;
            $dg->save();
            DB::commit();

            return redirect()->route('admin.deliveries.index')->with('success', 'Delevery gateway created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went worng');
        }
    }

    public function edit($id)
    {
        $dg = DeliveryGateway::find($id);

        if (!$dg) {
            abort(404);
        }

        return view('adminend.pages.deliveryGateway.edit', [
            'dg' => $dg
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => ['required'],
            'price'     => ['required'],
            'min_time'  => ['required'],
            'max_time'  => ['required'],
            'time_unit' => ['required']
        ]);

        $name       = $request->input('name', null);
        $price      = $request->input('price', null);
        $promoPrice = $request->input('promo_price', null);
        $minTime    = $request->input('min_time', null);
        $maxTime    = $request->input('max_time', null);
        $timeUnit   = $request->input('time_unit', null);
        $status     = $request->input('status', null);
        $slug       = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $dg = DeliveryGateway::find($id);

            $dg->name        = $name;
            $dg->slug        = $slug;
            $dg->price       = $price;
            $dg->promo_price = $promoPrice;
            $dg->min_time    = $minTime;
            $dg->max_time    = $maxTime;
            $dg->time_unit   = $timeUnit;
            $dg->status      = $status;
            $dg->save();
            DB::commit();

            return redirect()->route('admin.deliveries.index')->with('success', 'Delevery gateway updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went worng');
        }
    }
}
