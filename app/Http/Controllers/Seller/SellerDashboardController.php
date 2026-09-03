<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerProducts = Product::where('seller_id', Auth::id());
        
        $stats = [
            'total_products' => $sellerProducts->count(),
            'total_sales' => Order::whereHas('items.product', function($q) {
                $q->where('seller_id', Auth::id());
            })->count(),
            'total_revenue' => Order::whereHas('items.product', function($q) {
                $q->where('seller_id', Auth::id());
            })->sum('total_amount'),
        ];

        $products = Product::where('seller_id', Auth::id())->latest()->get();
        $orders = Order::whereHas('items.product', function($q) {
            $q->where('seller_id', Auth::id());
        })->latest()->get();

        return view('seller.dashboard', compact('stats', 'products', 'orders'));
    }
}