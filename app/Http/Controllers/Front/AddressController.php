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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => ['required'],
            'address' => ['required'],
            'area_id' => ['required', 'integer']
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->appError($validator->errors());
        }

        $title           = $request->input('title', null);
        $address         = $request->input('address', null);
        $phoneNumber     = $request->input('phone_number', null);
        $areaId          = $request->input('area_id', null);
        $userId          = Auth::id();
        $userPhoneNumber = Auth::user()->phone_number;

        $phoneNumber = $phoneNumber ? $phoneNumber : $userPhoneNumber;

        try {
            DB::beginTransaction();
            $addressObj = Address::where('title', $title)->where('user_id', $userId)->first();
            if (!$addressObj) {
                $addressObj = new Address();
            }

            $addressObj->title        = $title;
            $addressObj->address      = $address;
            $addressObj->user_id      = $userId;
            $addressObj->phone_number = $phoneNumber;
            $addressObj->area_id      = $areaId;
            $res = $addressObj->save();

            if ($res) {
                $cartObj = new Cart();
                $cart    = $cartObj->getCurrentCustomerCart();
                $cart->address_id = $addressObj->id;
                $cart->save();

                DB::commit();
                return $this->appResponse($addressObj, 'Address create sucessfully');
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return $this->appError('Something went wrong');
        }
    }

    public function otherStore(Request $request)
    {
        $request->validate([
            'title'        => ['required'],
            'address'      => ['required'],
            'area_id'      => ['required'],
            'others_title' => ['required_if:title,Others']
        ],
        [
            'area_id.required'         => 'The area is required',
            'others_title.required_if' => 'The title field is required'
        ]);

        // Get input value from request
        $otherTitle      = $request->input('others_title', null);
        $title           = $request->input('title', null);
        $address         = $request->input('address', null);
        $phoneNumber     = $request->input('phone_number', null);
        $areaId          = $request->input('area_id', null);
        $requestUserId   = $request->input('user_id', null);
        $userId          = Auth::id();
        $userPhoneNumber = null;

        $title       = $otherTitle ? $otherTitle : $title;
        $userId      = $requestUserId ? $requestUserId : $userId;

        $user = User::find($userId);

        if ($user) {
            $userPhoneNumber = $user->phone_number;
        }

        $phoneNumber = $phoneNumber ? $phoneNumber : $userPhoneNumber;

        $checkUserAddress = Address::where('title', $title)
            ->where('user_id', $userId)->first();

        if ($checkUserAddress) {
            return back()->with('title_exist', 'Address title already taken');
        }

        $obj = new Address();

        $obj->title        = $title;
        $obj->address      = $address;
        $obj->user_id      = $userId;
        $obj->phone_number = $phoneNumber;
        $obj->area_id      = $areaId;
        $res = $obj->save();

        if ($res) {
            $cartObj = new Cart();
            $cart    = $cartObj->getCurrentCustomerCart();
            $cart->address_id = $obj->id;
            $cart->save();

            return redirect()->back()->with('success', 'Address create successfylly');
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

        $userAddress = Address::find($id);

        $userAddress->address      = $address;
        $userAddress->phone_number = $phoneNumber;
        $userAddress->area_id      = $areaId;
        $res = $userAddress->save();
        if ($res) {
            return back()->with('message', 'Address updated successfully');
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
