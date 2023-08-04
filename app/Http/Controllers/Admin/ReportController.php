<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\OrdersReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function orderReport(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate   = $request->input('end_date', null);
        $action    = $request->input('action', null);

        $data = [];
        $orderObj = new Order();
        $orderObj = $orderObj->with(['status']);

        if ($startDate && $endDate) {
            $startDate = $startDate.' 00:00:00';
            $endDate   = $endDate.' 23:59:59';
            $orderObj  = $orderObj->whereBetween('created_at', [$startDate, $endDate]);
            $orderObj  = $orderObj->where('is_paid', 1);
            $data = $orderObj->orderBy('created_at', 'desc')->get();
        }

        if ($action === 'export') {
            return Excel::download(new OrdersReportExport($data), 'orders_report.csv');
        }

        return view('adminend.pages.reports.orderHistory.order-history', [
            'orders' => $data
        ]);
    }
}
