<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
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
            'name'  => ['required'],
            'email' => ['nullable', 'email', "unique:users,email,$id"],
        ]);


        $name  = $request->input('name', null);
        $email = $request->input('email', null);

        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        $user->name  = $name;
        $user->email = $email;
        $res = $user->save();

        if($res) {
            return back()->with('message', 'Profile update successfully');
        } else {
            return back()->with('error', 'Profile update failed');
        }
    }
}
