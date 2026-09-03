@extends('layouts.app')

@section('title', 'Browse Products')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Browse Products</h2>
            <p class="text-muted">{{ $products->total() }} products available</p>
        </div>
        <div class="col-md-6">
            <form action="{{ route('products.browse') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- Category Filter -->
    @if($categories->isNotEmpty())
    <div class="mb-4">
        <a href="{{ route('products.browse') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm mb-2">All Products</a>
        @foreach($categories as $category)
            @if($category)
                <a href="{{ route('products.browse', ['category' => $category]) }}" 
                   class="btn {{ request('category') == $category ? 'btn-primary' : 'btn-outline-primary' }} btn-sm mb-2">
                    {{ $category }}
                </a>
            @endif
        @endforeach
    </div>
    @endif

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 product-card">
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                            @else
                                <i class="fas fa-image text-muted" style="font-size: 48px;"></i>
                            @endif
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                {{ $product->product_name }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="mb-2">
                            @if($product->category)
                                <span class="badge bg-secondary">{{ $product->category }}</span>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <h5 class="text-primary mb-0 fw-bold">${{ number_format($product->price, 2) }}</h5>
                            @if($product->stock_quantity > 20)
                                <span class="badge badge-success">In Stock</span>
                            @elseif($product->stock_quantity > 5)
                                <span class="badge badge-info">Available</span>
                            @elseif($product->stock_quantity > 0)
                                <span class="badge badge-warning">Low Stock</span>
                            @else
                                <span class="badge badge-danger">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-box-open empty-icon"></i>
                    <h4>No Products Found</h4>
                    <p>Try different search terms or browse all categories.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection