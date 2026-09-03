<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
        $categories = Product::distinct()->pluck('category');
        
        return view('products.index', compact('products', 'categories'));
    }

    public function browse(Request $request)
    {
        $query = Product::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('product_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Product::distinct()->pluck('category');
        
        return view('products.browse', compact('products', 'categories'));
    }
    
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
    
    public function create()
    {
        return view('products.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->all();
        
        if (auth()->user()->isSeller()) {
            $data['seller_id'] = auth()->id();
        } else {
            $data['seller_id'] = null;
        }
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        Product::create($data);
        
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('success', 'Product added successfully!');
        }
        
        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully!');
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        if (auth()->user()->isSeller() && $product->seller_id !== auth()->id()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'You can only edit your own products!');
        }
        
        return view('products.edit', compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $product = Product::findOrFail($id);
        
        if (auth()->user()->isSeller() && $product->seller_id !== auth()->id()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'You can only update your own products!');
        }
        
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        $product->update($data);
        
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully!');
        }
        
        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if (auth()->user()->isSeller() && $product->seller_id !== auth()->id()) {
            return redirect()->route('seller.dashboard')
                ->with('error', 'You can only delete your own products!');
        }
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('success', 'Product deleted successfully!');
        }
        
        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully!');
    }
}