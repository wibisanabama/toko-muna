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
        
        // Widgets data
        $todaySales = \App\Models\Transaction::whereDate('created_at', $today)->sum('total');
        $todayTransactionsCount = \App\Models\Transaction::whereDate('created_at', $today)->count();
        $totalProducts = \App\Models\Product::count();
        $lowStockCount = \App\Models\Product::where('stock', '<=', 5)->count();

        // Chart: Last 7 days sales
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $sales = \App\Models\Transaction::whereDate('created_at', $date)->sum('total');
            $last7Days[] = [
                'date' => date('D', strtotime($date)),
                'sales' => $sales
            ];
        }

        // Recent Transactions
        $recentTransactions = \App\Models\Transaction::with('user')->latest()->limit(5)->get();

        // Top Selling Products (by quantity)
        $topProducts = \App\Models\TransactionItem::with('product')
            ->select('product_id', \DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'todaySales', 
            'todayTransactionsCount', 
            'totalProducts', 
            'lowStockCount',
            'last7Days',
            'recentTransactions',
            'topProducts'
        ));
    }
}
