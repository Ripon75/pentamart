<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');
        $name     = $request->input('name', null);

        $areas = new Area();

        if ($name) {
            $areas = $areas->where('name', 'like', "%$name%");
        }

        $areas = $areas->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.area.index', [
            'areas' => $areas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('adminend.pages.area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:areas,name']
        ]);

        $name = $request->input('name', null);
        $slug = Str::slug($name, '-');

        $areaObj = new Area();

        $areaObj->name = $name;
        $areaObj->slug = $slug;
        $res = $areaObj->save();
        if ($res) {
            return redirect()->route('admin.areas.index')->with('message', 'Area created successfully');
        } else {
            return back()->with('error', 'Something went to wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $area = Area::find($id);

        if (!$area) {
            abort(404);
        }

        return view('adminend.pages.area.edit', [
            'area' => $area
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:areas,name,$id"]
        ]);

        $name = $request->input('name', null);
        $slug = Str::slug($name, '-');

        $area = Area::find($id);

        if (!$area) {
            abort(404);
        }

        $area->name = $name;
        $area->slug = $slug;
        $res = $area->save();
        if ($res) {
            return back()->with('message', 'Area updated successfully');
        } else {
            return back()->with('error', 'Something went to wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
