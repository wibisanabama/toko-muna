<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Transaction::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('id', 'like', "%{$search}%");
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = \App\Models\Transaction::with(['items.product', 'user'])->findOrFail($id);
        return view('transactions.print', compact('transaction'));
    }
}
