<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Buy - @yield('title', 'Online Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
    Easy Buy
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.browse') ? 'active' : '' }}" href="{{ route('products.browse') }}">Products</a>
                    </li>
                    @auth
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    @endif

                    @if(auth()->user()->isSeller())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.orders') ? 'active' : '' }}" href="{{ route('seller.orders') }}">
                            <i class="fas fa-clipboard-list"></i>
                            Orders
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            Cart
                            @if(auth()->user()->carts->count() > 0)
                            <span class="badge bg-danger">{{ auth()->user()->carts->count() }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                            <i class="fas fa-receipt"></i>
                            My Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                            <i class="fas fa-bell"></i>
                            Notifications
                            @if(auth()->user()->unreadNotifications() > 0)
                            <span class="badge bg-danger">{{ auth()->user()->unreadNotifications() }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                            <i class="fas fa-user"></i>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row">
                <!-- Quick Links -->
                <div class="col-6 col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">QUICK LINKS</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products.browse') }}" class="text-secondary text-decoration-none">Products</a></li>
                        @auth
                        <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-secondary text-decoration-none">My Cart</a></li>
                        <li class="mb-2"><a href="{{ route('orders.index') }}" class="text-secondary text-decoration-none">My Orders</a></li>
                        @else
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-secondary text-decoration-none">Login</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-secondary text-decoration-none">Register</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Account -->
                <div class="col-6 col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">ACCOUNT</h6>
                    <ul class="list-unstyled">
                        @auth
                        <li class="mb-2"><a href="{{ route('profile.index') }}" class="text-secondary text-decoration-none">Profile Settings</a></li>
                        <li class="mb-2"><a href="{{ route('orders.index') }}" class="text-secondary text-decoration-none">Order History</a></li>
                        @if(auth()->user()->isSeller() || auth()->user()->isAdmin())
                        <li class="mb-2"><a href="{{ route('products.create') }}" class="text-secondary text-decoration-none">Add Product</a></li>
                        @endif
                        @else
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-secondary text-decoration-none">Login</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-secondary text-decoration-none">Create Account</a></li>
                        <li class="mb-2"><a href="{{ route('password.request') }}" class="text-secondary text-decoration-none">Forgot Password</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-6 col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">CONTACT US</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-secondary"><i class="fas fa-map-marker-alt me-2"></i>Lagos, Nigeria</li>
                        <li class="mb-2 text-secondary"><i class="fas fa-phone me-2"></i>+234 123 456 7890</li>
                        <li class="mb-2 text-secondary"><i class="fas fa-envelope me-2"></i>support@easybuy.com</li>
                    </ul>
                </div>

                <!-- Social -->
                <div class="col-6 col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">JOIN US ON</h6>
                    <div class="d-flex flex-column">
                        <a href="#" class="text-secondary text-decoration-none mb-2 d-flex align-items-center">
                            <i class="fab fa-facebook me-2" style="width: 20px;"></i> Facebook
                        </a>
                        <a href="#" class="text-secondary text-decoration-none mb-2 d-flex align-items-center">
                            <i class="fab fa-twitter me-2" style="width: 20px;"></i> Twitter
                        </a>
                        <a href="#" class="text-secondary text-decoration-none mb-2 d-flex align-items-center">
                            <i class="fab fa-instagram me-2" style="width: 20px;"></i> Instagram
                        </a>
                        <a href="#" class="text-secondary text-decoration-none mb-2 d-flex align-items-center">
                            <i class="fab fa-whatsapp me-2" style="width: 20px;"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <hr class="bg-secondary">

            <!-- Bottom Bar -->
            <div class="row pb-4">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h6 class="fw-bold mb-2">PAYMENT METHODS</h6>
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge bg-secondary">VISA</span>
                        <span class="badge bg-secondary">MasterCard</span>
                        <span class="badge bg-secondary">PayPal</span>
                        <span class="badge bg-secondary">Paystack</span>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="text-secondary mb-0">&copy; 2024 Easy Buy. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
