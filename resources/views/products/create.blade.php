@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">➕ Add New Product</h4>
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

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price ($):</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity:</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="{{ old('stock_quantity') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Clothing">Clothing</option>
                                <option value="Food">Food</option>
                                <option value="Books">Books</option>
                                <option value="Home & Garden">Home & Garden</option>
                                <option value="Sports">Sports</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image:</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Supported formats: JPG, JPEG, PNG, GIF (Max: 2MB)</small>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Add Product</button>
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