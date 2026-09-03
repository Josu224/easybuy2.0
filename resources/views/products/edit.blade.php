@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">✏️ Edit Product</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price ($):</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $product->price }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity:</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="{{ $product->stock_quantity }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Select Category</option>
                                @foreach(['Electronics', 'Clothing', 'Food', 'Books', 'Home & Garden', 'Sports', 'Other'] as $cat)
                                    <option value="{{ $cat }}" {{ $product->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image:</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current image" style="max-width: 200px;">
                                    <p class="text-muted mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            @if(auth()->user()->isSeller())
                                <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection