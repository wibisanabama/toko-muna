<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Display the POS interface.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        $products = $query->get();

        return view('pos.index', compact('products'));
    }

    /**
     * Store transaction.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer',
            'paid' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            $transactionItems = [];

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->find($item['id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk produk: {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $transactionItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                $product->stock -= $item['quantity'];
                $product->save();

                \App\Models\StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'notes' => 'Penjualan via POS',
                ]);
            }

            if ($request->paid < $total && $request->payment_method === 'cash') {
                throw new \Exception("Nominal pembayaran tunai kurang dari total.");
            }

            $change = $request->payment_method === 'cash' ? ($request->paid - $total) : 0;
            $paid = $request->payment_method === 'cash' ? $request->paid : $total;

            $transaction = \App\Models\Transaction::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'paid' => $paid,
                'change' => $change,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($transactionItems as $item) {
                $item['transaction_id'] = $transaction->id;
                \App\Models\TransactionItem::create($item);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'change' => $change,
                'transaction_id' => $transaction->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
