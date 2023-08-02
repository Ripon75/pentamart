<?php

namespace App\Http\Controllers\Front;

use App\Models\Address;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $districts = District::where('status', 'active')->orderBy('name', 'asc')->get();

        return view('frontend.pages.my-address-create', [
            'districts' => $districts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required'],
            'address'     => ['required'],
            'district_id' => ['required'],
            'thana'       => ['required']
        ],
        [
            'district_id.required' => 'The district is required'
        ]);

        $title           = $request->input('title', null);
        $address         = $request->input('address', null);
        $phoneNumber     = $request->input('phone_number', null);
        $districtId      = $request->input('district_id', null);
        $thana           = $request->input('thana', null);
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
            $addressObj->district_id  = $districtId;
            $addressObj->thana        = $thana;
            $res = $addressObj->save();

            if ($res) {
                DB::commit();
                return back()->with('success', 'Address created successfully');
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $data  = Address::find($id);
        if (!$data) {
            abort(404);
        }

        $districts = District::where('status', 'active')->orderBy('name', 'asc')->get();

        return view('frontend.pages.my-address-edit', [
            'data'      => $data,
            'districts' => $districts
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address'     => ['required'],
            'district_id' => ['required'],
            'thana'       => ['required']
        ]);

        $address     = $request->input('address', null);
        $phoneNumber = $request->input('phone_number', null);
        $districtId  = $request->input('district_id', null);
        $thana       = $request->input('thana', null);

        try {
            DB::beginTransaction();
            $userAddress = Address::find($id);

            $userAddress->address      = $address;
            $userAddress->phone_number = $phoneNumber;
            $userAddress->district_id  = $districtId;
            $userAddress->thana        = $thana;
            $userAddress->save();
            DB::commit();

            return redirect()->route('my.address')->with('success', 'Address updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }
}
