<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function create()
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

        try {
            DB::beginTransaction();

            $permission = new Permission();

            $permission->name         = $name;
            $permission->display_name = $displayName;
            $permission->description  = $description;
            $permission->save();
            DB::commit();
            return redirect()->route('admin.permissions')->with('success', 'Permission created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            abort(404);
        }

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

        try {
            DB::beginTransaction();

            $permission = Permission::find($id);

            $permission->name         = $name;
            $permission->display_name = $displayName;
            $permission->description  = $description;
            $permission->save();
            DB::commit();
            return redirect()->route('admin.permissions')->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }
}
