<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        
        $transactions = \App\Models\Transaction::with(['user', 'items.product'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total'),
            'average_transaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
        ];

        return view('reports.daily', compact('transactions', 'summary', 'date'));
    }

    public function monthly(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        
        $transactions = \App\Models\Transaction::with(['user'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total'),
            'average_transaction' => $transactions->count() > 0 ? $transactions->avg('total') : 0,
        ];

        // Prepare data for chart (daily revenue in the selected month)
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $chartData = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dayDate = sprintf('%04d-%02d-%02d', $year, $month, $i);
            $revenue = $transactions->filter(function($t) use ($dayDate) {
                return $t->created_at->format('Y-m-d') == $dayDate;
            })->sum('total');
            $chartData[] = [
                'day' => $i,
                'revenue' => $revenue
            ];
        }

        return view('reports.monthly', compact('transactions', 'summary', 'month', 'year', 'chartData'));
    }
}
