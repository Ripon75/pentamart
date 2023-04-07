<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderProcessingController extends Controller
{
    public function orderProcessing(Request $request, $id)
    {
        $order = Order::with(['items' => function($query) {
            $query->withTrashed();
        }])->find($id);

        return view('adminend.pages.orderProcessing.create', [
            'order' => $order
        ]);
    }
}
