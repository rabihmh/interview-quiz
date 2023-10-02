<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function home(): View
    {
        $now = now();

        $ordersCountByStatus = Order::query()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        $orders_count = $ordersCountByStatus->sum('count');

        $earnings = Order::query()
            ->where('status', 'completed')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total');

        $earningsByMonth = Order::query()
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as earnings')
            ->where('status', 'completed')
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->pluck('earnings')
            ->toArray();
        return view('admin.home', compact('ordersCountByStatus', 'orders_count', 'earnings', 'earningsByMonth'));
    }
}
