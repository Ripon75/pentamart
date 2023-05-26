<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');
        $name     = $request->input('name', null);

        $areas = new Area();

        if ($name) {
            $areas = $areas->where('name', 'like', "%$name%");
        }

        $areas = $areas->orderBy('name', 'asc')->paginate($paginate);

        return view('adminend.pages.area.index', [
            'areas' => $areas
        ]);
    }

    public function create()
    {
        return view('adminend.pages.area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:areas,name']
        ]);

        $name = $request->input('name', null);
        $slug = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $area = new Area();

            $area->name = $name;
            $area->slug = $slug;
            $area->save();
            DB::commit();
            return redirect()->route('admin.areas.index')->with('success', 'Area created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something weint wrong');
        }
    }

    public function edit($id)
    {
        $area = Area::find($id);

        if (!$area) {
            abort(404);
        }

        return view('adminend.pages.area.edit', [
            'area' => $area
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:areas,name,$id"]
        ]);

        $name = $request->input('name', null);
        $slug = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $area = Area::find($id);

            $area->name = $name;
            $area->slug = $slug;
            $area->save();
            DB::commit();

            return redirect()->route('admin.areas.index')->with('success', 'Area created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something weint wrong');
        }
    }
}
