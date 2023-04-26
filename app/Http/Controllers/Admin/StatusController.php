<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use App\Rules\NotNumeric;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $statuses = Status::orderBy('id', 'desc')->get();

        return view('adminend.pages.status.index', [
            'statuses' => $statuses
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                => ['required', 'unique:order_statuses,name', new NotNumeric],
            'customer_visibility' => ['required', 'boolean'],
            'seller_visibility'   => ['required', 'boolean']
        ]);

        $name               = $request->input('name', null);
        $customerVisibility = $request->input('customer_visibility', false);
        $sellerVisibility   = $request->input('seller_visibility', false);
        $description        = $request->input('description', null);

        $statusObj = new Status();

        $statusObj->name                = $name;
        $statusObj->slug                = Str::slug($name);
        $statusObj->customer_visibility = $customerVisibility;
        $statusObj->seller_visibility   = $sellerVisibility;
        $statusObj->description         = $description;
        $statusObj->save();

        return redirect()->route('admin.order-statuses.index')->with('message', 'Order status create successfully');
    }

    public function edit(Request $request, $id)
    {
        $status = Status::find($id);

        return view('adminend.pages.status.edit', [
            'status' => $status
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'                => ['required', "unique:order_statuses,name,{$id}", new NotNumeric],
            'customer_visibility' => ['required', 'boolean'],
            'seller_visibility'   => ['required', 'boolean']
        ]);

        $name               = $request->input('name', null);
        $customerVisibility = $request->input('customer_visibility', false);
        $sellerVisibility   = $request->input('seller_visibility', false);
        $description        = $request->input('description', null);

        $statusObj = Status::find($id);

        $statusObj->name                = $name;
        $statusObj->slug                = Str::slug($name);
        $statusObj->customer_visibility = $customerVisibility;
        $statusObj->seller_visibility   = $sellerVisibility;
        $statusObj->description         = $description;
        $res = $statusObj->save();

        return redirect()->route('admin.order-statuses.index')->with('message', 'Order status updated successfully');
    }
}
