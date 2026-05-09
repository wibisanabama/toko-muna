<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     */
    public function index()
    {
        $today = date('Y-m-d');

        $todaySales = \App\Models\Transaction::whereDate('created_at', $today)->sum('total');
        $todayTransactionsCount = \App\Models\Transaction::whereDate('created_at', $today)->count();
        $totalProducts = \App\Models\Product::count();
        $lowStockCount = \App\Models\Product::where('stock', '<=', 5)->count();

        $last7Days = [];
        $daysIndo = [
            'Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab',
            'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $sales = \App\Models\Transaction::whereDate('created_at', $date)->sum('total');
            $dayName = date('D', strtotime($date));
            $last7Days[] = [
                'date' => $daysIndo[$dayName] ?? $dayName,
                'sales' => $sales
            ];
        }

        $recentTransactions = \App\Models\Transaction::with('user')->latest()->limit(5)->get();

        $topProducts = \App\Models\TransactionItem::with('product')
            ->select('product_id', \DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(4)
            ->get();

        $currentMonth = date('m');
        $currentYear = date('Y');
        $monthlyTransactions = \App\Models\Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $monthlyChartData = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dayDate = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $i);
            $revenue = $monthlyTransactions->filter(function($t) use ($dayDate) {
                return $t->created_at->format('Y-m-d') == $dayDate;
            })->sum('total');
            $monthlyChartData[] = [
                'day' => $i,
                'revenue' => $revenue
            ];
        }

        $cashCount = $monthlyTransactions->where('payment_method', 'cash')->count();
        $transferCount = $monthlyTransactions->where('payment_method', 'transfer')->count();

        return view('dashboard', compact(
            'todaySales',
            'todayTransactionsCount',
            'totalProducts',
            'lowStockCount',
            'last7Days',
            'recentTransactions',
            'topProducts',
            'monthlyChartData',
            'cashCount',
            'transferCount',
            'monthlyTransactions'
        ));
    }
}
