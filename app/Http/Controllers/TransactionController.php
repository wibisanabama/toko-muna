<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Transaction::with(['user', 'items.product']);

        if ($request->filled('search')) {
            $search = preg_replace('/[^0-9]/', '', $request->search);
            if ($search != '') {
                $query->where('id', (int)$search);
            }
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $transactions = $query->latest()->get();

        $users = \App\Models\User::all();

        return view('transactions.index', compact('transactions', 'users'));
    }

    public function show($id)
    {
        $transaction = \App\Models\Transaction::with(['items.product', 'user'])->findOrFail($id);
        return view('transactions.print', compact('transaction'));
    }
}
