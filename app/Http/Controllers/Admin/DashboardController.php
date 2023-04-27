<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\UserEvent;
use App\Charts\SampleChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $now       = Carbon::now();
        $startDate = $request->input('start_date', $now);
        $endDate   = $request->input('end_date', $now);

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate   = Carbon::parse($endDate)->endOfDay();

        // Current order report
        $orderReport = Order::select(DB::raw('
            count(*) as order_count,
            SUM(payable_price) as order_value,
            SUM((CASE WHEN is_paid = 1 THEN 1 ELSE 0 END)) as paid_order,
            SUM((CASE WHEN is_paid = 1 THEN payable_price ELSE 0 END)) as paid_order_value,
            SUM((CASE WHEN is_paid = 0 THEN 1 ELSE 0 END)) as unpaid_order,
            SUM((CASE WHEN is_paid = 0 THEN payable_price ELSE 0 END)) as unpaid_order_value,
            SUM((CASE WHEN status_id = 1 THEN 1 ELSE 0 END)) as submitted_order,
            SUM((CASE WHEN status_id = 1 THEN payable_price ELSE 0 END)) as submitted_order_value,
            SUM((CASE WHEN status_id = 3 THEN 1 ELSE 0 END)) as canceled_order,
            SUM((CASE WHEN status_id = 3 THEN payable_price ELSE 0 END)) as canceled_order_value,
            SUM((CASE WHEN status_id = 7 THEN 1 ELSE 0 END)) as delivered_order,
            SUM((CASE WHEN status_id = 7 THEN payable_price ELSE 0 END)) as delivered_order_value,
            SUM((CASE WHEN status_id = 9 THEN 1 ELSE 0 END)) as returned_order,
            SUM((CASE WHEN status_id = 9 THEN payable_price ELSE 0 END)) as returned_order_value
        '))->whereBetween('created_at', [$startDate, $endDate])->first();

        // For previous report
        $difference = $startDate->copy()->diffInDays($endDate);
        $difference = $difference + 1;
        $pStartDate = $startDate->copy()->subDays($difference)->startOfDay();
        $pEndDate   = $startDate->copy()->subDays(1)->endOfDay();

        // Previous order report
        $pOrderReport = Order::select(DB::raw('
            count(*) as order_count,
            SUM(payable_price) as order_value,
            SUM((CASE WHEN is_paid = 1 THEN 1 ELSE 0 END)) as paid_order,
            SUM((CASE WHEN is_paid = 1 THEN payable_price ELSE 0 END)) as paid_order_value,
            SUM((CASE WHEN is_paid = 0 THEN 1 ELSE 0 END)) as unpaid_order,
            SUM((CASE WHEN is_paid = 0 THEN payable_price ELSE 0 END)) as unpaid_order_value,
            SUM((CASE WHEN status_id = 1 THEN 1 ELSE 0 END)) as submitted_order,
            SUM((CASE WHEN status_id = 1 THEN payable_price ELSE 0 END)) as submitted_order_value,
            SUM((CASE WHEN status_id = 3 THEN 1 ELSE 0 END)) as canceled_order,
            SUM((CASE WHEN status_id = 3 THEN payable_price ELSE 0 END)) as canceled_order_value,
            SUM((CASE WHEN status_id = 7 THEN 1 ELSE 0 END)) as delivered_order,
            SUM((CASE WHEN status_id = 7 THEN payable_price ELSE 0 END)) as delivered_order_value,
            SUM((CASE WHEN status_id = 9 THEN 1 ELSE 0 END)) as returned_order,
            SUM((CASE WHEN status_id = 9 THEN payable_price ELSE 0 END)) as returned_order_value
        '))->whereBetween('created_at', [$pStartDate, $pEndDate])->first();

        // Calculate order value percentage
        $positiveOrdersValuePercent = 0;
        $negativeOrdersValuePercent = 0;
        $neutralOrdersValuePercent  = 0;
        if ($orderReport->order_value > $pOrderReport->order_value) {
            $ordersValueDifference = $orderReport->order_value - $pOrderReport->order_value;
            if ($orderReport->order_value > 0) {
                $positiveOrdersValuePercent = ($ordersValueDifference * 100) / $orderReport->order_value;
            }
        } elseif ($orderReport->order_value < $pOrderReport->order_value) {
            $ordersValueDifference = $pOrderReport->order_value - $orderReport->order_value;
            if ($pOrderReport->order_value > 0) {
                $negativeOrdersValuePercent = ($ordersValueDifference * 100) / $pOrderReport->order_value;
            }
        } else {
            $neutralOrdersValuePercent = 0;
        }

        // Count all user
        $totalUser = User::count();

        // Calculate cart items value
        $cartValue = DB::table('cart_item')->select(DB::raw("SUM(sell_price) as cart_value"))->first();

        // Calculate number of login and current login user
        $userEvent = UserEvent::select(
            DB::raw("
                SUM(CASE WHEN event = 'customer-login' THEN 1 ELSE 0 END) as number_of_login,
                SUM(CASE WHEN (event = 'pageView' AND JSON_VALID(data) AND  JSON_EXTRACT(data, '$.page') ='home') THEN 1 ELSE 0 END) as number_of_browse,
                COUNT(DISTINCT user_id) as unique_user
            ")
        )->whereBetween('created_at', [$startDate, $endDate])->first();

        // Get latest five orders
        $orders = Order::take(5)->orderBy('created_at', 'DESC')->get();

        // Graph for order items and value
        $orderGraph = Order::leftJoin('order_item', 'orders.id', '=', 'order_item.order_id')
            ->select([DB::raw('(orders.created_at) as created_at'), DB::raw('SUM(order_item.quantity * order_item.sell_price) as item_subtotal'), DB::raw('COUNT(distinct orders.id) as order_count')])
            ->groupBy(DB::raw('date(orders.created_at)'))->whereBetween('orders.created_at', [$startDate, $endDate])->orderBy('orders.created_at', 'ASC')->get();

        $lables = $orderGraph->pluck('created_at')->map(function ($oat) {
            return $oat->format('d/m');
        });

        $orderItemAmount = $orderGraph->pluck('item_subtotal');
        $dataDate = $orderGraph->pluck('created_at');
        $dataOrdrCount = $orderGraph->pluck('order_count');

        $chart = new SampleChart;
        $chart->labels($lables);
        $chart->dataset('Amount', 'bar', $orderItemAmount);
        $chart->dataset('Order Count', 'line', $dataOrdrCount);
       
        return view('adminend.pages.dashboard', [
            'orderReport' => $orderReport,
            'totalUser'   => $totalUser,
            'cartValue'   => $cartValue,
            'userEvent'   => $userEvent,
            'orders'      => $orders,
            'chart'       => $chart,
            'positiveOrdersValuePercent' => $positiveOrdersValuePercent,
            'negativeOrdersValuePercent' => $negativeOrdersValuePercent,
            'neutralOrdersValuePercent'  => $neutralOrdersValuePercent
        ]);
    }
}