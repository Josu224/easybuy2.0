<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $request->quantity;
            
            if ($product->stock_quantity < $newQuantity) {
                return back()->with('error', 'Not enough stock available!');
            }
            
            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($cartId);

        if ($cart->product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully!');
    }

    public function remove($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Product removed from cart!');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully!');
    }
}