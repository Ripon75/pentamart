<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Rules\NotNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    // TODO:: move user model
    public function profileEdit()
    {
        $user = Auth::user();
        return view('frontend.pages.my-profile', [
            "user" => $user
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $id = Auth::id();

        $request->validate([
            'name'         => ['required', new NotNumeric],
            'email'        => ['nullable', 'email', "unique:users,email,$id"],
            'phone_number' => ['required', "unique:users,phone_number,$id"],
        ]);


        $name   = $request->input('name', null);
        $email  = $request->input('email', null);
        $phone  = $request->input('phone_number', null);

        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        $user->name         = $name;
        $user->email        = $email;
        $user->phone_number = $phone;
        $res = $user->save();

        // Return response
        if($res) {
            return back()->with('message', 'Profile update successfully');
        } else {
            return back()->with('error', 'Profile update failed');

        }
    }

    public function passwordEdit()
    {
        return view('frontend.pages.my-password');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password'          => ['required'],
            'new_password'              => ['required', 'confirmed'],
            'new_password_confirmation' => ['required']
        ]);

        $currentUser     = Auth::user();
        $currentPassword = $request->input('current_password');
        $newPassword     = $request->input('new_password');

        // Check curent password valid or not
        if (Hash::check($currentPassword, $currentUser->password)) {
            $currentUser->password = Hash::make($newPassword);
            $res = $currentUser->save();
            if($res) {
                return back()->with('message', 'Password update successfully');
            } else {
                return back()->with('failed', 'Password update failed');

            }
        } else {
            return back()->with('failed', 'Invalid current password');
        }
    }
}
