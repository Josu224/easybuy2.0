<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderActionsController extends Controller
{
    // Mark as received
    public function markReceived($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if (!$order->product_sent_at) {
            return back()->with('error', 'Product has not been sent yet!');
        }

        $order->update([
            'customer_received_at' => now(),
            'status' => 'delivered',
            'customer_dispute' => 'none',
        ]);

        // Notify seller
        foreach ($order->items as $item) {
            if ($item->product->seller_id) {
                Notification::create([
                    'user_id' => $item->product->seller_id,
                    'type' => 'order',
                    'title' => 'Order Received',
                    'message' => 'Customer ' . Auth::user()->name . ' has confirmed receiving order ' . $order->order_number,
                    'link' => route('seller.orders.show', $order->id),
                ]);
            }
        }

        return back()->with('success', 'Order marked as received!');
    }

    // Mark as NOT received (dispute)
    public function markNotReceived(Request $request, $id)
    {
        $request->validate([
            'dispute_reason' => 'required|string|max:1000',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if (!$order->product_sent_at) {
            return back()->with('error', 'Product has not been sent yet!');
        }

        $order->update([
            'customer_dispute' => 'not_received',
            'dispute_reason' => $request->dispute_reason,
            'disputed_at' => now(),
            'status' => 'disputed',
        ]);

        // Notify sellers
        foreach ($order->items as $item) {
            if ($item->product->seller_id) {
                Notification::create([
                    'user_id' => $item->product->seller_id,
                    'type' => 'dispute',
                    'title' => '⚠️ Dispute Filed',
                    'message' => 'Customer ' . Auth::user()->name . ' has filed a dispute for order ' . $order->order_number . '. Reason: ' . $request->dispute_reason,
                    'link' => route('seller.orders.show', $order->id),
                ]);
            }
        }

        // Notify admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'dispute',
                'title' => '⚠️ New Dispute',
                'message' => 'Customer ' . Auth::user()->name . ' has filed a dispute for order ' . $order->order_number . '. Reason: ' . $request->dispute_reason,
                'link' => route('admin.showOrder', $order->id),
            ]);
        }

        return back()->with('success', 'Your dispute has been submitted. Admin will review this.');
    }

    // Submit review
    public function review(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if (!$order->customer_received_at) {
            return back()->with('error', 'You must receive the order before reviewing!');
        }

        $order->update([
            'customer_rating' => $request->rating,
            'customer_review' => $request->review,
            'customer_reviewed_at' => now(),
        ]);

        // Notify seller
        foreach ($order->items as $item) {
            if ($item->product->seller_id) {
                Notification::create([
                    'user_id' => $item->product->seller_id,
                    'type' => 'review',
                    'title' => '⭐ New Review',
                    'message' => 'Customer ' . Auth::user()->name . ' left a ' . $request->rating . '-star review on order ' . $order->order_number,
                    'link' => route('seller.orders.show', $order->id),
                ]);
            }
        }

        // Notify admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'review',
                'title' => '⭐ New Review',
                'message' => 'Customer ' . Auth::user()->name . ' left a review on order ' . $order->order_number,
                'link' => route('admin.showOrder', $order->id),
            ]);
        }

        return back()->with('success', 'Thank you for your review!');
    }
}