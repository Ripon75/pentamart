<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $defaultPaginate = config('crud.paginate.default');

        $statuses = Status::orderBy('name', 'asc')->paginate($defaultPaginate);

        return view('adminend.pages.status.index', [
            'statuses' => $statuses
        ]);
    }

    public function create()
    {
        return view('adminend.pages.status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:statuses,name']
        ]);

        $name      = $request->input('name', null);
        $status    = $request->input('status', true);
        $bgColor   = $request->input('bg_color', null);
        $textColor = $request->input('text_color', null);

        try {
            DB::beginTransaction();

            $statusObj = new Status();

            $statusObj->name       = $name;
            $statusObj->slug       = Str::slug($name);
            $statusObj->status     = $status;
            $statusObj->bg_color   = $bgColor;
            $statusObj->text_color = $textColor;
            $statusObj->save();
            DB::commit();

            return redirect()->route('admin.order.statuses.index')->with('success', 'Status created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went to wrong');
        }
    }

    public function edit($id)
    {
        $status = Status::find($id);

        if (!$status) {
            abort(404);
        }

        return view('adminend.pages.status.edit', [
            'status' => $status
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:statuses,name,{$id}"]
        ]);

        $name      = $request->input('name', null);
        $status    = $request->input('status', 'active');
        $bgColor   = $request->input('bg_color', null);
        $textColor = $request->input('text_color', null);

        try {
            DB::beginTransaction();

            $statusObj = Status::find($id);

            $statusObj->name       = $name;
            $statusObj->slug       = Str::slug($name);
            $statusObj->status     = $status;
            $statusObj->bg_color   = $bgColor;
            $statusObj->text_color = $textColor;
            $statusObj->save();
            DB::commit();

            return redirect()->route('admin.order.statuses.index')->with('success', 'Status updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went to wrong');
        }
    }
}
