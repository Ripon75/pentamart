<?php

namespace App\Http\Controllers\Front;

use App\Models\Area;
use App\Models\Cart;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index()
    {
        $result  = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('frontend.pages.my-address', [
            'result' => $result
        ]);
    }

    public function create() {
        $areas = Area::orderBy('name', 'asc')->get();

        return view('frontend.pages.my-address-create', [
            'areas' => $areas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => ['required'],
            'address' => ['required'],
            'area_id' => ['required']
        ],
        [
            'area_id.required' => 'The area is required'
        ]);

        $title           = $request->input('title', null);
        $address         = $request->input('address', null);
        $phoneNumber     = $request->input('phone_number', null);
        $areaId          = $request->input('area_id', null);
        $authUser        = Auth::user();
        $userPhoneNumber = $authUser->phone_number;

        $phoneNumber = $phoneNumber ? $phoneNumber : $userPhoneNumber;

        try {
            DB::beginTransaction();
            $addressObj = Address::where('title', $title)->where('user_id', $authUser->id)->first();
            if (!$addressObj) {
                $addressObj = new Address();
            }

            $addressObj->title        = $title;
            $addressObj->address      = $address;
            $addressObj->user_id      = $authUser->id;
            $addressObj->phone_number = $phoneNumber;
            $addressObj->area_id      = $areaId;
            $res = $addressObj->save();

            if ($res) {
                DB::commit();
                return redirect()->route('my.address')->with('success', 'Address created successfully');
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function shippingAddress(Request $request)
    {
        $id = $request->input('address_id', null);
        $shippingAddress = Address::find($id);
        if ($shippingAddress) {
            $res = [
                'status' => 'success',
                'result' => $shippingAddress
            ];

            return $res;
        }
    }

    public function edit($id)
    {
        $data  = Address::find($id);
        if (!$data) {
            abort(404);
        }

        $areas = Area::orderBy('name', 'asc')->get();

        return view('frontend.pages.my-address-edit', [
            'data'  => $data,
            'areas' => $areas
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => ['required'],
            'area_id' => ['required']
        ]);

        $address     = $request->input('address', null);
        $phoneNumber = $request->input('phone_number', null);
        $areaId      = $request->input('area_id', null);

        try {
            DB::beginTransaction();
            $userAddress = Address::find($id);

            $userAddress->address      = $address;
            $userAddress->phone_number = $phoneNumber;
            $userAddress->area_id      = $areaId;
            $userAddress->save();
            DB::commit();

            return redirect()->route('my.address')->with('success', 'Address updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function getArea($name)
    {
        if (!$name) {
            return $this->sendError('Area name not found');
        }

        if ($name) {
            $area = Area::where('name', $name)->first();
            if ($area) {
                return $this->sendResponse($area, 'Area single view');
            } else {
                $slug       = Str::slug($name, '-');
                $area       = new Area();
                $area->slug = $slug;
                $area->name = $name;
                $res = $area->save();
                if ($res) {
                return $this->sendResponse($area, 'Area single view');
                }
            }
        }
    }
}
