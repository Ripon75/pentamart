<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrderStatus;
use App\Rules\NotNumeric;

class OrderStatusController extends Controller
{
    public function index(Request $request)
    {
        $orderStatuses = OrderStatus::orderBy('id', 'desc')->get();

        return view('adminend.pages.orderStatus.index', [
            'orderStatuses' => $orderStatuses
        ]);
    }

    public function Show($id)
    {
        return 'show';
    }

    public function create(Request $request)
    {
        return view('adminend.pages.orderStatus.create');
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

        $orderStatusObj = new OrderStatus();

        $orderStatusObj->name                = $name;
        $orderStatusObj->slug                = Str::slug($name);
        $orderStatusObj->customer_visibility = $customerVisibility;
        $orderStatusObj->seller_visibility   = $sellerVisibility;
        $orderStatusObj->description         = $description;
        $res = $orderStatusObj->save();

        return redirect()->route('admin.order-statuses.index')->with('message', 'Order status create successfully');

    }

    public function edit(Request $request, $id)
    {
        $orderStatus = OrderStatus::find($id);

        return view('adminend.pages.orderStatus.edit', [
            'orderStatus' => $orderStatus
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

        $orderStatusObj = OrderStatus::find($id);

        $orderStatusObj->name                = $name;
        $orderStatusObj->slug                = Str::slug($name);
        $orderStatusObj->customer_visibility = $customerVisibility;
        $orderStatusObj->seller_visibility   = $sellerVisibility;
        $orderStatusObj->description         = $description;
        $res = $orderStatusObj->save();

        return redirect()->route('admin.order-statuses.index')->with('message', 'Order status updated successfully');
    }
}
