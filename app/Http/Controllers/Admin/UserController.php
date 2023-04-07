<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Cart;
use App\Classes\Utility;
use App\Models\Permission;
use App\Models\SellPartner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $paginate    = config('crud.paginate.default');
        $name        = $request->input('name', null);
        $email       = $request->input('email', null);
        $phoneNumber = $request->input('phone_number', null);
        $roles       = $request->input('roles', null);

        $users = User::with(['roles']);

        if ($name) {
            $users = $users->where('name', 'like', "%{$name}%");
        }

        if ($email) {
            $users = $users->where('email', 'like', "%{$email}%");
        }

        if ($phoneNumber) {
            $users = $users->where('phone_number', 'like', "%{$phoneNumber}%");
        }

        if ($roles) {
            $users = $users->whereHas('roles', function($query) use ($roles) {
                $query->where('display_name', 'like', "%{$roles}%");
            });
        }

        $users = $users->paginate($paginate);

        return view('adminend.pages.user.index', [
            'users'     => $users,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $user          = User::find($id);
        $roles         = Role::get();
        $permissions   = Permission::orderBy('name', 'asc')->get();
        $userRoles     = $user->getRoles();
        $permissionIds = $user->permissions()->select('id')->get()->pluck('id')->all();

        return view('adminend.pages.user.edit', [
            'user'          => $user,
            'roles'         => $roles,
            'userRoles'     => $userRoles,
            'permissions'   => $permissions,
            'permissionIds' => $permissionIds
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        $roleID        = $request->input('role_id', []);
        $permissionIds = $request->input('permission_ids', []);

        $user->syncRoles($roleID);

        $user->syncPermissions($permissionIds);

        return redirect()->route('admin.users.index')->with('message', 'Update successfully');
    }

    public function userCreate(Request $request)
    {
        $roles        = Role::orderBy('name', 'ASC')->get();
        $sellPartners = SellPartner::orderBy('name', 'ASC')->get();

        return view('adminend.pages.user.create', [
            'roles'        => $roles,
            'sellPartners' => $sellPartners
        ]);
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name'            => ['required'],
            'email'           => ['nullable', 'email', 'unique:users'],
            'phone_number'    => ['required', 'unique:users'],
            'password'        => ['required'],
            'role_id'         => ['required'],
            'sell_partner_id' => ['required']
        ]);

        $name          = $request->input('name');
        $email         = $request->input('email', null);
        $phoneNumber   = $request->input('phone_number', null);
        $password      = $request->input('password');
        $roleId        = $request->input('role_id', []);
        $sellPartnerId = $request->input('sell_partner_id', null);
        $phoneNumber   = $this->formatPhoneNumber($phoneNumber);

        $user = User::where('phone_number', $phoneNumber)->first();
        if ($user) {
            return back()->with('error', 'User already exist');
        }

        $userObj = new User();

        $userObj->name                = $name;
        $userObj->email               = $email;
        $userObj->phone_number        = $phoneNumber;
        $userObj->ac_active           = 1;
        $userObj->terms_and_conditons = 1;
        $userObj->sell_partner_id     = $sellPartnerId;
        $userObj->password            = Hash::make($password);
        $res = $userObj->save();

        if($res) {
            $userObj->syncRoles($roleId);
            Utility::setUserEvent('admin-registration', [
                'user' => $userObj
            ]);
            $cart                    = new Cart();
            $cart->customer_id       = $userObj->id;
            $cart->delivery_type_id  = 1;
            $cart->payment_method_id = 1;
            $cart->save();

            return back()->with('message', 'User registration successfully');
        } else {
            return back()->with('error', 'Something went to wrong');
        }

    }

    public function loginCreate(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.orders.index');
        }

        return view('adminend.pages.user.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'password'     => ['required']
        ]);

        $phoneNumber = $request->input('phone_number', null);
        $password    = $request->input('password', null);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        if (Auth::attempt(['phone_number' => $phoneNumber, 'password' => $password])) {
            return redirect()->route('admin.orders.index');
        }else {
            return back()->with('error', 'User credentil does not match');
        }
    }

    public function formatPhoneNumber($phoneNumber)
    {
        if (str_starts_with($phoneNumber, '0')) {
            return $phoneNumber = '88'.$phoneNumber;
        } elseif (str_starts_with($phoneNumber, '1')) {
            return $phoneNumber = '880'.$phoneNumber;
        }elseif (str_starts_with($phoneNumber, '80')) {
            return $phoneNumber = '8'.$phoneNumber;
        } elseif(str_starts_with($phoneNumber, '+88')) {
            return $phoneNumber = substr($phoneNumber, 1);
        } else {
            return $phoneNumber = $phoneNumber;
        }
    }
}
