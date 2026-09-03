@extends('layouts.app')

@section('title', 'Easy Buy - Shop Smart')

@section('content')
<!-- Hero Carousel Section -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="hero-slide">
                <img src="{{ asset('images/hero/electronics.jpg') }}" alt="Electronics" class="hero-image position-center">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                            <h1 class="display-4 fw-bold text-white mb-3">Welcome to Easy Buy </h1>
                            <p class="lead text-white mb-4">Discover amazing electronics at unbeatable prices</p>
                            <a href="{{ route('products.browse', ['category' => 'Electronics']) }}" class="btn btn-light btn-lg">Shop Electronics</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="carousel-item">
            <div class="hero-slide">
                <img src="{{ asset('images/hero/food.jpg') }}" alt="Food and Groceries" class="hero-image position-center">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                            <h1 class="display-4 fw-bold text-white mb-3">Food & Groceries </h1>
                            <p class="lead text-white mb-4">Fresh groceries delivered to your doorstep</p>
                            <a href="{{ route('products.browse', ['category' => 'Food']) }}" class="btn btn-light btn-lg">Shop Groceries</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="carousel-item">
            <div class="hero-slide">
                <img src="{{ asset('images/hero/fashion.jpg') }}" alt="Fashion" class="hero-image position-top">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                            <h1 class="display-4 fw-bold text-white mb-3">Fashion & Style </h1>
                            <p class="lead text-white mb-4">Trendy fashion for every occasion</p>
                            <a href="{{ route('products.browse', ['category' => 'Clothing']) }}" class="btn btn-light btn-lg">Shop Fashion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="carousel-item">
            <div class="hero-slide">
                <img src="{{ asset('images/hero/gaming.jpg') }}" alt="Gaming" class="hero-image position-center">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                            <h1 class="display-4 fw-bold text-white mb-3">Gaming Zone </h1>
                            <p class="lead text-white mb-4">Level up with the latest gaming gear</p>
                            <a href="{{ route('products.browse', ['category' => 'Gaming']) }}" class="btn btn-light btn-lg">Shop Gaming</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="carousel-item">
            <div class="hero-slide">
                <img src="{{ asset('images/hero/shoes.jpg') }}" alt="Shoes" class="hero-image position-bottom">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                            <h1 class="display-4 fw-bold text-white mb-3">Step in Style </h1>
                            <p class="lead text-white mb-4">Find your perfect pair of shoes</p>
                            <a href="{{ route('products.browse', ['category' => 'Shoes']) }}" class="btn btn-light btn-lg">Shop Shoes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Category Quick Links -->
<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">Shop by Category</h2>
    <div class="row text-center">
        <div class="col-6 col-md-2 mb-3">
            <a href="{{ route('products.browse', ['category' => 'Electronics']) }}" class="text-decoration-none">
                <div class="category-icon rounded-circle mx-auto mb-2 overflow-hidden" style="width: 70px; height: 70px; border: 3px solid #2563EB;">
                    <img src="{{ asset('images/hero/electronics.jpg') }}" alt="Electronics" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="small text-dark fw-bold">Electronics</span>
            </a>
        </div>
        <div class="col-6 col-md-2 mb-3">
            <a href="{{ route('products.browse', ['category' => 'Food']) }}" class="text-decoration-none">
                <div class="category-icon rounded-circle mx-auto mb-2 overflow-hidden" style="width: 70px; height: 70px; border: 3px solid #16A34A;">
                    <img src="{{ asset('images/hero/food.jpg') }}" alt="Food" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="small text-dark fw-bold">Food & Groceries</span>
            </a>
        </div>
        <div class="col-6 col-md-2 mb-3">
            <a href="{{ route('products.browse', ['category' => 'Clothing']) }}" class="text-decoration-none">
                <div class="category-icon rounded-circle mx-auto mb-2 overflow-hidden" style="width: 70px; height: 70px; border: 3px solid #DB2777;">
                    <img src="{{ asset('images/hero/fashion.jpg') }}" alt="Fashion" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="small text-dark fw-bold">Fashion</span>
            </a>
        </div>
        <div class="col-6 col-md-2 mb-3">
            <a href="{{ route('products.browse', ['category' => 'Gaming']) }}" class="text-decoration-none">
                <div class="category-icon rounded-circle mx-auto mb-2 overflow-hidden" style="width: 70px; height: 70px; border: 3px solid #7C3AED;">
                    <img src="{{ asset('images/hero/gaming.jpg') }}" alt="Gaming" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="small text-dark fw-bold">Gaming</span>
            </a>
        </div>
        <div class="col-6 col-md-2 mb-3">
            <a href="{{ route('products.browse', ['category' => 'Shoes']) }}" class="text-decoration-none">
                <div class="category-icon rounded-circle mx-auto mb-2 overflow-hidden" style="width: 70px; height: 70px; border: 3px solid #F97316;">
                    <img src="{{ asset('images/hero/shoes.jpg') }}" alt="Shoes" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="small text-dark fw-bold">Shoes</span>
            </a>
        </div>
        <div class="col-6 col-md-2 mb-3">
            <a href="{{ route('products.browse') }}" class="text-decoration-none">
                <div class="category-icon rounded-circle mx-auto mb-2 overflow-hidden" style="width: 70px; height: 70px; border: 3px solid #6B7280;">
                    <img src="{{ asset('images/hero/electronics.jpg') }}" alt="All Categories" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <span class="small text-dark fw-bold">All Products</span>
            </a>
        </div>
    </div>
</div>

<!-- Trust Badges -->
<div class="container mt-4">
    <div class="row text-center py-4 bg-white rounded shadow-sm">
        <div class="col-6 col-md-3 mb-3">
            <i class="fas fa-truck text-primary" style="font-size: 32px;"></i>
            <h6 class="mt-2 mb-0 fw-bold">Fast Delivery</h6>
            <small class="text-muted">Nationwide shipping</small>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <i class="fas fa-shield-alt text-success" style="font-size: 32px;"></i>
            <h6 class="mt-2 mb-0 fw-bold">Secure Payment</h6>
            <small class="text-muted">100% protected</small>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <i class="fas fa-undo text-warning" style="font-size: 32px;"></i>
            <h6 class="mt-2 mb-0 fw-bold">Easy Returns</h6>
            <small class="text-muted">7-day guarantee</small>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <i class="fas fa-headset text-info" style="font-size: 32px;"></i>
            <h6 class="mt-2 mb-0 fw-bold">24/7 Support</h6>
            <small class="text-muted">Always here to help</small>
        </div>
    </div>
</div>

<!-- How It Works -->
<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">How It Works</h2>
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-primary text-white rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5 class="fw-bold">1. Browse Products</h5>
                    <p class="text-muted small">Explore our wide range of products from trusted sellers</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-success text-white rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5 class="fw-bold">2. Add to Cart</h5>
                    <p class="text-muted small">Select your items and add them to your shopping cart</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="bg-warning text-white rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h5 class="fw-bold">3. Checkout</h5>
                    <p class="text-muted small">Complete your order with secure payment options</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Become a Seller CTA (Only for guests) -->
@guest
<div class="container mt-5 mb-5">
    <div class="card bg-primary text-white border-0 rounded-lg shadow-lg">
        <div class="card-body p-5 text-center">
            <h2 class="text-white fw-bold mb-3">Start Selling on Easy Buy</h2>
            <p class="text-white-50 mb-4">Join thousands of sellers and grow your business today</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Become a Seller</a>
        </div>
    </div>
</div>
@endguest
@endsection