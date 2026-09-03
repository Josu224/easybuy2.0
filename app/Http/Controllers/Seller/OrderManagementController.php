<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManagementController extends Controller
{
    // Show seller orders
    public function index()
    {
        $orders = Order::whereHas('items.product', function($q) {
            $q->where('seller_id', Auth::id());
        })
        ->with('user', 'items.product')
        ->latest()
        ->get();

        return view('seller.orders', compact('orders'));
    }

    // Show single order for seller
    public function show($id)
    {
        $order = Order::whereHas('items.product', function($q) {
            $q->where('seller_id', Auth::id());
        })
        ->with('user', 'items.product')
        ->findOrFail($id);

        return view('seller.order-details', compact('order'));
    }

    // Accept order
    public function accept($id)
    {
        $order = $this->getSellerOrder($id);
        $order->update([
            'seller_agreement' => 'accepted',
            'seller_accepted_at' => now(),
            'status' => 'processing',
        ]);

        // Notify customer
        Notification::create([
            'user_id' => $order->user_id,
            'type' => 'order',
            'title' => '✅ Order Accepted',
            'message' => 'Your order ' . $order->order_number . ' has been accepted by the seller.',
            'link' => route('orders.show', $order->id),
        ]);

        return back()->with('success', 'Order accepted successfully!');
    }

    // Reject order
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $order = $this->getSellerOrder($id);
        $order->update([
            'seller_agreement' => 'rejected',
            'seller_rejection_reason' => $request->rejection_reason,
            'status' => 'cancelled',
        ]);

        // Restore stock
        foreach ($order->items as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        // Notify customer
        Notification::create([
            'user_id' => $order->user_id,
            'type' => 'order',
            'title' => '❌ Order Rejected',
            'message' => 'Your order ' . $order->order_number . ' was rejected. Reason: ' . $request->rejection_reason,
            'link' => route('orders.show', $order->id),
        ]);

        return back()->with('success', 'Order rejected successfully.');
    }

    // Mark product as sent
    public function markSent($id)
    {
        $order = $this->getSellerOrder($id);
        $order->update([
            'product_sent_at' => now(),
            'status' => 'shipped',
        ]);

        // Notify customer
        Notification::create([
            'user_id' => $order->user_id,
            'type' => 'order',
            'title' => '📦 Order Shipped',
            'message' => 'Your order ' . $order->order_number . ' has been shipped!',
            'link' => route('orders.show', $order->id),
        ]);

        return back()->with('success', 'Product marked as sent!');
    }

    // Helper to get seller's order
    private function getSellerOrder($id)
    {
        return Order::whereHas('items.product', function($q) {
            $q->where('seller_id', Auth::id());
        })->findOrFail($id);
    }
}