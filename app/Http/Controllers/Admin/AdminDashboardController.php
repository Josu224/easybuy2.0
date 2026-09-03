<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'low_stock' => Product::where('stock_quantity', '<', 5)->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(10)->get();
        $recent_users = User::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_users'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function verifyOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'admin_verified_at' => now(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Order verified and completed successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }
        
        $user->delete();
        
        return back()->with('success', 'User deleted successfully!');
    }

    public function products()
    {
        $products = Product::with('seller')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return back()->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.order-details', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully!');
    }
}