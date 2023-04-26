<?php

namespace App\Http\Controllers\Front;

use App\Models\Area;
use App\Models\Cart;
use App\Models\User;
use App\Classes\Utility;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    protected $util;
    public function __construct()
    {
        $this->util = new Utility();
    }

    public function index(Request $request)
    {
        $result  = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('frontend.pages.my-address', [
            'result' => $result
        ]);
    }

    public function create(Request $request)
    {
        $areas = Area::orderBy('name', 'asc')->get();

        return view('frontend.pages.my-address-create', [
            'areas' => $areas
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
            return $this->util->makeResponse(null, $validator->errors(), 400);
        }

        // Get input value from request
        $otherTitle      = $request->input('others_title', null);
        $title           = $request->input('title', null);
        $address         = $request->input('address', null);
        $phoneNumber     = $request->input('phone_number', null);
        $areaId          = $request->input('area_id', null);
        $userId          = Auth::id();
        $userPhoneNumber = Auth::user()->phone_number;

        $title       = $otherTitle ? $otherTitle : $title;
        $phoneNumber = $phoneNumber ? $phoneNumber : $userPhoneNumber;

        $checkShippingAddress = Address::where('title', $title)->where('user_id', $userId)->first();
        if ($checkShippingAddress) {
            return $this->util->makeResponse(null, 'Address title already taken', 400);
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

            return redirect()->back()->with('success', 'Address create sucessfully');
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

    public function edit(Request $request, $id)
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

    public function destroy($id)
    {
        $userAddress = Address::find($id);
        if (!$userAddress) {
            abort(404);
        }

        $userAddress->delete();

        return back()->with('message', 'Address delete successfully');
    }

    public function getArea($name)
    {
        if (!$name) {
            return $this->util->makeResponse(null, 'Area name not found', 400);
        }

        if ($name) {
            $area = Area::where('name', $name)->first();
            if ($area) {
                return $this->util->makeResponse($area, 'Area single view', 200);
            } else {
                $slug          = Str::slug($name, '-');
                $areaObj       = new Area();
                $areaObj->slug = $slug;
                $areaObj->name = $name;
                $res = $areaObj->save();
                if ($res) {
                return $this->util->makeResponse($areaObj, 'Area single view', 200);
                }
            }
        }
    }
}
