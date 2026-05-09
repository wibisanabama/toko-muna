<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
                  ->orWhere('barcode', 'like', "%{$searchTerm}%");
            });
        }
        
        $products = $query->paginate(12)->withQueryString();

        // Convert the products to a collection to pass to Alpine JS easily
        $productsForJs = $products->items();
        
        return view('pos.index', compact('products', 'productsForJs'));
    }

    /**
     * Store transaction (Mockup for now).
     */
    public function checkout(Request $request)
    {
        // TODO: Implement transaction saving in Todo #8
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil!',
        ]);
    }
}
