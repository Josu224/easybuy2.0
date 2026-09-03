<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total_products' => $products->count(),
            'total_value' => $products->sum(function($product) {
                return $product->price * $product->stock_quantity;
            }),
            'low_stock' => $products->where('stock_quantity', '<', 5)->count(),
        ];
        
        return view('dashboard', compact('products', 'stats'));
    }
}