@extends('layouts.app')

@section('title', $product->product_name)

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.browse') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->product_name }}</li>
        </ol>
    </nav>

    <div class="card shadow">
        <div class="row g-0">
            <div class="col-md-6">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="img-fluid rounded-start" 
                         alt="{{ $product->product_name }}"
                         style="width: 100%; height: 400px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 400px;">
                        <i class="fas fa-image text-muted" style="font-size: 64px;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h2 class="card-title">{{ $product->product_name }}</h2>
                    
                    <p class="card-text">
                        <span class="badge bg-secondary">{{ $product->category }}</span>
                    </p>
                    
                    <h3 class="text-primary fw-bold">${{ number_format($product->price, 2) }}</h3>
                    
                    <hr>
                    
                    <h5>Description:</h5>
                    <p class="card-text">{{ $product->description ?: 'No description available.' }}</p>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <h5>Availability:</h5>
                        @if($product->stock_quantity > 20)
                            <span class="badge bg-success">In Stock ({{ $product->stock_quantity }} available)</span>
                        @elseif($product->stock_quantity > 5)
                            <span class="badge bg-info">Available ({{ $product->stock_quantity }} left)</span>
                        @elseif($product->stock_quantity > 0)
                            <span class="badge bg-warning text-dark">Low Stock - Only {{ $product->stock_quantity }} left!</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </div>

                    @if($product->seller)
                        <div class="mb-3">
                            <h5>Sold by:</h5>
                            <p class="mb-0">{{ $product->seller->name }}</p>
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        @auth
                            @if($product->stock_quantity > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Quantity:</span>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        🛒 Add to Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                Login to Add to Cart
                            </a>
                        @endauth
                        <a href="{{ route('products.browse') }}" class="btn btn-outline-secondary">
                            ← Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection