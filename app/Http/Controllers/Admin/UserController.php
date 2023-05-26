<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\CustomerRegistration;
use Illuminate\Support\Facades\DB;
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

    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get();

        return view('adminend.pages.user.create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => ['required'],
            'phone_number' => ['required', "unique:users,phone_number"],
            'email'        => ['nullable', 'email', "unique:users,email"],
        ]);

        $name        = $request->input('name', null);
        $email       = $request->input('email', null);
        $phoneNumber = $request->input('phone_number', null);
        $roleIds     = $request->input('role_ids', []);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);


        try {
            DB::beginTransaction();

            $user = new User();

            $user->name         = $name;
            $user->email        = $email;
            $user->phone_number = $phoneNumber;
            $res = $user->save();
            if ($res) {
                CustomerRegistration::dispatch($user);
                $user->syncRoles($roleIds);
            }
            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'User updated successfully');
        }
    }

    public function edit($id)
    {
        $user      = User::find($id);
        $roles     = Role::orderBy('name', 'asc')->get();
        $userRoles = $user->getRoles();

        if (!$user) {
            abort(404);
        }

        return view('adminend.pages.user.edit', [
            'user'      => $user,
            'roles'     => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => ['required'],
            'phone_number' => ['required', "unique:users,phone_number,$id"],
            'email'        => ['nullable', 'email', "unique:users,email,$id"],
        ]);

        $name        = $request->input('name', null);
        $email       = $request->input('email', null);
        $phoneNumber = $request->input('phone_number', null);
        $roleIds     = $request->input('role_ids', []);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);


        try {
            DB::beginTransaction();

            $user = User::find($id);

            $user->name         = $name;
            $user->email        = $email;
            $user->phone_number = $phoneNumber;
            $res = $user->save();
            if ($res) {
                $user->syncRoles($roleIds);
            }
            DB::commit();

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'User updated successfully');
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
