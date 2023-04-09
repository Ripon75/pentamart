<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Cart;
use App\Classes\Utility;
use App\Models\Permission;

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
