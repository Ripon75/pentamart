<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');
        $name     = $request->input('name', null);

        $districts = new District();

        if ($name) {
            $districts = $districts->where('name', 'like', "%$name%");
        }

        $districts = $districts->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.district.index', [
            'districts' => $districts
        ]);
    }

    public function create()
    {
        return view('adminend.pages.district.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'unique:districts,name'],
            'delivery_charge' => ['required']
        ]);

        $name           = $request->input('name', null);
        $status         = $request->input('status', null);
        $deliveryCharge = $request->input('delivery_charge', null);
        $slug           = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $district = new District();

            $district->name            = $name;
            $district->slug            = $slug;
            $district->status          = $status;
            $district->delivery_charge = $deliveryCharge;
            $district->save();
            DB::commit();
            return redirect()->route('admin.districts.index')->with('success', 'District created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something weint wrong');
        }
    }

    public function edit($id)
    {
        $district = District::find($id);

        if (!$district) {
            abort(404);
        }

        return view('adminend.pages.district.edit', [
            'district' => $district
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => ['required', "unique:districts,name,$id"],
            'delivery_charge' => ['required']
        ]);

        $name           = $request->input('name', null);
        $status         = $request->input('status', null);
        $deliveryCharge = $request->input('delivery_charge', null);
        $slug           = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $districts = District::find($id);

            $districts->name            = $name;
            $districts->slug            = $slug;
            $districts->status          = $status;
            $districts->delivery_charge = $deliveryCharge;
            $districts->save();
            DB::commit();

            return redirect()->route('admin.districts.index')->with('success', 'District created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something weint wrong');
        }
    }
}
