<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $paginate = config('crud.paginate.default');
        $roles    = Role::paginate($paginate);

       return view('adminend.pages.role.index', [
            'roles' => $roles
       ]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('adminend.pages.role.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name'   => ['required', "unique:roles"],
            'permission_ids' => ['required', 'array']
        ]);

        $displayName   = $request->input('display_name', null);
        $description   = $request->input('description', null);
        $permissionIds = $request->input('permission_ids', []);
        $name          = Str::slug($displayName, '-');

        try {
            DB::beginTransaction();
            $roleObj = new Role();

            $roleObj->display_name = $displayName;
            $roleObj->name         = $name;
            $roleObj->description  = $description;
            $res = $roleObj->save();
            if ($res) {
                $roleObj->syncPermissions($permissionIds);
                DB::commit();
            }

            return redirect()->route('admin.roles')->with('success', 'Role create successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        if (!$role) {
            abort(404);
        }

        $permissions   = Permission::orderBy('name', 'asc')->get();
        $permissionIds = $role->permissions()->select('id')->get()->pluck('id')->all();

        return view('adminend.pages.role.edit', [
            'role'          => $role,
            'permissions'   => $permissions,
            'permissionIds' => $permissionIds
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'display_name'   => ['required', "unique:roles,display_name,$id"],
        ]);

        $displayName   = $request->input('display_name', null);
        $description   = $request->input('description', null);
        $permissionIds = $request->input('permission_ids', []);

        try {
            DB::beginTransaction();
            $role = Role::find($id);

            $role->display_name = $displayName;
            $role->description  = $description;
            $res = $role->save();
            if ($res) {
                $role->syncPermissions($permissionIds);
                DB::commit();
            }

            return redirect()->route('admin.roles')->with('success', 'Role update successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }
}
