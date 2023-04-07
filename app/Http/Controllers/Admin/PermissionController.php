<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $paginate  = config('crud.paginate.default');
        $searchKey = $request->input('search_keyword', null);

        $permissions = new Permission();

        if ($searchKey) {
            $permissions = $permissions->where('name', 'like', "{$searchKey}%")
                ->orWhere('display_name', 'like', "{$searchKey}%");
        }

        $permissions = $permissions->orderBy('name', 'asc')->paginate($paginate);

        return view('adminend.pages.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => ['required', "unique:permissions,display_name"]
        ]);

        $displayName = $request->input('display_name', null);
        $description = $request->input('description', null);
        $name        = Str::slug($displayName, '-');

        $permissionObj = new Permission();

        $permissionObj->name         = $name;
        $permissionObj->display_name = $displayName;
        $permissionObj->description  = $description;
        $res = $permissionObj->save();
        if ($res) {
            return redirect()->route('admin.permissions')->with('message', 'Permission created successfully');
        }
    }

    public function edit(Request $request, $id)
    {
        $permission = Permission::find($id);

        return view('adminend.pages.permission.edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'display_name' => ['required', "unique:permissions,display_name,$id"]
        ]);

        $displayName = $request->input('display_name', null);
        $description = $request->input('description', null);
        $name        = Str::slug($displayName, '-');

        $permissionObj = Permission::find($id);

        $permissionObj->name         = $name;
        $permissionObj->display_name = $displayName;
        $permissionObj->description  = $description;
        $res = $permissionObj->save();
        if ($res) {
            return redirect()->route('admin.permissions')->with('message', 'Permission updated successfully');
        }
    }
}
